<?php

namespace App\Http\Controllers;
use Serverfireteam\Panel\CrudController;

use Illuminate\Http\Request;

class ArticlesController extends CrudController
{
    public function all($entity){
        parent::all($entity); 

        $this->grid = \DataGrid::source(new \App\Articles());
        $this->grid->add('id','ID', true)->style("width:100px");
        $this->grid->add('title','Title');
        $this->grid->add('description','Description');
        $this->addStylesToGrid();
                 
        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        $this->edit = \DataEdit::source(new \App\Articles());

        $this->edit->label('Edit Pages');
        $this->edit->add('title','Title', 'text')->rule('required|min:5');
        $this->edit->add('description','Description', 'text')->rule('required|min:5');
        // if($this->edit->status !== 'modify'){
        //     $this->edit->add('slug','Alias', 'text')->rule('required');
        // }else {
        //     $this->edit->add('slug','Alias', 'disable');
        // }
        $this->edit->add('article_url','Article Url', 'text');
        $this->edit->add('news_date', 'Articles Date', 'date')->format('Y-m-d')->rule('required');
        $this->edit->add('article_url','Article Url', 'text');
        $this->edit->add('image_url', 'Image URL', 'image')->move('images/articles');

        return $this->returnEditView();
    }    
}
