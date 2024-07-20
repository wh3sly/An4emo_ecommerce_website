<?php
session_start();
include "./php/config.php";

if(isset($_GET['delete_all'])) {
    echo "<script>
            if(confirm('Are you sure you want to delete all?')) {
                window.location.href = 'panier.php?confirmed=true';
            } else {
                window.location.href = 'panier.php';
            }
          </script>";
    exit; // Ensure that no further code is executed after the JavaScript redirect
}

if(isset($_GET['confirmed']) && $_GET['confirmed']==='true'){
   unset($_SESSION['cart']);
   header('location: panier.php');
   exit;
}




if(isset($_POST['action'])){
    $action=$_POST['action'];

switch($action){

case 'remove' :

    foreach($_SESSION['cart'] as $key=>$value){
        if($value['product_id']==$_GET['id']){
            unset($_SESSION['cart'][$key]);
            echo "<script>alert('Product has been Removed...!')</script>";
            echo "<script>window.location='panier.php'</script>";
            break;
        }
    }
    break;
  
case 'update' :

    foreach($_SESSION['cart'] as $key=>$value){
        if($value['product_id']==$_GET['id']){
             $_SESSION['cart'][$key]['quantity']=$_POST['quantity'];
             break;
        }
    }
    break;

default :
    break;
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="./CSS/style2.css"/>
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
                <form action="./search.php" method="post">
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
                    <a href="#">
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
     <section class="shopping_cart">
        <h1 class="heading">Mon Panier</h1>

        <?php
            if(isset($_SESSION['cart'])){

                $product_id = array_column($_SESSION['cart'],'product_id');
                //recuperation des donees
                $result = mysqli_query($con,"SELECT * FROM products");
                ?>
        
        <table>
        <tr>
                <th>Produit</th>
                <th>Image</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Prix Totale</th>
                <th>Action</th>
                </tr>
                   
        <?php     
                $globale = 0;
                while($row = mysqli_fetch_assoc($result)){
                    foreach($product_id as $id){
                        if($row['id'] == $id){

                    ?> 
                <form action="./panier.php?id=<?php echo $row['id']?>" method="post">    
                <tr>

                <?php 
                  //recuperer la quantite de chaque produit
                    foreach($_SESSION['cart'] as $key=>$value){
                        if($value['product_id']==$id){
                        $quantite = $value['quantity'];
                                break;
                        }
                        }
                  //recupere le prix totale de chaque produit
                    $prixtotale = $quantite * $row['price'];
                  //prixglobale
                    $globale += $prixtotale;
                ?>
                    <td><?php echo $row['title']?></td>
                    <td>
                    <img style="width: 200px;height:150px;" src="<?php echo $row['image']?>" alt=""></td>
                    <td><?php echo $row['description']?></td>
                    <td><?php echo $row['price']?>&euro;</td>
                    <td>
                        <div class="quantity_box">
                        <input type="number" min="1" name="quantity" value="<?php echo $quantite ?>">
                        <input type="submit" class="update_quantity" name="action" value="update">
                        </div>
                    </td>
                    <td><?php echo $prixtotale?>&euro;</td>
                    <td>
                        <button type="submit" class="update_quantity" name="action" value="remove">
                        <i class="fa fa-trash" style="color: red;"></i> Supprimer
                        </button>
                    </td>
                </tr>
                </form>
                <?php
                        break;
                        }
                    }
                }
                ?>

        
        </table>

        <form action="" method="post">
        <div class="table_bottom">
             <a href="index.php" class="bottom_btn">Continuer l'achat</a>
             <h3 class="bottom_btn">Totale : <span><?php echo $globale?>&euro;</span></h3>
             <a href="<?php
                        if(isset($_SESSION['valid'])){
                        echo "commander.php?price=$globale";
                        }else{
                        echo "./user/login.php";
                        }
                       ?>" class="bottom_btn commander">Commander</a>
        </div>

        <a href="panier.php?delete_all" class="delete_all_btn">
            <i class="fa fa-trash"></i>Supprimer tout
        </a>
        </form>
    <?php
            }else{
    ?>
        <div class="message">
            <p>Panier est Vide ... !</p>
        </div>

    <?php
            }
    ?>
        
     </section>           
</div>
</main>



<script src="./javascript/script.js"></script>
<?php include('./includes/footer.php')?>
</body>
</html>

