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
            $first_name = trim($first_name);
            $last_name = trim($last_name);
            $date_of_birth = strtotime($date_of_birth);
            $username = trim($username);
            $password = hash('sha256', $password);

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
        public function loginUser($conn, $username, $password)
        {
            $password = hash('sha256', $password);
            $username = trim($username);
            $stmt = $conn->prepare("select * from registrants where username = :username and password = :password");
            $stmt->bindValue(':username',$username, PDO::PARAM_STR);
            $stmt->bindValue(':password',$password, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchObject();
            if($result){
                //method for token in functions
                $token = token(8);
                //adding token to database  INSERT INTO REGISTRY (name, value) VALUES (:name, :value)
                $stmt = $conn->prepare("update registrants set token = :token where username = :username");
                $stmt->bindValue(':token', $token, PDO::PARAM_STR);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                //method for pass asterisk in functions ********
                $asterisk = passAsterisk();
                //success Login message from functions
                successLogin($username, $token, $asterisk);
            }else{
                returnError('Password or username doesn`t exist.');
            }
        }

        /*
        remove user (dodacu i id korisnika da bi iz CI radio ovu akciju i brisao po id-u)
        */
        public function removeUser($conn, $username, $password, $token)
        {
            
            $stmt = $conn->prepare("select * from registrants where username = :username and password = :password and token = :token");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':token', 'cgLesJwz', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchObject();
            if($result){
                successRemove($username);
            }else{
                returnError('Password or username or token doesn`t match');
            }
        }
    }