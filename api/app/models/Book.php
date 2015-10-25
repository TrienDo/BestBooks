<?php
use Illuminate\Database\Eloquent\Model;
class Book extends Model
{
	/*public $id = ""; 
	public $title = ""; 
    public $author = ""; 
	public $year = ""; */
	public $timestamps = false;
	protected $fillable = array('title','author','year');
	//protected $table = 'Books'; //name of table
}
?>