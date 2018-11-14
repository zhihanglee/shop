<?php
/**
 * 注册后自动发送邮件
 */

namespace App\Listeners;

use App\Notifications\EmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 注册后发送邮件
     * @param Registered $event
     */
    public function handle(Registered $event)
    {
        //获取刚注册的用户信息
        $user = $event->user;
        //发送通知
        $user->notify(new EmailNotification());
    }
}
