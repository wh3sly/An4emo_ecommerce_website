<?php 
session_start();

include "./php/config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: ./index.php");
    exit();
}



if($_SERVER['REQUEST_METHOD'] == 'GET'){
   if(!isset($_GET['id'])){
      header("location: admin.php");
      exit;
   }

   $id = $_GET['id'];
   $result = mysqli_query($con , "SELECT * FROM products WHERE id=$id");
   $row=mysqli_fetch_assoc($result);
   if(!$row){
    header("location: admin.php");
    exit;
   }

   $title = $row['title'];
   $description = $row['description'];
   $price = $row['price'];
   $category = $row['category'];
   $file = $row['image'];

}
else{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $file = $_FILES['image']['name'];
    $tempfile = $_FILES['image']['tmp_name'];
    $folder_image = 'products/'.$file;

    do{ 
        if(empty($title) || empty($description) || empty($price) || empty($category) || empty($file)){
          $errorMessage = "All the fields are required ! . BITCHH";
          break;
        }
      
      
        $result =mysqli_query($con ,"UPDATE products
             SET image='$folder_image' ,title='$title',price=$price ,description='$description',category= '$category'
             WHERE id=$id");
      
        if($result){
          move_uploaded_file($tempfile,$folder_image);    
        }else{
          
        }
      
      $title = "";
      $description =  "";
      $price =  "";
      $category =  "";
      $file = "";
      
      $succesMessage = "Product added correctly";
      
      
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
   
   <h2>Mise a jour le produit</h2> 
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
   
   <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $id?>">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="title" value="<?php echo $title?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="description" value="<?php echo $description?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="price" value="<?php echo $price?>">    
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Categorie</label>
                <div class="col-sm-6">
                     <input type="text" class="form-control" name="category" value="<?php echo $category?>">    
                </div>
              </div>
              <div class="row mb-3">
                     <input type="file" class="form-control" name="image" value="" style="background-color: gray;">    
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
            header("location: admin.php");
        }

        ?>

              <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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
   
   
