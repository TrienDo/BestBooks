<?php
 // Database information
 $settings = array(
  'driver' => 'mysql',
  'host' => 'localhost',
  'database' => 'bestbooks',
  'username' => 'admin',
  'password' => 'admin',
  'charset'   => 'utf8',
  'collation' => 'utf8_general_ci',
  'prefix' => ''
 );
 
 define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);
 // Bootstrap Eloquent ORM
 use Illuminate\Database\Capsule\Manager as Capsule;
//https://laracasts.com/lessons/how-to-use-eloquent-outside-of-laravel 
 $capsule = new Capsule; 
 $capsule->addConnection($settings);
 $capsule->setAsGlobal();
 $capsule->bootEloquent();
 /*Capsule::schema()->dropIfExists('users');
 Capsule::schema()->create('users', function($table)
 {
	$table->increments('id');
	$table->string('username');
	$table->string('password');	
    $table->string('email');
    $table->integer('type');
    $table->date('startDate');
    $table->date('lastLogin');
    $table->string('apiKey');
 });*/ 
 //create table
 /*Capsule::schema()->dropIfExists('books');
 Capsule::schema()->create('books', function($table)
 {
	$table->increments('id');
	$table->string('title');
	$table->string('author');	
 });
 Capsule::schema()->table('books', function($table)
	{
		$table->string('year')->nullable();
	});
 */
 
?>
