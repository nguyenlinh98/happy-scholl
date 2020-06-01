<?php
/**
 * User: JohnAVu
 * Date: 2019-12-30
 * Time: 15:12
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageReadStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index($student_id)
    {
        Log::info('[NotificationController.index] Start...');
        $notifications = Message::getMessageByStudent($student_id);
        $check = Message::checkMessageRead($student_id);
        if($check > 0) {
            DB::transaction(function () use ($notifications, $student_id) {
                foreach($notifications as $item) {
                    MessageReadStatus::where('message_id', $item->message_id)
                                        ->where('student_id', $student_id)
                                        ->update(['read' => 1]);
                }
            });
        }
        Log::info('[NotificationController.index] End...');

        return view('front.notifications.index', compact('notifications','student_id'));
    }
}
