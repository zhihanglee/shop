<?php
/**
 * 邮箱注册验证
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailNotification;
use Illuminate\Http\Request;
use Exception;
use Cache;

class EmailVerificationController extends Controller
{
    /**
     * 邮箱验证
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function verify(Request $request)
    {
        // 从url获取email token
        $email = $request->input('email');
        $token = $request->input('token');
        if (!$email || !$token) {
            throw  new Exception('链接参数不合法');
        }
        //缓存中读取数据
        if ($token != Cache::get('email_verification_' . $email)) {
            throw  new Exception('验证链接不正确或者已过期');
        }
        if (!$user = User::where('email', $email)->first()) {
            throw  new Exception('用户不存在');
        }
        //验证后，将key删除
        Cache::forget('email_verification' . $email);
        $user->update(['email_verified' => true]);
        //返回视图
        return view('pages.success', ['msg' => '邮箱验证成功']);
    }

    /**
     * 主动发送信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function send(Request $request)
    {
        $user = $request->user();
        //激活
        if ($user->email_verified){
            throw  new  Exception('邮箱已验证');
        }
        
        $user->notify(new EmailNotification());
        return view('pages.success',['msg'=>'邮件发送成功']);
    }
}
