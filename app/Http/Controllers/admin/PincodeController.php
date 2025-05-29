<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Pincode;
use App\Models\frontend\PincodeCheckSave;
use RealRashid\SweetAlert\Facades\Alert;

class PincodeController extends Controller
{
   public function list(){
        $result = Pincode::orderBy('id','DESC')->get();
        return view('admin/pincode/list',compact('result'));
    }
    public function add(){
        $url = route('pincode.save');
        return view('admin/pincode/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'pincode' => 'required|unique:pincodes,pincode',
        ]);
        $pincode = new Pincode();
        $pincode->pincode = $req->pincode;
        $pincode->save();
        Alert::success('success','Pincode Added Successfully');
        return redirect()->route('pincode.list');
    }
    public function edit($id){
        $url = route('pincode.update', $id);
        $pincode = Pincode::where('id',$id)->first();
        return view('admin/pincode/add',compact('url','pincode'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'pincode' => 'required',
        ]);
        $pincode = Pincode::find($id);
        $pincode->pincode = $req->pincode;
        $pincode->save();
        Alert::success('success','Weight Updated Successfully');
        return redirect()->route('pincode.list');
    }
    public function delete($id){
        Pincode::where('id',$id)->delete();
        Alert::success('success','Pincode Deleted Successfully');
        return redirect()->route('pincode.list');
    }
     public function unavaillist(){
        $result = PincodeCheckSave::orderBy('id','DESC')->get();
        return view('admin/pincode/unavaillist',compact('result'));
    }
    
}
