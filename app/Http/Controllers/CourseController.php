<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Overtrue\LaravelYouzan\Youzan;
use App\Models\Payment;
use App\Models\Subscription;
use Auth;

class CourseController extends Controller
{
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
     * Course introduction page.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return Illuminate\Contracts\View\View
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Course chapters page.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return Illuminate\Contracts\View\View
     */
    public function chapters(Course $course)
    {
        $chapters = $course->chapters->load('topics');

        // Check if user has subscribed to the course.
        $canshow = optional(Auth::user())->can('show', $course);

        return view('course.chapters', compact('course', 'chapters', 'canshow'));
    }

    /**
     * Course purchase page.
     *
     * @param  Illuminate\Database\Eloquent\Model\Course  $course
     * @return Illuminate\Contracts\View\View
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
}
