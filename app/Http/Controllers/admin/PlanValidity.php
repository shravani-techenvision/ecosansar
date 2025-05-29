<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanValidity extends Controller
{
    public function list(){
        return view('admin/planvalidity/list');
    }
    public function add(){
        return view('admin/planvalidity/add');
    }
}
