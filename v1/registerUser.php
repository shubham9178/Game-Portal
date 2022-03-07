<?php

    require_once '../includes/dbOperations.php';
    $response = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(
            isset($_POST['usercode']) and 
                isset($_POST['password']) and 
                    isset($_POST['email']))
            {  
            $db = new DbOperations();
            $result = $db->registerUser(
                $_POST['usercode'],
                $_POST['password'],
                $_POST['username'],
                $_POST['dob'],
                $_POST['email'],
                $_POST['isactive'],
                $_POST['role'],
                $_POST['createdate'],
                $_POST['updatedate']
            );
            
            if($result==1){
                $response['status'] = 200;
                $response['error'] = false;
                $response['message'] = "Registration Successful";
            }
            else if($result==2){
                $response['status'] = 500;
                $response['error'] = true;
                $response['message'] = "Some error occured, Please try again";
            }
            else{
                $response['status'] = 500;
                $response['error'] = true;
                $response['message'] = "User already exist. Try with different usercode and email";
            }

        }
        else{
            $response['status'] = 400;
            $response['error'] = true;
            $response['message'] = "Required fields are missing";
        }

        }

    else{
        $response['status'] = 400;
        $response['error'] = true;
        $response['message'] = "Invalid Request";
    }

    echo json_encode($response);

?>