<?php

namespace App\Http\Controllers;
use \App\Articles;

use Illuminate\Http\Request;

class IndexController extends Controller
{
	public function index(){
		$obj = new \stdClass();
		$obj->articles = Articles::paginate(12);
		return view('index')->with('obj', $obj);
	}

	public function getArticles(){
		$extension = pathinfo($url, PATHINFO_EXTENSION);
		$filename = str_random(4).'-'.str_slug($title).'.'. $extension;
		//get file content from url
		$file = file_get_contents($url);
		$save = file_put_contents('images/'.$filename, $file);
		if($save){
			//transaction......
			DB::beginTransaction();
			try {
				Photo::create([
					'title' => $title,
					'filename'=> $filename
				]);
				var_dump('file downloaded to images folder and saved to database as well.......');
				DB::commit();
			} catch (Exception $e) {
				//delete if no db things........
				File::delete('images/'. $filename);
				DB::rollback();
			}

	    }
}
