<?php
  include('db/db.php');
  if(isset($_POST['name']) && $_POST['name'] != '') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_location = $_POST['image_location'];

    $query = "INSERT INTO product (name, description, image, price) VALUES (:name, :description, :image_location, :price)";
    $statement = $connect->prepare($query);
    $statement->execute(
       array(
         ':name'           =>  $name,
         ':description'    =>  $description,
         ':price'          =>  $price,
         ':image_location' =>  $image_location
       )
     );
     $result = $statement->fetchAll();
     if(isset($result)) {
       echo 'Uploaded successfully!';
     }
  }
?>
