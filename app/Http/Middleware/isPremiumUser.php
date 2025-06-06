<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isPremiumUser
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
    $user = $request->user();

    if ($user && ($user->user_trail > date('Y-m-d') || $user->billing_ends > date('Y-m-d'))) {
        return $next($request);
    }

    return redirect()->route('subscribe')->with('message', 'You are not a premium user, please subscribe to access this feature');
}

}
 