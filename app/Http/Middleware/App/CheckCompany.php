<?php

namespace App\Http\Middleware\App;

use App\Company;
use Closure;

class CheckCompany
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
        if ($request->has('company_id')) {
            $companies = auth()->user()->companies;
            if ($companies->contains('id', $request->input('company_id'))) {
                $company = Company::find($request->input('company_id'));
                $request->attributes->add(['company' => $company]);
                return $next($request);
            }
        }
        return response()->json(["error" => ["Access denied"]], 401);
    }
}
