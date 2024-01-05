<?php
namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class CheckDevice
{
    public function handle($request, Closure $next)
    {
        $agent = new Agent();

        // Nếu không phải là thiết bị di động, chuyển hướng đến trang chủ
        if (!$agent->isMobile()) {
            return redirect('/');
        }

        return $next($request);
    }
}
