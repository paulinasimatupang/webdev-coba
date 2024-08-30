<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewFeaturesController extends Controller
{
    public function index(){
        return view('apps.new_features.list');
    }
}
