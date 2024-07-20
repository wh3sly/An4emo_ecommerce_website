<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/style1.css">
    <link rel="icon" href="../fantome.png"/>
</head>
<body>

<!-- HEADER -->
<header>
        <input type ="checkbox" name ="" id ="chk1">
        <div class="logo">
            <h1>
                <a href="../index.php">
                <img src="../fantome.png" alt=""></a>
                N<span style="color: rgb(255,45,45);">4E</span>MO</h1>
        </div>
            <div class="search-box">
                <form action="../search.php" method="post">
                    <input type ="text" name ="search" id ="srch" placeholder="Rechercher ...">
                    <button type ="submit"><i class="fa fa-search" style="color: white;"></i></button>
                </form>
            </div>
            <ul>
                <li>
                    <a href="#">
                        <i class="fa fa-user"></i>
                    </a>
                    <a href="../panier.php">
                    <i class="fa fa-shopping-cart"></i>
                    <?php
                      if(isset($_SESSION['cart'])){
                        $count = count($_SESSION['cart']);
                        echo '<span style="width:10px;
                        height:10px;
                        background-color:red;
                        justify-content:center;
                        align-items:center;
                        color:white;
                        border-radius:70%;
                        padding:5px 10px 5px 10px;">'.$count.'</span>';
                      }
                      else{
                        echo '<span style="width:10px;
                        height:10px;
                        background-color:red;
                        justify-content:center;
                        align-items:center;
                        color:white;
                        border-radius:70%;
                        padding:5px 10px 5px 10px;">0</span>';
                      }
                    ?>
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
        <div class="box form-box">
        <div class="header">Sign Up</div>

           <?php
               include("../php/config.php");

               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $password = $_POST['password'];
                $usertype = "user";
                
                //email syntaxe verfication
                $test = filter_var($email,FILTER_VALIDATE_EMAIL);
                if(!$test || $age>120){
                    ?>
                    <div class="message">
                     <p>ERROR : Email Invalide ou Age ilogique !</p>
                    </div><br>
                     <a href="javascript:self.history.back()"><button class="btn">Go Back</button>
                    <?php
                }
                else{ 
                //email existance verfication
                
                $verify = mysqli_query($con,
                        "SELECT Email FROM users WHERE Email LIKE '$email'");
                
                if(mysqli_num_rows($verify) != 0){
                ?>
                <div class="message">
                     <p>This email is used , Try another One Please !</p>
                </div><br>
                <a href="javascript:self.history.back()"><button class="btn">Go Back</button>

                <?php
                }else{

                    mysqli_query($con,
                            "INSERT INTO users (Username,Email,Password,usertype,Age)
                             VALUES ('$username','$email','$password','$usertype',$age)");
                ?>
                <div class="message">
                     <p>Registration successfully !</p>
                </div><br>
                <a href="./login.php"><button class="btn">Login Now</button>

                <?php
                }
            
               }
               }else{
           ?>


            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="./login.php">Log In</a>
                </div>
            </form>
        </div>
        <?php } ?>
</div>

</main>

<?php include "../includes/footer.php" ?>
</body>
</html>