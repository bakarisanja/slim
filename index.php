<?php
define('APPATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
require 'Slim/Slim.php';
include_once 'lib/functions.php';
include_once 'lib/User.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
//Modifing of 404

$app->notFound(function () use($app) {
    echo 'unavilable';
    die();
});

// POST route rerister
$app->post(
    '/register',
    function () {
        //db for later check of existing username
        $u = new User();

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
        if($u->checkUser($username)) returnError('Username alredy exists in database, chose anather');
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) returnError('Email is not valid.');

        //whriteing data in database
        $u->createUser($first_name, $last_name, $date_of_birth, $country,$ip , $username, $password, $email);
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
        $u->loginUser($username, $password);
    }   
);

//POST ROUTE REMOVE
$app->post(
    '/remove',
    function () {
        //check if some parrams are missing
        if(empty($_POST['username']) || empty($_POST['password'] || empty($_POST['token']))){
            returnError('Missing or empty post parameters.');
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $token = $_POST['token'];
        
        $u = new User();
        $test = $u->removeUser($username,$password,$token);
    }
);

$app->run();
