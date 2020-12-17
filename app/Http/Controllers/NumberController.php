<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Number;
use Illuminate\Http\Request;

class NumberController extends Controller
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
        //
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
            'number'=>'string|min:9|max:12'
        ]);


        $id=$request->id;
        $number=$request->number;
        $check=Number::where('name',$number)->first();

        if(isset($check) && $check->active==1)
        {
            return redirect()->back()->withErrors(['number'=>'Bunday raqam ishlatilmoqda']);
        }
        else if (isset($check) && $check->active==0 )
        {
            $check->name=$number;
            $check->active=true;
            $check->contact_id=$id;
            $check->update();
            return redirect()->back();
        }
        else
        {
            $temp=Number::where('active',false)->first();
            if ($temp==null)
            {
                $create=new Number();
                $create->name=$number;
                $create->contact_id=$id;
                $create->active=true;
                $create->save();
                return redirect()->back();

            }
            else
            {
                $temp->name=$number;
                $temp->active=true;
                $temp->contact_id=$id;
                $temp->update();
                return redirect()->back();

            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function show(Number $number)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function edit(Number $number)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Number $number)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Number  $number
     * @return \Illuminate\Http\Response
     */
    public function destroy(Number $number)
    {
        $number->active=false;
        $number->update();
        return redirect()->back();
    }
}
