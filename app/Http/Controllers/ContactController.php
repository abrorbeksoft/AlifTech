<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Image;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:4|max:150',
            'image'=>'file',
            'phone'=>'string',
            'email' => 'email:rfc,dns'
        ]);
        $path='';
        $newcontact=null;
        if (!isNull($request->file('image')))
        {
            $path=$request->file('image')->store('images');
        }
        else
        {
            $path='images/noimage.png';
        }
        $contact=Contact::where('name',$request->name)->first();

        if (isset($contact) && $contact->active==true)
        {
            return redirect()->back()->withErrors(['name'=>'Bunday kontakt mavjud']);
        }
        elseif (isset($contact) && $contact->active==false)
        {
            $contact->name=$request->name;
            $contact->active=true;
            $contact->update();



        }
        else
        {
            $newcontact=new Contact();
            $newcontact->name=$request->name;
            $newcontact->active=true;
            $newcontact->user_id=1;
            $newcontact->save();
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('contact.show',['contact'=>$contact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contact.update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name'=>'required|string|min:4|max:50'
        ]);

        $contact->name=$request->name;
        $contact->update();

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if( $contact->image)
        {
            $contact->image->active=false;
            $contact->image->update();
        }

        foreach ($contact->numbers as $number)
        {
            $number->active=false;
            $number->update();
        }

        foreach ($contact->emails as $email) {
            $email->active=false;
            $email->update();
        }

        $contact->active=false;
        $contact->update();

        return redirect()->back();

    }
}
