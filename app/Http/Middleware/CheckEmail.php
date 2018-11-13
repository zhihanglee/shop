<?php
//邮箱验证
namespace App\Http\Middleware;

use Closure;

class CheckEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * 如果用户的邮箱验证字段不是true 则返回验证邮箱的json
         */
        if (!$request->user()->email_verified) {
            if ($request->expectsJson()) {
                return response()->json(['msg' => '请验证邮箱'], 400);
            }
            return redirect(route('email_verify_notice'));
        }
        return $next($request);
    }
}
