<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\SubscriptionModule;
use RealRashid\SweetAlert\Facades\Alert;

class SubscriptionModuleController extends Controller
{
    public function list(){
        $result = SubscriptionModule::orderBy('id','desc')->get();
        return view('admin/subscriptionmodule/list',compact('result'));
    }
    public function add(){
         $url = route('subscription.save');
        return view('admin/subscriptionmodule/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'plan_name' => 'required',
            'plan_price' => 'required',
            'plan_validity' => 'required|unique:subscription_modules,plan_validity',
            'plan_description' => 'required',
        ]);
        $subscription = new SubscriptionModule();
        $subscription->plan_name = $req->plan_name;
        $subscription->plan_price = $req->plan_price;
        $subscription->plan_validity = $req->plan_validity;
        $subscription->plan_description = $req->plan_description;
        $subscription->save();
        Alert::success('success','Subscription Module Added Successfully');
        return redirect()->route('subscription.list');
    }
     public function edit($id){
        $url = route('subscription.update', $id);
        $subscription = SubscriptionModule::where('id',$id)->first();
        $isEdit = isset($subscription);
        return view('admin/subscriptionmodule/add',compact('url','subscription','isEdit'));
    }
     public function update(Request $req, $id){
         $req->validate([
            'plan_name' => 'required',
            'plan_price' => 'required',
            'plan_description' => 'required',
        ]);
           $subscription = SubscriptionModule::find($id);
        $subscription->plan_name = $req->plan_name;
        $subscription->plan_price = $req->plan_price;
        $subscription->plan_validity = $req->plan_validity;
        $subscription->plan_description = $req->plan_description;
        $subscription->save();
        Alert::success('success','Subscription Module Updated Successfully');
        return redirect()->route('subscription.list');
     }
      public function view($id){
         $subscription = SubscriptionModule::findOrFail($id);
        return view('admin/subscriptionmodule/view',compact('subscription')); 
    }
     public function changeSubscriptionStatus(Request $req)
    {
        //dd($item);
        $doc = SubscriptionModule::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
}
