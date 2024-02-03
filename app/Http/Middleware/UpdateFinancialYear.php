<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
/**
 * Middleware to update the financial year.
 *
 * This middleware checks if the current date is the last day of September
 * and updates the financial year in the database accordingly.
 */
class UpdateFinancialYear
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
        if (now()->month == 9 && now()->day == 30) {
        // update or create the financial year record
            \App\Models\FinancialYear::updateOrCreate(
                ['id' => 1], 
                ['year' => now()->year + 1]
            );
        }

        return $next($request);
    }
}
