<?php
session_start();
include "./php/config.php";

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
        header("Location: index.php");
        exit;
        }
    }else{
        $item_array = array(
            'product_id' => $product_id,
            'quantity' =>1
        );
        //cree new session
        $_SESSION['cart'][0]=$item_array;

        header("Location: index.php");
        exit;
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
                <form action="" method="post">
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
<div class="container">
     <section class="shopping_cart">
     <h1 class="heading">Résultats</h1>
        <?php
            if(!empty($_POST['search'])){
               
               $search = $_POST['search'];
               $query = "SELECT * FROM products
                         WHERE title LIKE CONCAT('%', '$search', '%') OR
                            category LIKE CONCAT('%', '$search', '%') OR
                            description LIKE CONCAT('%', '$search', '%')";
                
                $result = mysqli_query($con,$query);
                if(mysqli_num_rows($result)>0){               
                ?>
        <table>
        <tr>
                <th>Produit</th>
                <th>Image</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Categorie</th>
                <th>Action</th>
        </tr>
            
            <?php
                while($row = mysqli_fetch_assoc($result)){
            ?>
        <form action="" method="post">    
                <tr>
                    <td><?php echo $row['title']?></td>
                    <td>
                    <img src="<?php echo $row['image']?>" style="width: 200px;height:150px;">
                    </td>
                    <td><?php echo $row['description']?></td>
                    <td><?php echo $row['price']?>&euro;</td>
                    <td><?php echo $row['category']?></td>
                    <td>
                    <button type="submit" class="update_quantity" name="ajouter_panier" value="remove">
                    Ajouter au panier <i class="fa fa-shopping-cart" style="color: red;"></i>
                    </button>
                    </td>
                </tr>
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        </form> 
            <?php
                }
            ?>
        </table>

    <?php
            }
            else{
    ?>
            <div class="message">
            <p>Pas de resultats , Veuillez rechercher une autre fois ... !</p>
            </div>
    <?php
            }
            }else{
    ?>
        <div class="message">
            <p>Veuillez saisir quelque chose ... !</p>
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