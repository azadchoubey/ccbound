<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use Auth;

class ActiveRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->getName() != 'enquiry.chatroom.show' && $request->route()->getName() != 'sale.chatroom.show') {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->active_chatroom_id != NULL) {
                    $user->active_chatroom_id = NULL;
                    $user->save();
                }
            }
        }
        return $next($request);
    }
}
