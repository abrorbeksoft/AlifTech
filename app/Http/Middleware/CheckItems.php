<?php

namespace App\Http\Middleware;

use App\Models\Email;
use App\Models\Number;
use Closure;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class CheckItems
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
        $resp=[];
        $number=Number::where([['active','=',true],['name','=',$request->name]])->first();
        if (!isNull($number))
            $resp=array_merge($resp,['number'=>'Bunday raqam ishlatilmoqda']);

        $number=Email::where([['active','=',true],['name','=',$request->email]])->first();
        if (!isNull($number))
            $resp=array_merge($resp,['email'=>'Bunday email ishlatilmoqda']);
        if (count($resp)>0)
            return route('contact.create')->withErrors($resp);
        else
            return $next($request);
    }
}
