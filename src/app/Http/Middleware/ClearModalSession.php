<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClearModalSession
{
    public function handle(Request $request, Closure $next)
    {
        // 飲食店一覧画面以外に移動したときにモーダルのセッションをクリア
        if (!$request->is('/') && !$request->is('login') && !$request->is('mypage')) {
            $request->session()->forget('showModal');
        }

        return $next($request);
    }
}
