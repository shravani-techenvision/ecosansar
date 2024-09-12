<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Contact;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function list()
   {
     $contacts = Contact::orderBy('id', 'DESC')->get();
     $data = compact('contacts');
     return view('admin.contact.list',compact('contacts'));
   }

   public function add()
   {
       $url = route('contact.save');
        $data = compact('url');

    return view('admin/contact/add')->with($data);
   }

   public function save(Request $req)
   {
        // $req->validate([
        //     'email' => 'required|email',
        //     'mobile' => 'required|numeric|Max:10',
        //     'address' => 'required',
        //     'map' => 'required'
        // ]);

        $contact = new Contact;
        $contact->email = $req->email;
        $contact->mobile = $req->mobile;
        $contact->address = $req->address;
        $contact->map = $req->map;
        $contact->facebook = $req->facebook;
        $contact->insta = $req->insta;
        $contact->twitter = $req->twitter;
        $contact->linkedin = $req->linkedin;
        $contact->utube = $req->utube;
        $contact->save();

        Alert::success('success','Contact Details Added Successfully');
        return redirect()->route('contact.add');

   }

   public function edit($id)
   {
        $url = route('contact.update',$id);
        $contact = Contact::find($id);

        $data = compact('url','contact');

        return view('admin.contact.add')->with($data);
   }

   public function update(Request $req, $id)
   {
        $contact = Contact::find($id);
        $contact->email = $req->email;
        $contact->mobile = $req->mobile;
        $contact->address = $req->address;
        $contact->map = $req->map;
        $contact->facebook = $req->facebook;
        $contact->insta = $req->insta;
        $contact->twitter = $req->twitter;
        $contact->linkedin = $req->linkedin;
        $contact->utube = $req->utube;
        $contact->save();

        Alert::success('success','Contact Details Updated Successfully');
        return redirect()->route('contact.edit',$id);
   }

   public function delete($id)
   {
        Contact::where('id',$id)->delete();

        Alert::success('success','Contact Details Deleted Successfully');
        return redirect('contact/list');

   }
}
