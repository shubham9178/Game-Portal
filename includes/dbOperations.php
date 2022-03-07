<?php session_start();

    class DbOperations{

        private $con;

        function __construct() {
            require_once dirname(__FILE__).'/dbConnect.php';
            $db = new DbConnect();

            $this->con = $db->connect();

        } 

        /* database operations */
        
        //register new user
        function registerUser($usercode,$password,$username,$dob,$email,$isactive,$role,$createdate,$updatedate){
            
            if($this->isUserExist($usercode,$email)){
                return 0;
            }
            else{
            $encpassword = md5($password);
            $stmt = $this->con->prepare("INSERT INTO `userdetails` (`userid`, `usercode`, `password`, `username`, `dob`, 
                                        `email`, `is_active`, `user_role`, `create_date`, `update_date`) 
                                        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssiiss",$usercode,$encpassword,$username,$dob,$email,
                                $isactive,$role,$createdate,$updatedate);
            
           if($stmt->execute()){
                return 1;
           }
           else{
               return 2;
           }
        }


        }

        function login($usercode,$password){
            $encpassword = md5($password);
            $stmt = $this->con->prepare("SELECT userid FROM `userdetails` WHERE `usercode`= ? AND `password`= ?");
            $stmt->bind_param("ss",$usercode,$encpassword);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows > 0){
                return 1;
           }
           else{
               return 2;
           }
        }

        function isUserExist($usercode,$email){
            $stmt = $this->con->prepare("SELECT userid FROM `userdetails` WHERE `usercode`= ? OR `email`= ?");
            $stmt->bind_param("ss",$usercode,$email);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }

        function getUserByUsercode($usercode){
            $stmt = $this->con->prepare("SELECT userid FROM `userdetails` WHERE `usercode`= ?");
            $stmt->bind_param("s",$usercode);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        function getUserExistance($emailOrUsercode){
            if($this->isUserExist($emailOrUsercode,$emailOrUsercode)){
                $_SESSION['user']=$emailOrUsercode;
                return 1;
            }
            else{
                return 2;
            }
        }

        function resetPassword($password,$user){
            $encpassword = md5($password);
            $stmt = $this->con->prepare("UPDATE `userdetails` SET `password`= ? where `usercode`= ? OR `email`= ?");
            $stmt->bind_param("sss",$encpassword,$user,$user);
            
           if($stmt->execute()){
                return 1;
           }
           else{
               return 2;
           }
        }

    }

?>