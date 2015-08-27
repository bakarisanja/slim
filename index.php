<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';
include_once 'lib/functions.php';
/*
require user
*/
require_once 'lib/User.php';
\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get(
    '/',
    function () {

    }
);

// GET rerister/ registration form
$app->get(
    '/register',
    function() {

    }
);

// POST route rerister
$app->post(
    '/register',
    function () {
        //db for later check of existing username
        $u = new User();
        $conn = $u->connect();

        //cehck if some post params are missing
        if(empty($_POST['first_name']) 
            || empty($_POST['last_name']) 
            || empty($_POST['date_of_birth'])
            || empty($_POST['country'])
            || empty($_POST['username'])
            || empty($_POST['password'])
            || empty($_POST['email']))
        {
            returnError('Missing or empty post parameters.');
        }

        //assigning post paramms to variables
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $country = $_POST['country'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        //validation fo data
        if(!ctype_alpha($first_name)) returnError('All first_name chars must be english letters.');
        if(!ctype_alpha($last_name)) returnError('All last_name chars must be english letters.');
        if(!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date_of_birth)) returnError('Invalid date format.');
        if(!CheckIsAValidDate($date_of_birth)) returnError('Date is not valid');
        if(!CheckUserYears($date_of_birth)) returnError('Out of age range.');
        //country check remove coment at ip for real test...
        $ip = $_SERVER['REMOTE_ADDR'];
        $check_country = file_get_contents('http://ip-api.com/json/80.74.163.201'/*.$ip*/);
        $check_country = json_decode($check_country);
        $check_country = $check_country->country;
        if(strtolower($check_country) !== strtolower($country)) returnError('country doesn`t mach');
        if(!ctype_alpha($username)) returnError('All username chars must be english letters.');
        if(preg_match('/\s/',$password)) returnError('Password can`t contain any whitespaces.');
        if(strlen($password) < 6) returnError('Password must be longer then five characters.');
        if($u->checkUser($conn, $username)) returnError('Username alredy exists in database, chose anather');
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) returnError('Email is not valid.');

        //whriteing data in database
        $u->createUser($conn, $first_name, $last_name, $date_of_birth, $country,$ip , $username, $password, $email);
        //success message
        SuccessMessage($username);
    }
);

//POST ROUTE LOGIN
$app->post(
    '/login',
    function () {
        
        //check if some parrams are missing
        if(empty($_POST['username']) || empty($_POST['password'])){
            returnError('Missing or empty post parameters.');
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!ctype_alpha($username)) returnError('All username chars must be english letters.');
        if(preg_match('/\s/',$password)) returnError('Password can`t contain any whitespaces.');
        if(strlen($password) < 6) returnError('Password must be longer then five characters.');
        
        $u = new User();
        $conn = $u->connect();
        $u->loginUser($conn, $username, $password);
    }   
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
