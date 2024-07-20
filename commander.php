<?php 
session_start();
require "./php/functions.php";

$con=dbConnect();
if(isset($_GET['price'])){
    $prix=$_GET['price'];
    $email=$_SESSION['valid'];
    $date = date('Y-m-d');

    // Perform the SELECT query to fetch the user ID
    $id_query = "SELECT ID FROM users WHERE email='$email'";
    $id_result = mysqli_query($con, $id_query);
    if ($id_result) {
    $row = mysqli_fetch_assoc($id_result);
    $user_id = $row['ID'];
    
    // Use the fetched user ID in the INSERT statement
    $sql="INSERT INTO commande (date,numclt,prixtotale)
          VALUES ('$date',$user_id,$prix)";
    
    // Execute the INSERT query
    mysqli_query($con,$sql);
    } else {
    // Handle the case when the SELECT query fails
    echo "Error: " . mysqli_error($con);
   }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commander</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="CSS/style2.css">
    <link rel="icon" href="./fantome.png"/>
</head>
<body>

<!-- HEADER -->
<header>
        <input type ="checkbox" name ="" id ="chk1">
        <div class="logo">
            <h1>
                <a href="./index.php">
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
                    <?php
                    if(isset($_SESSION['valid'])){
                    ?>
                        <a href="./php/logout.php" >
                        <button class="logbutton">
                        Log Out
                        </button>
                      </a>
                    <?php
                      }else{
                    ?>
                    <a href="./user/login.php">
                       <i class="fa fa-user"></i>
                    </a>
                    <?php
                      }
                    ?>
                    <a href="./panier.php">
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

<div class="wrapper">
        <h2>CheckOut</h2>
        <form action="" method="post">
            <!--Account Information Start-->
            <h4>Information </h4>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Nom" required class="name">
                    <i class="fa fa-user icon"></i>
                </div>
                <div class="input_box">
                    <input type="text" placeholder="Prenom" required class="name">
                    <i class="fa fa-user icon"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="email" placeholder="Email Address" required class="name">
                    <i class="fa fa-envelope icon"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Adresse" required class="name">
                    <i class="fa fa-map-marker icon" aria-hidden="true"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Ville" required class="name">
                    <i class="fa fa-institution icon"></i>
                </div>
            </div>
            <!--Account Information End-->


            <!--DOB & Gender Start-->
            <div class="input_group">
                <div class="input_box">
                    <h4>Date de naissance</h4>
                    <input type="text" placeholder="DD" required class="dob">
                    <input type="text" placeholder="MM" required class="dob">
                    <input type="text" placeholder="YYYY" required class="dob">
                </div>
                <div class="input_box">
                    <h4>Sexe</h4>
                    <input type="radio" name="gender" class="radio" id="b1" checked>
                    <label for="b1">Homme</label>
                    <input type="radio" name="gender" class="radio" id="b2">
                    <label for="b2">femme</label>
                    <input type="radio" name="gender" class="radio" id="b3">
                    <label for="b3">autre...</label>
                </div>
            </div>
            <!--DOB & Gender End-->


            <!--Payment Details Start-->

            
            <div class="input_group">
                <div class="input_box">
                    <h4>Payment Details</h4>
                    <input type="radio" name="pay" class="radio" id="bc1" value="bc1" checked onchange="showPaymentDetails(this.value)">
                    <label for="bc1">
                            <i class="fa fa-cc-visa"></i> Carte crédit
                    </label>
                    <input type="radio" name="pay" class="radio" id="bc2" value="bc2" onchange="showPaymentDetails(this.value)">
                    <label for="bc2">
                        <i class="fa fa-truck"></i> Paiement á la livraison
                    </label>
                </div>
            </div>
            
            
        <div id="creditCardDetails" class="input_group">
            <div class="input_group">
                <div class="input_box">
                    <input type="tel" name="" class="name" placeholder="Card Number 1111-2222-3333-4444" required>
                    <i class="fa fa-credit-card icon"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="tel" name="" class="name" placeholder="Card CVC 632" required>
                    <i class="fa fa-user icon"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <div class="input_box">
                        <input type="number" placeholder="Exp Month" required class="name">
                        <i class="fa fa-calendar icon" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="input_box">
                    <input type="number" placeholder="Exp Year" required class="name">
                    <i class="fa fa-calendar-o icon" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <script>
        function showPaymentDetails(option) {
        var creditCardDetails = document.getElementById('creditCardDetails');
        if (option === 'bc1') {
            creditCardDetails.style.display = 'block';
        } else {
            creditCardDetails.style.display = 'none';
        }
        }
        </script>

            <!--Payment Details End-->

            <div class="input_group">
                <div class="input_box">
                    <button class="payer" type="submit" name="submit">PAY NOW&nbsp;<?php echo $prix ?>&euro;</button>
                </div>
            </div>

        </form>
    </div>

</body>

 
</main>





<?php include "includes/footer.php" ?>
</body>
</html>