<?php 
session_start();

include "./php/config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: ./index.php");
    exit();
}

$username = "";
$email ="";
$password = "";
$age = "";
$usertype = "";
$errorMessage = "";
$succesMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
        
        $verify = mysqli_query($con,
                        "SELECT Email FROM users WHERE Email LIKE '$email'");

        if(mysqli_num_rows($verify) != 0){
            $mailerror = "This email is used , Try another One Please !";
            break;
        }
        $result = mysqli_query($con,"INSERT INTO users(Username,Email,Password,usertype,Age)
        VALUES ('$username','$email','$password','$usertype',$age)");

        $username = "";
        $email ="";
        $password = "";
        $age = "";
        $usertype = "";


        //ajouter les clients 


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
   

        <h2>Nouveau Client</h2>

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
        if(!empty($mailerror)){
        echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>This email is used , Try another One Please !</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
            </button>
            </div>  
            ";
        }
        ?>


        <form action="" method="post">
              
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="username" value="">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="email" value="">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="password" value="">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="age" value="">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Usertype</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="usertype" value="">    
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
        }

        ?>





              <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
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