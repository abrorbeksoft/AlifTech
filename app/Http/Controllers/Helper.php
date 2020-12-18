<?php


namespace App\Http\Controllers;


use App\Models\Contact;
use App\Models\Email;
use App\Models\Image;
use App\Models\Number;

trait Helper
{
    protected function storeContact($name,$image=null,$phone=null,$email=null)
    {

        $contact=Contact::where('name',$name)->first();
        if (isset($contact) && $contact->active==true )
        {
            return ['name'=>'Bunday foydalanuvchi mavjud'];
        }
        elseif (isset($contact) && $contact->active==false)
        {
            $contact->active=true;
            $contact->update();
            return $this->createEmailAndNumber($contact,$image,$phone,$email);
        }
        else
        {
            $temp=new Contact();
            $temp->name=$name;
            $temp->active=true;
            $temp->user_id=1;
            $temp->save();

            return $this->createEmailAndNumber($temp,$image,$phone,$email);

        }



    }
    protected function createEmailAndNumber(Contact $contact,$image,$phone,$email)
    {
        $fullresp=[];
        if ($image!=null)
        {
            $this->storeImage($contact,$image);
        }
        else
        {
            $this->storeImage($contact,'images/noimage.png');
        }

        if ($phone!=null)
        {
            $varNumber=Number::where('name',$phone)->first();
            $resp=$this->storeNumber($varNumber,$phone,$contact->id);
            $fullresp=array_merge($fullresp,$resp);
        }

        if ($email!=null)
        {
            $varEmail=Email::where('name',$email)->first();
            $resp=$this->storeEmail($varEmail,$email,$contact->id);
            $fullresp=array_merge($fullresp,$resp);
        }
        return $fullresp;
    }

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
        if(isset($check) && $check->active==true)
        {
            return ['email'=>'Bunday email foydalnuvchisi mavjud'];
        }
        else if (isset($check) && $check->active==false )
        {
            $check->name=$email;
            $check->active=true;
            $check->contact_id=$id;
            $check->update();
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

        if(isset($check) && $check->active==true)
        {
            return ['number'=>'Bunday raqam ishlatilmoqda'];
        }
        else if (isset($check) && $check->active==false)
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
