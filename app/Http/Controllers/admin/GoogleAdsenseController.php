<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\GoogleAdsense;
use RealRashid\SweetAlert\Facades\Alert;

class GoogleAdsenseController extends Controller
{
     public function list(){
        $result = GoogleAdsense::orderBy('id','DESC')->get();
        return view('admin/googleadsense/list',compact('result'));
    }
     public function add(){
        $url = route('googleadsense.save');
        return view('admin/googleadsense/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'place_of_adsense' => 'required',
        ]);
        $gadsense = new GoogleAdsense();
        $gadsense->place_of_adsense = $req->place_of_adsense;
        $gadsense->adsense_script = $req->adsense_script;
        
        if($req->hasFile('adsense_image')){
                $aadhar_image = $req->file('adsense_image');
                $aadhar_fileexe = $aadhar_image->getClientOriginalExtension();
                $aadhar_filenm = 'google_adsense'.'_'.$req->place_of_adsense.'.'.$aadhar_fileexe;
                $req->file('adsense_image')->move('assets/images/Googleadsense', $aadhar_filenm);
                $gadsense->adsense_image = $aadhar_filenm;
            }
        $gadsense->save();
        Alert::success('success','Google Adsense Added Successfully');
        return redirect()->route('googleadsense.list');
    }
     public function edit($id){
        $url = route('googleadsense.update', $id);
        $gadsense = GoogleAdsense::where('id',$id)->first();
        return view('admin/googleadsense/add',compact('url','gadsense'));
    }
    public function update(Request $req, $id){
       $req->validate([
            'place_of_adsense' => 'required',
        ]);
         $gadsense = GoogleAdsense::find($id);
         $gadsense->place_of_adsense = $req->place_of_adsense;
        $gadsense->adsense_script = $req->adsense_script;
        
        if($req->hasFile('adsense_image')){
                $aadhar_image = $req->file('adsense_image');
                $aadhar_fileexe = $aadhar_image->getClientOriginalExtension();
                $aadhar_filenm = 'google_adsense'.'_'.$req->place_of_adsense.'.'.$aadhar_fileexe;
                $req->file('adsense_image')->move('assets/images/Googleadsense', $aadhar_filenm);
                $gadsense->adsense_image = $aadhar_filenm;
            }
        $gadsense->save();
        Alert::success('success','Google Adsense Updated Successfully');
        return redirect()->route('googleadsense.list');
    }
     public function delete($id){
        GoogleAdsense::where('id',$id)->delete();
        Alert::success('success','Google Adsense Deleted Successfully');
        return redirect()->route('googleadsense.list');
    }
    public function gadsense_status_update(Request $req)
    {
        //dd($item);
        $doc = GoogleAdsense::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
}
