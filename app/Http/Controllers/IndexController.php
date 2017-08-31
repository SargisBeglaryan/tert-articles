<?php

namespace App\Http\Controllers;
use \App\Index;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
    	$obj = new \stdClass();
    	$obj->articles = Index::paginate(12);	
    	return view('index')->with('obj', $obj);
    }
}
