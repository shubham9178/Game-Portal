<?php

require_once '../includes/dbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['usercode']) and
        isset($_POST['password']))
    {
        $db = new DbOperations();
        $result = $db->login(
            $_POST['usercode'],
            $_POST['password']
        );
        if($result == 1){
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = "Login Successful";
        }
        else{
            $response['status'] = 500;
            $response['error'] = true;
            $response['message'] = "Incorrect Usercode and Password";
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
    $response['error']=true;
    $response['message']="Invalid Request";
}

echo json_encode($response);

?>