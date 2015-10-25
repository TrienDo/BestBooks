<?php
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
	/*public $id = ""; 
	public $title = ""; 
    public $author = ""; 
	public $year = ""; */
	public $timestamps = false;
	protected $fillable = array('username','password','email','type','startDate','lastLogin','apiKey');
	//protected $table = 'users'; //name of table
}
?>