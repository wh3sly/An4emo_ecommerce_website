<?php
session_start();

include "./php/config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: ./index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(isset($_GET['id'])){ 
    
    $id = $_GET['id'];
    $result =  mysqli_query($con,"DELETE FROM users
                                  WHERE id=$id");
                                  
  }
  }

  header("location: ./admin.php");
?>