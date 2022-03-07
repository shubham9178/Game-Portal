<?php

require_once '../includes/dbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['emailOrUsercode']))
    {
        $db = new DbOperations();
        $result = $db->getUserExistance(
            $_POST['emailOrUsercode']
        );
        if($result==1){
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = "true";
        }
        else{
            $response['status'] = 200;
            $response['error'] = true;
            $response['message'] = "false";
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