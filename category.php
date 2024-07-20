<?php 
session_start();
require "./php/functions.php";

$cat ="";
if(isset($_GET['category'])){
    $cat = urldecode($_GET['category']);
} 

if(isset($_POST['ajouter_panier'])){
    $product_id = $_POST['id'];

    if(isset($_SESSION['cart'])){
       //tester si le produit est deja dans la session
        $item_array_id = array_column($_SESSION['cart'],'product_id');
        
        if(in_array($product_id,$item_array_id)){
        echo "<script>
              alert('Product is already added to the cart');
              window.location = 'category.php?category=$cat'
              </script>";
        exit;
        }else{
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $product_id,
                'quantity' => 1
            );
            $_SESSION['cart'][$count]= $item_array;
        }
    }else{
        $item_array = array(
            'product_id' => $product_id,
            'quantity' => 1
        );
        //cree new session
        $_SESSION['cart'][0]=$item_array;
    }
}

if(isset($_GET['sortedbyprice'])){
   $sort = $_GET['sortedbyprice'];
}elseif(isset($_GET['sortedbyalpha'])){
   $sort = $_GET['sortedbyalpha'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/style3.css">
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
   <div class="left">
     <div class="section-title">Catégories</div>

     <!-- PHP CODE -->
     <?php 
     $categories = getHomeCategories();

     foreach($categories as $category){
     ?>
      <a href="category.php?category=<?php echo $category['category']?>">
      <?php echo $category['category']?>
      </a>
     <?php
     }
     ?>

    <div class="dropdown">
    <button class="dropbtn">Sort By</button>
    <form action="" method="post">
    <div class="dropdown-content">
      <a href="category.php?category=<?php echo $cat?>&sortedbyprice=ASC">Price: Low to High</a>
      <a href="category.php?category=<?php echo $cat?>&sortedbyprice=DESC">Price: High to Low</a>
      <a href="category.php?category=<?php echo $cat?>&sortedbyalpha=ASC">Alphabetical: A-Z</a>
      <a href="category.php?category=<?php echo $cat?>&sortedbyalpha=DESC">Alphabetical: Z-A</a>
    </div>
    </form>
    </div> 
    </div>



    <div class="right">
     <?php 
     
     if(isset($_GET['sortedbyprice'])){
        $sort = $_GET['sortedbyprice'];

        $products = getProductsSortedByPrice($cat, $sort);
    ?>
     <div class="section-title"><?php echo $cat?></div>
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
           
           <button class="panbutton" name="ajouter_panier">
              Ajouter au panier&nbsp;
              <i class="fa fa-shopping-cart"></i>
           </button>
           </div> 

           <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
           </form>
    <?php
     }
    ?>
    </div>

    <?php
     }
     elseif(isset($_GET['sortedbyalpha'])){
        $sort = $_GET['sortedbyalpha'];
        
        $products = getProductsSortedAlphabetically($cat, $sort);
    ?>
    <div class="section-title"><?php echo $cat?></div>
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
           
           <button class="panbutton" name="ajouter_panier">
              Ajouter au panier&nbsp;
              <i class="fa fa-shopping-cart"></i>
           </button>
           </div> 

           <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
           </form>
    <?php
       }
    ?>
    </div>

    <?php
     }
     else{
    
     $products = getProductsByCategories($cat);
     ?>
     <div class="section-title"><?php echo $cat?></div>
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
           
           <button class="panbutton" name="ajouter_panier">
              Ajouter au panier&nbsp;
              <i class="fa fa-shopping-cart"></i>
           </button>
           </div> 

           <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
           </form>
    
    
      <?php     
        }
      ?>
      </div> 
      <?php
       }
      ?>
    </div>   
    
</main>





<?php include "includes/footer.php" ?>
</body>
</html>