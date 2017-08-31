<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use Serverfireteam\Panel\ObservantTrait;

class Articles extends Model {
	use ObservantTrait;
	
    protected $table = 'articles';
}