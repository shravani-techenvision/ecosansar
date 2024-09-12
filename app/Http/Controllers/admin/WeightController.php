<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Weight;
use RealRashid\SweetAlert\Facades\Alert;

class WeightController extends Controller
{
    public function list(){
        $result = Weight::orderBy('id','DESC')->get();
        return view('admin/weight/list',compact('result'));
    }
    public function add(){
        $url = route('weight.save');
        return view('admin/weight/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'min_weight' => 'required',
            'min_measure' => 'required',
            'max_weight' => 'required',
            'max_measure' => 'required',
        ]);
        $weight = new Weight();
        $weight->min_weight = $req->min_weight;
        $weight->min_measure = $req->min_measure;
        $weight->max_weight = $req->max_weight;
        $weight->max_measure = $req->max_measure;
        $weight->save();
        Alert::success('success','Weight Added Successfully');
        return redirect()->route('weight.list');
    }
    public function edit($id){
        $url = route('weight.update', $id);
        $weight = Weight::where('id',$id)->first();
        return view('admin/weight/add',compact('url','weight'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'min_weight' => 'required',
            'min_measure' => 'required',
            'max_weight' => 'required',
            'max_measure' => 'required',
        ]);
        $weight = Weight::find($id);
        $weight->min_weight = $req->min_weight;
        $weight->min_measure = $req->min_measure;
        $weight->max_weight = $req->max_weight;
        $weight->max_measure = $req->max_measure;
        $weight->save();
        Alert::success('success','Weight Updated Successfully');
        return redirect()->route('weight.list');
    }
    public function delete($id){
        Weight::where('id',$id)->delete();
        Alert::success('success','Weight Deleted Successfully');
        return redirect()->route('weight.list');
    }
}
