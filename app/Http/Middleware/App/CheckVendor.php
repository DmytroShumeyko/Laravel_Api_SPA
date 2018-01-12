<?php

namespace App\Http\Middleware\App;

use App\Vendor;
use Closure;

class CheckVendor
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('product.vendor_id')) {
            $vendors = auth()->user()->vendors;
            if ($vendors->contains('id', $request->input('product.vendor_id'))) {
                $vendor = Vendor::find($request->input('product.vendor_id'));
                $request->attributes->add(['vendor' => $vendor]);
                return $next($request);
            }
        }
        return response()->json(["error" => ["Access denied"]], 401);
    }
}
