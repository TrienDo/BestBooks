<?php 
 require ("../vendor/autoload.php");	 
 require_once '../app/include/PassHash.php';
 require_once '../app/include/DbConnect.php';
 require_once '../app/include/Utils.php';
 require_once '../app/models/Book.php';
 require_once '../app/models/User.php';
 require_once '../app/services/UserService.php';
 
 
 \Slim\Slim::registerAutoloader();
 $app = new \Slim\Slim();
   
 
 //Restful for Users
 $app->post('/users', function () use ($app) {
    $jsonUser = $app->request->getBody(); 
    $objUser = json_decode($jsonUser, true);
     
    $res = UserService::createUser($objUser);
    $response = array();
    if ($res == USER_CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "You are successfully registered";
        Utils::echoResponse(201, $response); 
    }
    else if ($res == USER_CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registering. Please try again";
        Utils::echoResponse(200, $response); 
    }
    else if ($res == USER_ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this email already existed";
        Utils::echoResponse(200, $response); 
    } 
 });
 
 $app->get('/users', function () {
    /**
     * $user = User::where('email','trien.v.do@gmail.com')->get();
     *     if($user->count() > 0) 
     *         echo $user[0]->username; 
     *     else echo "not found";
     */
    $users = User::all();   
    echo $users->toJson();
 });
 
 
 /**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {
    // check for required params
    //Utils::verifyRequiredParams(array('email', 'password'));
    // reading post params
    //$email = $app->request()->post('email');
    //$password = $app->request()->post('password');
    $jsonLogin = $app->request->getBody(); 
    $objLogin = json_decode($jsonLogin, true);
    $response = array();
    // check for correct email and password
    $user = UserService::checkLogin($objLogin["email"], base64_decode($objLogin["password"]));
    
    if ($user != NULL) {
        $response["error"] = false;
        $response['username'] = $user['username'];
        $response['email'] = $user['email'];
        $response['apiKey'] = $user['apiKey'];
    } 
    else {
        // unknown error occurred
        $response['error'] = true;
        $response['message'] = "Invalid username or password. Please try again";
    }
    Utils::echoResponse(200, $response);
});

 
 
 $app->get('/books', function () {
  // Fetch all books
  $books = Book::all();
  echo $books->toJson();
 
 });
 
 $app->get('/books/:id', function ($book_id) use ($app) { 
  $book = Book::find($book_id); 
  if($book != null)
	echo $book->toJson();
  else echo "[]";
 });
 
 $app->post('/books', function () use ($app) {
   $title = $app->request->post('title');
   $author = $app->request->post('author');
   $year = $app->request->post('year');
 
  // Or create a new book
  $book = new Book(array(
   'title' => $title,
   'author' => $author,
   'year' => $year
  ));
  $book->save();
  echo $book->toJson();
 });
 
 $app->delete('/books/:id', function ($book_id) use ($app) { 
  $book = Book::find($book_id);
  $book->delete();
  $books = Book::all();
  echo $books->toJson();
 });
 
 $app->put('/books/:id', function($book_id) use($app) {
    $title = $app->request->put('title');
	$author = $app->request->put('author');
	$year = $app->request->put('year');  
	
	$book = Book::find($book_id);
	if($book != null)
	{
		$book->id = $book_id;
		$book->title = $title;
		$book->author = $author;
		$book->year = $year;
		$book->save();
		echo $book->toJson().$book_id.$title.$author.$year.$book->author.$book->id; 
		//http://stackoverflow.com/questions/23761425/get-put-params-with-slim-php		
	}
	else
		echo "Could not find";
 }); 
 
 $app->run();
?>