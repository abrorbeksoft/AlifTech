<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class PagerController extends Controller
{
    public function index()
    {
        $user=User::find(1);
        $contacts=$user->contacts()->where('active',1)->orderBy('created_at','desc')->paginate(15);
        return view('home',['contacts'=>$contacts]);
    }

    public function search(Request $request)
    {
        $q=$request->q;

        return response()->json(Contact::search($q)->get());

    }

}
