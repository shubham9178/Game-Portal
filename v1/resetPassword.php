<?php

require_once '../includes/dbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['password'])
      and isset($_SESSION['user']))
    {
        $db = new DbOperations();
        $result = $db->resetPassword(
            $_POST['password'],
            $_SESSION['user']
        );
        if($result==1){
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = "password reset successfuly";
        }
        else{
            $response['status'] = 500;
            $response['error'] = true;
            $response['message'] = "something went wrong. try latter";
        }
    }
    else{
            $response['status'] = 400;
            $response['error']=true;
            $response['message']="Required fields are missing";

    }

}
else{
    $response['status'] = 400;
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);

?>