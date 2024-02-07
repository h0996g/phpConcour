<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "memoir";
try{
        $conn=new PDO('mysql:host=localhost;dbname=memoir;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    
    }catch(Exception $e){
    die('ERROR :'.$e->getMessage());
    
    }

?>