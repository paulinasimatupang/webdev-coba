<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardBaruController extends Controller
{
    public function index(){
        return view('apps.dashboard.list2');
    }
}
