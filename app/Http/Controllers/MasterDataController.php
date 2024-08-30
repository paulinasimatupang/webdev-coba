<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterDataController extends Controller
{
    public function index(){
        return view('apps.masterdata.list');
    }
}
