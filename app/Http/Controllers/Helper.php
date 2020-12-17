<?php


namespace App\Http\Controllers;


use App\Models\Contact;
use App\Models\Email;
use App\Models\Image;
use App\Models\Number;

trait Helper
{
    protected function storeImage(Contact $contact,$path)
    {
        if (isset($contact->image))
        {
            $contact->image()->update([
                'name'=>$path
            ]);
        }
        else
        {
            $image=Image::where('active',0)->first();
            if (isset($image))
            {
                $image->name=$path;
                $image->active=true;
                $image->imageable_id=$contact->id;
                $image->update();
            }
            else
            {
                $contact->image()->create([
                    'name'=>$path,
                    'active'=>true
                ]);
            }

        }

    }
    protected function updateName(Contact $contact,$name)
    {
        $contact->name=$name;
        $contact->update();
    }
    protected function storeEmail(Email $check=null,$email,$id)
    {
        if(isset($check) && $check->active==1)
        {
            return ['email'=>'Bunday email foydalnuvchisi mavjud'];
        }
        else if (isset($check) && $check->active==0 )
        {
            $check->name=$email;
            $check->active=true;
            $check->contact_id=$id;
            $check->save();
            return ['email'=>''];
        }
        else
        {
            $temp=Email::where('active',false)->first();
            if ($temp==null)
            {
                $create=new Email();
                $create->name=$email;
                $create->contact_id=$id;
                $create->active=true;
                $create->save();
                return ['email'=>''];

            }
            else
            {
                $temp->name=$email;
                $temp->active=true;
                $temp->contact_id=$id;
                $temp->update();
                return ['email'=>''];
            }

        }
    }
    protected function storeNumber(Number $check=null,$number,$id)
    {

        if(isset($check) && $check->active==1)
        {
            return ['number'=>'Bunday raqam ishlatilmoqda'];
        }
        else if (isset($check) && $check->active==0 )
        {
            $check->name=$number;
            $check->active=true;
            $check->contact_id=$id;
            $check->update();
            return ['number'=>''];
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
                return ['number'=>''];

            }
            else
            {
                $temp->name=$number;
                $temp->active=true;
                $temp->contact_id=$id;
                $temp->update();
                return ['number'=>''];
            }

        }
    }
}
