<?php 
session_start();

require_once "./php/functions.php";
include "./php/config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['ajouter_panier'])){
    $product_id = $_POST['id'];

    if(isset($_SESSION['cart'])){
       //tester si le produit est deja dans la session
        $item_array_id = array_column($_SESSION['cart'],'product_id');
        
        if(in_array($product_id,$item_array_id)){
            echo "<script>
            alert('Product is already added to the cart');
            window.location = 'index.php'
            </script>";
        }else{
            $item_array = array(
                'product_id' => $product_id,
                'quantity' =>1
            );
            $_SESSION['cart'][]= $item_array;

            exit;
        }
    }else{
        $item_array = array(
            'product_id' => $product_id,
            'quantity' =>1
        );
        //cree new session
        $_SESSION['cart'][0]=$item_array;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
                    <a href="./php/logout.php" >
                    <button class="logbutton">
                    Log Out
                    </button>
                    </a>
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
   <div class="left">
     <div class="section-title">Catégories</div>

     <!-- PHP CODE -->
     <?php 
     $categories = getHomeCategories();

     foreach($categories as $category){
     ?>
      <a href="category.php?category=<?php echo urlencode($category['category'])?>">
      <?php echo $category['category']?>
      </a>
     <?php
     }
     ?>

   </div>

   <div class="right">
     <div class="section-title">Home<div>

     <?php $products = getHomeProducts(5) ?>
     
     <div class="product">
     
     <?php
        foreach($products as $product){
     ?>
          <div class="product-left">
               <img src="<?php echo $product['image']?>">
          </div>
          <form action="" method="post">
          <div class="product-right">
           <p class="title">
               <?php echo $product['title']?>
           </p>
           <p class="description">
               <?php echo $product['description']?>
           </p>
           <p class="price">
               <?php echo $product['price']?>&euro;
           </p>
           <button class="panbutton" name="ajouter_panier">Ajouter au panier&nbsp;
            <i class="fa fa-shopping-cart"></i></button>
           </div> 

           <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
        </form>
      <?php     
        } 
      ?>
       
     </div>
   </div>
</main>





<?php include "includes/footer.php" ?>
</body>
</html>