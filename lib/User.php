<?php
if ( ! defined('APPATH')) exit('No direct script access allowed');
include_once 'DB.php';
Class User
{
	/**
	 * @var object of db class
	 */
	private $db;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->db = new DB();
	}
	
	/**
	 * [checkUser description]
	 * @param  string $username [description]
	 * @return boolean if user exists in db...
	 */
	public function checkUser($username)
	{
		$query = "select * from registrants where username = '$username'";
		$res = $this->db->fetchOne($query);
		if($res) return true;
		return false;
	}

	/**
	 * [createUser description]
	 * @param  string $first_name    [description]
	 * @param  string $last_name     [description]
	 * @param  date $date_of_birth [description]
	 * @param  string $country       [description]
	 * @param  string $ip            [description]
	 * @param  string $username      [description]
	 * @param  string $password      [description]
	 * @param  string $email         [description]
	 * @return bool                [description]
	 */
	public function createUser($first_name, $last_name, $date_of_birth, $country,$ip , $username, $password, $email)
	{
		$first_name = trim($first_name);
        $last_name = trim($last_name);
        $date_of_birth = strtotime($date_of_birth);
        $username = trim($username);
        $password = hash('sha256', $password);

		$query = "INSERT INTO registrants (first_name, last_name, date_of_birth, country, ip, username, password, email) VALUES ('$first_name','$last_name','$date_of_birth','$country','$ip','$username','$password','$email')";
		$this->db->execute($query);
	}

	/**
	 * method for user login
	 * @param  string $username [description]
	 * @param  string $password [description]
	 */
	public function loginUser($username, $password)
	{
		$password = hash('sha256', $password);
        $username = trim($username);

		$query = "select * from registrants where username = '$username' and password = '$password'";
		$result = $this->db->fetchOne($query);
		if($result){
			//method for token in functions
			$token = token(8);
			$query = ("update registrants set token = '$token' where username = '$username'");
			$this->db->execute($query);
			//method for pass asterisk in functions ********
            $asterisk = passAsterisk();
            //success Login message from functions
            successLogin($username, $token, $asterisk);
		}else{
			returnError('Password or username doesn`t exist.');
		}
	}

    /**
     * method for emove of user
     * @param  string $username [description]
     * @param  string $password [description]
     * @param  string $token    [description]
     */
	public function removeUser($username, $password, $token)
	{
		$password = hash('sha256', $password);
        $username = trim($username);
		
		$query = "select * from registrants where username = '$username' and password = '$password' and token = '$token'";
        $result = $this->db->fetchOne($query);
        if($result){
            $query = "delete from registrants where username = '$username'";
            $this->db->execute($query);
            successRemove($username);
        }else{
            returnError('Password or username or token doesn`t match');
        }
	}
}