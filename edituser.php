<?php 
session_start();

include "./php/config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: ./index.php");
    exit();
}


$id = "";
$username = "";
$email ="";
$password = "";
$age = "";
$usertype = "";
$errorMessage = "";
$succesMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'GET'){

     if(!isset($_GET['id'])){
        header("location: ./admin.php");
        exit;
     }

     $id = $_GET['id'];

     $result = mysqli_query($con,"SELECT * FROM users WHERE id=$id");
     $row = mysqli_fetch_assoc($result);

     if(!$row){
        header("location: ./admin.php");
        exit;
     }

    $username = $row['Username'];
    $email = $row['Email'];
    $password = $row['Password'];
    $age = $row['Age'];
    $usertype = $row['usertype'];



}else{
    $id=$_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $usertype = $_POST['usertype'];

    do{
        if(empty($username) ||empty($email) || empty($password) || empty($age) || empty($usertype)){
            $errorMessage = "All the fields are required ! . BITCHH";
            break;
        }
        
        $result = mysqli_query($con,"UPDATE users
                                     SET Username = '$username', Email='$email', Password = '$password' , usertype = '$usertype',
                                     Age = $age
                                     WHERE id = $id");
        
        $succesMessage = "Client added correctly";
        



    }while(false);

}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="icon" href="./fantome.png"/>
</head>
<body>

<!-- HEADER -->
<header>
        <input type ="checkbox" name ="" id ="chk1">
        <div class="logo">
            <h1>
                <a href="#">
                <img src="./fantome.png" alt=""></a>
                N<span style="color: rgb(255,45,45);">4E</span>MO</h1>
        </div>
            <div class="search-box">
                <form>
                    <input type ="text" name ="search" id ="srch" placeholder="Rechercher ...">
                    <button type ="submit"><i class="fa fa-search" style="color: white;"></i></button>
                </form>
            </div>
            <ul>
                <li>
                    <a href="./php/logout.php">
                        <button class="logbutton">Log Out</button>
                    </a>
                </li>
            </ul>
            <div class="menu">
                <label for="chk1">
                    <i class="fa fa-bars" style="color:rgb(255,45,45);"></i>
                </label>
            </div>
    </header>





<main>
   <div class="container">
        <h2>Mise a jour le Client</h2>

        <?php
        if(!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
            </button>
            </div>  
            ";
        } 
        ?>


        <form action="" method="post">
              <input type="hidden" name="id" value="<?php echo $id?>">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="username" value="<?php echo $username?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="email" value="<?php echo $email?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="password" value="<?php echo $password?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="age" value="<?php echo $age?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Usertype</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="usertype" value="<?php echo $usertype ?>">    
                </div>
              </div>

              <?php
        if(!empty($succesMessage)){
            echo "
            <div class='row mb-3'>
            <div class='offset-sm-3 col-sm-6'>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>$succesMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
            </button>
            </div>    
            </div>
            </div>";
            header("location: ./admin.php");
            exit;
        }

        ?>


              <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="./admin.php" role="button">
                    Annuler
                    </a>    
                </div>
              </div>
        </form>
   </div>


</main>





<?php include "includes/footer.php" ?>

<script link="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>