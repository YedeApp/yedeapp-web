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

        $chapters = $course->chapters()->ordered()->get();
        $topics = $course->topics()->ordered()->get();

        return view('course.create_and_edit', compact('course', 'chapters', 'topics'));
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
        $fields = $request->except('insert_chapters', 'update_chapters', 'delete_chapters');

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
        $data = $request->except('insert_chapters', 'update_chapters', 'delete_chapters');

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
     * Upload chapters of a course.
     *
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model\Course  $course
     * @return void
     */
    protected function updateChapters(Request $request, Course $course)
    {
        // Chapters updating, inserting and deleting
        $updateData = json_decode($request->update_chapters, true);
        $insertData = json_decode($request->insert_chapters, true);
        $deleteData = json_decode($request->delete_chapters, true);

        if (!empty($updateData)) {
            foreach ($updateData as $rs) {
                $chapter = Chapter::find($rs['id']);
                $chapter->name = $rs['name'];
                $chapter->sorting = $rs['sorting'];
                $chapter->save();
            }
        }

        if (!empty($insertData)) {
            // Fill current user's id into the inserting data
            $insertData = data_fill($insertData, '*.user_id', Auth::id());

            $course->chapters()->createMany($insertData);
        }

        if (!empty($deleteData)) {
            Chapter::destroy($deleteData);
        }
    }

}
