<?php

namespace App\Http\Controllers;
use Serverfireteam\Panel\CrudController;
use \App\Articles;
use Illuminate\Http\Request;
use Exception;

class ArticlesController extends CrudController
{
    protected $paginationCount= 0;
    protected $currentPage = 1;
    protected $articlesCount = 0;

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
        // }else {
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
        return view('articles')->with('obj', $obj);
    }

    protected function setPageUrl($currentUrl) {
        if($currentUrl == null){
            return 'http://www.tert.am/am/news/'.date('Y/m/d').'/'.$this->currentPage;
        } else {
            if($this->paginationCount < $this->currentPage){
                $this->currentPage = 1;
                return 'http://www.tert.am/am/news/'.date("Y/m/d", time() - 60 * 60 * 24).'/'.$this->currentPage;
            }else {
                if($this->currentPage >= 11){
                    $newUrl = substr($currentUrl, 0, -2);
                } else {
                    $newUrl = substr($currentUrl, 0, -1);
                }
                return $newUrl.$this->currentPage;
            }
        }
    }

    protected function getPaginationCount($articlesPagination){
        if(strlen($articlesPagination) < 10){
            return false;
        }
        $DOM = new \DOMDocument('1.0', 'utf-8');
        $DOM->loadHTML(mb_convert_encoding($articlesPagination, 'HTML-ENTITIES', 'UTF-8'));
        $paginationLength = $DOM->getElementsByTagName('a')->length;
        if($paginationLength > 2){
            $lastPage = $this->clearString($DOM->getElementsByTagName('a')->item($paginationLength - 1)->nodeValue);
            if(trim($lastPage) == 'հաջորդ →'){
                $this->paginationCount = intval($this->clearString($DOM->getElementsByTagName('a')->item($paginationLength - 2)->nodeValue));
            } else {
                $this->paginationCount = $lastPage;
            }
        } else {
            $this->paginationCount = 1;
        }
    }

    public function getExternalArticles($currentUrl = null){
         try {
            $url = $this->setPageUrl($currentUrl);
            try{
                $content = file_get_contents($url);
            } catch(Exception $e) {
                $this->currentPage++;
                $this->getExternalArticles($url);
            }
            $first_step = explode( '<div id="right-col">' , $content );
            $second_step = explode("</div>", $first_step[1]);
            $this->getPaginationCount($second_step[12]);
            if($this->articlesCount == 0){
                Articles::truncate();
                foreach(glob(public_path().'/images/*.*') as $file){
                    if(is_file($file)) {
                        @unlink($file);
                    }
                }
            }
            for($i = 0; $i < 10; $i++){
                if($this->articlesCount == 100){
                    break;
                }
                try {
                    $insertResult = $this->insertOnDatabase($second_step[$i]);
                } catch(Exception $e){
                    break;
                }
                $this->articlesCount++;
            }
            if($this->articlesCount == 100){
                return response()->json(true);
            } else {
                $this->currentPage++;
                $this->getExternalArticles($url);
            }
        }  catch (Exception $e) {
            return response()->json(false);
        }
    }

    protected function clearString($string){
        return trim(str_replace('"', "", $string));
    }

    protected function insertOnDatabase($content){
        if(strlen($content) < 200){
            throw new \Exception('Articles the end');
        }
        $article = new Articles;
        $DOM = new \DOMDocument('1.0', 'utf-8');
        $DOM->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        $linkLength = $DOM->getElementsByTagName('a')->length;
        $imageLength = $DOM->getElementsByTagName('img')->length;
        if($linkLength > 6 && $imageLength < 1){
            throw new \Exception('Articles the end');
        }
        $article->article_url = $this->clearString($DOM->getElementsByTagName('a')->item($linkLength - 1)->getAttribute('href'));
        $article->description = $this->clearString($DOM->getElementsByTagName('a')->item($linkLength - 1)->nodeValue);
        $article->title = $this->clearString($DOM->getElementsByTagName('a')->item($linkLength - 2)->nodeValue);
        $images = $DOM->getElementsByTagName('img');
        foreach ($images as $image) {
            $article->image_url = $this->clearString($image->getAttribute('src'));
        }
        $dateString = $this->clearString($DOM->getElementsByTagName('p')->item(0)->nodeValue);
        $dateArray = explode('•', $dateString);
        $articleDate = explode('.', trim($dateArray[1]));
        $articleDate = array_reverse($articleDate);
        $article->date = implode("-",$articleDate).'-'.trim($dateArray[0]);
        $imageFileArray = explode("/", $article->image_url);
        $imageName = $imageFileArray[count($imageFileArray)-1];
        $getImageContent = file_get_contents($article->image_url);
        $uploadedImage = file_put_contents('images/'.$imageName, $getImageContent);
        if(!$uploadedImage){
            return false;
        }

        //\DB::beginTransaction(); //I have 2 options either left in the error case or continue
        //transaction i should use on for loop
        try {
                $article->save();
                //\DB::commit();
        } catch (Exception $e) {
            //delete if no db things........
            @unlink('images/'. $imageName);
            //\DB::rollback();
        }
    }
}
