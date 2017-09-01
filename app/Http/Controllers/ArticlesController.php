<?php

namespace App\Http\Controllers;
use Serverfireteam\Panel\CrudController;
use \App\Articles;
use Illuminate\Http\Request;

class ArticlesController extends CrudController
{
    public function all($entity){
        parent::all($entity); 

        $this->filter = \DataFilter::source(new Articles);
        $this->filter->add('title', 'Title', 'text');
        $this->filter->submit('search');
        $this->filter->reset('reset');
        $this->filter->build();

        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id','ID', true)->style("width:100px");
        $this->grid->add('title','Title');
        $this->grid->add('description','Description');
        $this->addStylesToGrid();
                 
        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        $this->edit = \DataEdit::source(new Articles());

        $this->edit->label('Edit Pages');
        $this->edit->add('title','Title', 'text')->rule('required|min:5');
        $this->edit->add('description','Description', 'textarea')->rule('required|min:5');
        // if($this->edit->status !== 'modify'){
        //     $this->edit->add('slug','Alias', 'text')->rule('required');
        // }else {
        //     $this->edit->add('slug','Alias', 'disable');
        // }
        $this->edit->add('article_url','Article Url', 'text');
        $this->edit->add('date', 'Article Date', 'date')->format('Y-m-ds')->rule('required');
        $this->edit->add('article_url','Article Url', 'text');
        $this->edit->add('image_url', 'Image URL', 'image')->move('images/articles');

        return $this->returnEditView();
    }

    public function allArticles(){
        $obj = new \stdClass();
        $obj->articles = Articles::paginate(12);
        return view('index')->with('obj', $obj);
    }
}
