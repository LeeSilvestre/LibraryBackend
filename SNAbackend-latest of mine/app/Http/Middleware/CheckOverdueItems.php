<?php

namespace App\Http\Middleware;

use App\Models\borrowedItems;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckOverdueItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::now();
        borrowedItems::where('status', 'Borrowed')
            ->where('return_date', '<', $today)
            ->update(['status' => 'Overdue']);

        return $next($request);
    }
}
