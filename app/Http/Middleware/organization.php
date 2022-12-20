<?php

namespace App\Http\Middleware;

use App\Models\Organization as ModelsOrganization;
use Closure;
use Illuminate\Http\Request;

class organization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (null == $request->segment(2)) {
            
        }else{
            $orgId=$request->segment(2);
            if(ModelsOrganization::where('system_id', $orgId)->first()){
                return $next($request);
            }
        }
        abort(403, 'Missing Parameters. Request is not verifiable');
    }
}
