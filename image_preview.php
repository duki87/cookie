<?php
include('db/db.php');
//Get image
  if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
    $name = $_FILES["image"]["name"];
    $explode = explode(".", $name);
    $extension = end($explode);
    $newName = rand(10,10000) . "." . $extension;
    $location = "img/" . $newName;
    move_uploaded_file($_FILES['image']['tmp_name'], $location);
    echo '
    <div class="image-content">
    <img src="'.$location.'" class="img-responsive" id="product_image" alt="" width="200px" height="auto">
    <button type="button" name="location" data-location="'.$location.'" class="btn btn-danger " id="remove_button" name="button">x</button>
    </div>';
  }

//Delete image
if(!empty($_POST['location'])) {
  if(unlink($_POST['location'])) {
    echo 'Image deleted!';
  }
}
?>
