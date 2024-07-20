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
        
        <?php
            include("../php/config.php");
            if(isset($_POST['submit'])){
                
                //recuperer les emails avec neutralisation des Char spec comme { / , " , '}
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                //email syntaxe verfication
                $test = filter_var($email,FILTER_VALIDATE_EMAIL);
                if(!$test){
                    ?>
                    <div class="message">
                     <p>ERROR : Email Invalide !</p>
                    </div><br>
                     <a href="javascript:self.history.back()"><button class="btn">Go Back</button>
                    <?php
                }
                else{
                
                    $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password'") or die("Select Error");
                    
                    $row = mysqli_fetch_assoc($result);

                    if(is_array($row) && !empty($row)){
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['Username'] = $row['Username'];
                        $_SESSION['Password'] = $row['Password'];
                        $_SESSION['Age'] = $row['Age'];

                        if(isset($row['usertype'])){
                            $_SESSION['usertype'] = $row['usertype']; 
                        }else{
                            $_SESSION['usertype'] = 'user'; 
                        }
                    }
                    else{
                        ?>

                        <div class="message">
                        <p>Wrong Email or Password !</p>
                        </div><br>
                        <a href="./login.php"><button class="btn">Go Back</button>
                        
                        <?php
                    }

                    //envoyer user ou admin a son destination
                    if(isset($_SESSION['valid']) && isset($_SESSION['usertype'])){

                    if($_SESSION['usertype'] == "user")
                          header("Location: ../user.php");
                    }
                    if($_SESSION['usertype'] == "admin"){
                          header("Location: ../admin.php");
                    }
                  
                   }
            }
            else{

        ?>
        <div class="header">Log In</div>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="./register.php">Sign Up Now</a>
                </div>
            </form>
        </div>

        <?php } ?>
</div>

</main>

<?php include "../includes/footer.php" ?>
</body>
</html>