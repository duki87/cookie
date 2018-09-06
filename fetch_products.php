<?php
include('db/db.php');
if(isset($_POST['getProducts'])) {
  $query = "SELECT * FROM product ORDER BY id ASC";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $sub_array = array();
  $data = array();
  foreach ($result as $row) {
  $data[] = '<div class="col-md-3">
              <form method="post" id="item">
                <div style="border:1px solid #333;background-color:#f1f1f1;border-radius:5px;padding:16px; height:450px;position:relative" align="center">
                  <img src="'.$row['image'].'" alt="" class="img-responsive">;
                  <h4 class="text-info">'.$row['name'].'</h4>
                  <p class="text-info">'.$row['description'].'</p>
                  <h4 class="text-danger">'.$row['price'].'</h4>
                  <input type="text" name="quantity" value="1" class="form-control">
                  <input type="hidden" name="hidden_name" value="'.$row['name'].'">
                  <input type="hidden" name="hidden_price" value="'.$row['price'].'">
                  <input type="hidden" name="hidden_id" value="'.$row['id'].'"><br>
                  <div class="form-group">
                    <input type="submit" name="add_to_cart" id="add_to_cart" value="Add to Cart" class="btn btn-success">
                  </div>
                </div>
              </form>
            </div>';
  }
  $output = json_encode($data);
  echo $output;
}
?>
