<?php
 header("Access-Control-Allow-Origin: http://localhost:8080");
 header('Access-Control-Max-Age: 86400');
 header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 header("Content-Type: text/html");
 ?>

<!DOCTYPE html>
<html>
    <head>
    <style>
    td{
        border: 1px solid black;
    }
    </style>
    </head>
    <body>
        <table style="border: 1px solid black">
            <tr>
                <td>
                File Name
                </td>
                <td>
                Size
                </td>
                <td>
                Extention
                </td>
                <td>
                Validation
                </td>
            </tr>
            <tr>
                <td>
                <?php 
                echo $_GET["file_name"];
                ?>
                </td>
                <td>
                <?php 
                echo $_GET["file_size"];
                ?>    
                </td>
                <td>
                <?php 
                $fileExt = explode('.', $_GET["file_name"]);
                $fileActualExt = strtolower(end($fileExt));
                echo $fileActualExt;
                ?>
                </td>
                <td>
                <?php
                echo $_GET['valid'];
                ?>
                </td>
            </tr>
        </table>
    </body>
</html>