<?php 

function dbConnect(){
    $mysql = new mysqli('localhost','root','','an4emo');
    
    if($mysql->connect_errno != 0){
        return false;
    }
    else{
        return $mysql;
    }
}


function getHomeCategories(){
    $mysql = dbConnect();

    $result = $mysql->query("SELECT DISTINCT category FROM products");

    while($row = $result->fetch_assoc()){
          $categories[] = $row;
    }
    return $categories;
}


function getHomeProducts($i){
    $mysql = dbConnect();

    $result = $mysql->query("SELECT * FROM products ORDER BY rand() LIMIT $i");

    while($row = $result->fetch_assoc()){
          $products[] = $row;
    }
    return $products;
}


function getProductsByCategories($cat){
    $mysql = dbConnect();

    $stmp = $mysql->prepare("SELECT * FROM products WHERE category = ?");
    
    $stmp->bind_param("s",$cat);
    $stmp->execute();
    $result = $stmp->get_result();

    $products = $result->fetch_all(MYSQLI_ASSOC);

    return $products;
}


function getProductsSortedByPrice($cat, $sort){
    $mysql = dbConnect();

    $stmp = $mysql->prepare("SELECT * FROM products
                             WHERE category = ?
                             ORDER BY price $sort");
    
    $stmp->bind_param('s',$cat);
    $stmp->execute();
    $result = $stmp->get_result();

    $products = $result->fetch_all(MYSQLI_ASSOC);

    return $products;
}

function getProductsSortedAlphabetically($cat, $sort){
    $mysql = dbConnect();

    $stmp = $mysql->prepare("SELECT * FROM products
                             WHERE category = ?
                             ORDER BY title $sort");
    
    $stmp->bind_param('s',$cat);

    $stmp->execute();
    $result = $stmp->get_result();

    $products = $result->fetch_all(MYSQLI_ASSOC);

    return $products;
}



?>