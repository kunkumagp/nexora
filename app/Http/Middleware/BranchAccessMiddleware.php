<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $branchId = $request->route('branch_id') ?? $request->input('branch_id');
        if ($branchId && $user && $user->branch_id !== $branchId) {
            abort(403, 'Unauthorized branch access');
        }
        return $next($request);
    }
}
