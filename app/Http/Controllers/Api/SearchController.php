<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public $query=null;
    public function searchByName(Request $request)
    {
        $q=$request->q;
        $contacts=Contact::where([['name','like','%'.$q.'%'],['active','=',true]])->get();
        return response()->json(ContactResource::collection($contacts));

    }

    public function searchByNumber(Request $request)
    {
        $this->query=$request->q;
        $contact=Contact::whereHas('numbers',function (Builder $builder){
            $builder->where('name','like','%'.$this->query.'%');
            $builder->where('active',true);
        })->get();
        return response()->json(ContactResource::collection($contact));

    }

    public function searchByEmail(Request $request)
    {
        $this->query=$request->q;
        $contact=Contact::whereHas('emails',function (Builder $builder){
            $builder->where('name','like','%'.$this->query.'%');
            $builder->where('active',true);

        })->get();
        return response()->json(ContactResource::collection($contact));
    }
}
