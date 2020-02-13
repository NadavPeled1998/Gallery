<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
header("Content-Type: text/html");
       

 if($_SERVER['REQUEST_METHOD'] === "POST"){
    $postData = json_decode(file_get_contents('php://input'), true);
    if($postData['gallery_titleֹ'] != "" && $postData['gallery_description'] != "" && $postData['gallery_date'] != ""){
        echo true;
    }
    elseif($postData["file_name"] != "" && $postData["file_size"] != ""){
        $fileName = test_input($postData["file_name"]);
        $fileSize = test_input($postData["file_size"]);
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        if($postData['images_length']<5){
            if(in_array($fileActualExt, $allowed)){
                if($fileSize < 10000000){
                    echo true;
                }
                else{
                    echo "Your image is bigger than 10mb";
                }
            }
            else{
                echo "Your file is not an image";
            }
        }
        else{
            echo "you can have only five images in the gallery";
        }
    }
    else{
        echo 0;
    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}