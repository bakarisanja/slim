<?php
    require_once 'db_conf.php';
    class User
    {
        /*
        method for conection
        */
        public function connect(){
            return $conn = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME, DB_USER, DB_PASS);
        }
        /*
        method for checking if user alredy exists in database
        */
        public function checkUser($conn, $username){
            $stmt = $conn->prepare("select * from registrants where username = :username");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchObject();
            if($result){
                return true;
            }else{
                return false;
            }
        }
        /*
        method for creating a new user
        */
        public function createUser($conn, $first_name, $last_name, $date_of_birth, $country,$ip , $username, $password, $email)
        {
            $stmt = $conn->prepare("INSERT INTO registrants (first_name, last_name, date_of_birth, country, ip, username, password, email) VALUES (:first_name,:last_name,:date_of_birth,:country,:ip,:username,:password,:email)");
            
            $stmt->bindValue(':first_name',$first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last_name',$last_name, PDO::PARAM_STR);
            $stmt->bindValue(':date_of_birth',$date_of_birth, PDO::PARAM_STR);
            $stmt->bindValue(':country',$country, PDO::PARAM_STR);
            $stmt->bindValue(':ip',$ip, PDO::PARAM_STR);
            $stmt->bindValue(':username',$username, PDO::PARAM_STR);
            $stmt->bindValue(':password',$password, PDO::PARAM_STR);
            $stmt->bindValue(':email',$email, PDO::PARAM_STR);

            $stmt->execute();
        }
        /*
        method for login
        */
        public function loginUser()
        {
            //body
        }
        /*
        method for deliting
        */
        public function deleteUser()
        {
            //body
        }
    }