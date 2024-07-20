<?php 
session_start();

include "./php/config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
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



<?php 
   
   if(isset($_POST['comptes'])){
    //gestion des comptes
   
    $result = mysqli_query($con,"SELECT * FROM users WHERE usertype='user'");
    $n = mysqli_num_rows($result);
    
    ?>


    <div class="containerr my-5">
        <h2>Listes des Clients</h2>
        <a class="btn btn-primary" href="./createuser.php" role="button" style="height: 35px;
    background: #77B5FE;
    border: 0;
    border-radius: 5px;
    color: #fff;
    font-size: 15px;
    cursor: pointer;"> Nouveau Client</a><br>
    
    <?php if($n == 0){echo "Pas de client"; }
    else{ ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $result = mysqli_query($con,"SELECT * FROM   users WHERE usertype LIKE 'user'");
                  while($row = mysqli_fetch_assoc($result)){
                ?>
                    <tr>   
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['Username']?></td>
                        <td><?php echo $row['Email']?></td>
                        <td><?php echo $row['Password']?></td>
                        <td><?php echo $row['Age']?></td>
                        <td>
                            <a class="btn btn-primart btn-sm" href="./edituser.php?id=<?php echo $row['id'] ?>" style="height: 35px;
    background: rgb(0,0,255);
    border: 0;
    border-radius: 5px;
    color: #fff;
    font-size: 15px;
    cursor: pointer;">Mise a jour <i class="fa fa-wrench" style="color: white;"></i></a>
                            <a class="btn btn-primart btn-sm" href="./deleteuser.php?id=<?php echo $row['id'] ?>"  style="height: 35px;
    background: rgb(255,45,45);
    border: 0;
    border-radius: 5px;
    color: #fff;
    font-size: 15px;
    cursor: pointer;">Supprimer&nbsp;<i class="fa fa-trash" style="color:white;"></i></a>
                        </td>
                    </tr>
                <?php
                  }
                ?>
            </tbody>
        </table>
    </div>
   <?php
    }
   }
   elseif(isset($_POST['produits'])){
 //gestion des produits
   
 $result = mysqli_query($con,"SELECT * FROM products");
 $n = mysqli_num_rows($result);
 ?>


 <div class="containerr my-5">
     <h2>Listes des Produits</h2>
     <a class="btn btn-primary" href="./createprod.php" role="button" style="height: 35px;
 background: #77B5FE;
 border: 0;
 border-radius: 5px;
 color: #fff;
 font-size: 15px;
 cursor: pointer;"> Nouveau Produit</a><br>
 
 <?php  if($n == 0){ echo "Pas de Produit"; }
 else{ ?>

     <table class="table">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
             <?php
               $result = mysqli_query($con,"SELECT * FROM products");
               while($row = mysqli_fetch_assoc($result)){
             ?>
                 <tr>   
                     <td><?php echo $row['id']?></td>
                     <td><img src="<?php echo $row['image']?>" style="height: 50px;width:50px;"></td>
                     <td><?php echo $row['title']?></td>
                     <td><?php echo $row['price']?></td>
                     <td><?php echo $row['description']?></td>
                     <td><?php echo $row['category']?></td>
                     <td>
                         <a class="btn btn-primart btn-sm" href="./editprod.php?id=<?php echo $row['id'] ?>" style="height: 35px;
 background: rgb(0,0,255);
 border: 0;
 border-radius: 5px;
 color: #fff;
 font-size: 15px;
 cursor: pointer;">Mise a jour <i class="fa fa-wrench" style="color: white;"></i></a>
                         <a class="btn btn-primart btn-sm" href="./deleteprod.php?id=<?php echo $row['id'] ?>"  style="height: 35px;
 background: rgb(255,45,45);
 border: 0;
 border-radius: 5px;
 color: #fff;
 font-size: 15px;
 cursor: pointer;" onclick="return confirm('Are u sure , you wan to delete this product')">Supprimer&nbsp;<i class="fa fa-trash" style="color:white;"></i></a>
                     </td>
                 </tr>
             <?php
               }
             ?>

     </table>
 </div>

<?php
   }
   }
   else{

?>



<div class="container" id="admin">
     <p class="ahello" style="font-size: 40px;">Hello Admin</p>
     <form action="" method="post">
        <input class="btn" type="submit" name="comptes" value="Gerer les Comptes" style="font-size:18px;border:1px solid black;">
        <input class="btn" type="submit" name="produits" value="Gerer les produits" style="font-size:18px;border:1px solid black;">
     </form>
</div>

<?php
   }
?>


</main>





<?php include "includes/footer.php" ?>
</body>
</html>