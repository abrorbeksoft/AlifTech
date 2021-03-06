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
        $contacts=$user->contacts()->where('active',1)->orderBy('updated_at','desc')->paginate(15);
        return view('home',['contacts'=>$contacts]);
    }



}
