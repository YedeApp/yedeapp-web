<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Handlers\ImageUploadHandler;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Payment;
use App\Models\Subscription;
use Overtrue\LaravelYouzan\Youzan;
use Auth;

class CourseController extends Controller
{
    /**
     * Set course cover's max-width to 600px
     *
     * @var int
     */
    protected $coverMaxWidth = 500;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'chapters']]);
    }

    /**
     * Introductions of a Course.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return \Illuminate\View\View
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Chapters of a Course.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return \Illuminate\View\View
     */
    public function chapters(Course $course)
    {
        $chapters = $course->chapters()->ordered()->get()->load('topics');

        // Check if the user has subscribed the course.
        $canshow = optional(Auth::user())->can('show', $course);

        return view('course.chapters', compact('course', 'chapters', 'canshow'));
    }

    /**
     * Create a new course.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return \Illuminate\View\View
     */
    public function create(Course $course)
	{
        // A new blank course has no chapters.
        $chapters = $topics = false;

		return view('course.create_and_edit', compact('course', 'chapters', 'topics'));
    }

    /**
     * Edit an existed Course.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return \Illuminate\View\View
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $chapters = $course->chapters()->select('id', 'name', 'sorting')->with('topics:id,title,chapter_id,sorting')->ordered()->get();

        return view('course.create_and_edit', compact('course', 'chapters'));
    }

    /**
     * Store a new creating course.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest\CourseRequest  $request
     * @param  \App\Handlers\ImageUploadHandler  $uploader
	 * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return void
     */
	public function store(CourseRequest $request, ImageUploadHandler $uploader, Course $course)
	{
        $fields = $request->except('chapters_data', 'deleted_data');

        $course->fill($fields);

        if ($path = $this->uploadImage($request, $uploader)) {
            $course->cover = $path;
        }

        $course->user_id = Auth::id();

        $course->save();

        // Update the chapters
        $this->updateChapters($request, $course);

		return redirect()->route('course.show', $course->slug)->with('message', '创建成功');
	}

    /**
     * Update an existed course.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest\CourseRequest  $request
     * @param  \App\Handlers\ImageUploadHandler  $uploader
	 * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return void
     */
	public function update(CourseRequest $request, ImageUploadHandler $uploader, Course $course)
	{
        $this->authorize('update', $course);

        // Update the chapters
        $this->updateChapters($request, $course);

        // Update the course
        $data = $request->except('chapters_data', 'deleted_data');

        if ($path = $this->uploadImage($request, $uploader)) {
            $data['cover'] = $path;
        }

        $course->update($data);

		return redirect()->route('course.chapters', $course->slug)->with('message', '更新成功');
    }

    /**
     * Course purchasing.
     *
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return \Illuminate\View\View
     */
    public function purchase(Course $course)
    {
        // Pass variables to purchase view
        $qrcode = '';
        $qrid = '';

        $result = Youzan::request('youzan.pay.qrcode.create', [
            'qr_type' => 'QR_TYPE_DYNAMIC',  // 这个就不要动了
            'qr_price' => $course->price,  // 金额：分
            'qr_name' => $course->name, // 收款理由
            'qr_source' => 'yedeapp', // 自定义字段，你可以设置为网站订单号
        ]);

        if ($result) {
            // Crate a new payment
            $payment = new Payment;
            $payment->user_id = Auth::id();
            $payment->course_id = $course->id;
            $payment->qr_id = $result['qr_id'];
            $payment->status = Payment::STATUS_PENDING;
            $payment->save();

            $qrcode = $result['qr_code'];
            $qrid = $result['qr_id'];
        }

        return view('course.purchase', compact('course', 'qrcode', 'qrid'));
    }

    /**
     * Callback for Youzan's invoking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function push(Request $request)
    {
        $type = $request->get('type');
        $status = $request->get('status');

        if ($type == 'TRADE_ORDER_STATE' && $status == 'TRADE_SUCCESS') {
            $order = Youzan::request('youzan.trade.get', ['tid' => $request->id]);
            $qrid = $order['trade']['qr_id'];
            $payment = Payment::where('qr_id', $qrid)->first();
        }

        if ($payment && $payment->status !== Payment::STATUS_SUCCEED) {
            $payment->status = Payment::STATUS_SUCCEED;
            $payment->save();

            // Register the subscription for the user if he/she didn't subscribe it.
            $subscription = Subscription::firstOrCreate([
                'user_id' => Auth::id(),
                'course_id' => $payment->course_id
            ]);
        }
    }

    /**
     * Query if the trade succeed from Youzan. if true, update user's subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return integer
     */
    public function pull(Request $request)
    {
        if ($request->qrid) {
            $payment = Payment::where('qr_id', $request->qrid)->first();
            $result = Youzan::request('youzan.trades.qr.get', [
                'qr_id' => $payment->qr_id,
                'status' => 'TRADE_RECEIVED'
            ]);

            if ($result['total_results'] > 0) {
                $payment->status = Payment::STATUS_SUCCEED;
                $payment->save();

                $subscription = Subscription::firstOrCreate([
                    'user_id' => Auth::id(),
                    'course_id' => $payment->course_id
                ]);

                return 1;
            }
        }

        return 0;
    }

    /**
     * Upload cover image of a course.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     * @param  \App\Handlers\ImageUploadHandler  $uploader
     * @return string
     */
    protected function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        if ($request->cover) {
            $result = $uploader->save($request->cover, 'courses', Auth::id(), $this->coverMaxWidth);
            if ($result) {
                return $result['path'];
            }
        }

        return false;
    }

    /**
     * Update chapters of a course.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return void
     */
    protected function updateChapters(Request $request, Course $course)
    {
        $chaptersData = json_decode($request->chapters_data, true);
        $deletedData = json_decode($request->deleted_data, true);

        if (isset($chaptersData)) {
            foreach ($chaptersData as $data) {
                // Use for later topics inserting
                $chapterId = '';

                // Update existed item
                if (isset($data['id'])) {
                    $chapterId = $data['id'];

                    $chapter = $course->chapters()->where('id', $chapterId)->first();
                    $chapter->name = $data['title'];
                    $chapter->sorting = $data['sorting'];
                    $chapter->save();

                } else {
                    // Insert new item
                    $chapter = $course->chapters()->create([
                        'name' => $data['title'],
                        'sorting' => $data['sorting'],
                        'user_id' => Auth::id()
                    ]);

                    $chapterId = $chapter->id;
                }

                // Handle topics
                if (isset($data['topics'])) {

                    foreach ($data['topics'] as $rs) {
                        // Update topic
                        if (isset($rs['id'])) {
                            $topic = $course->topics()->where('id', $rs['id'])->first();
                            $topic->title = $rs['title'];
                            $topic->sorting = $rs['sorting'];
                            $topic->save();

                        } else {
                            // Insert topic
                            $course->topics()->create([
                                'title' => $rs['title'],
                                'sorting' => $rs['sorting'],
                                'chapter_id' => $chapterId,
                                'course_id' => $course->id,
                                'content' => 'This article is auto-created by chapter editor.',
                                'user_id' => Auth::id()
                            ]);
                        }
                    }
                } //end handle topics

            } //end chapters loop
        } //end hanlde chapters

        // Handle deleting
        if (isset($deletedData)) {
            if (isset($deletedData['chapters'])) {
                $course->chapters()->whereIn('id', $deletedData['chapters'])->delete();
            }

            if (isset($deletedData['topics'])) {
                $course->topics()->whereIn('id', $deletedData['topics'])->delete();
            }
        }

    }

}
