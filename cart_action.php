<?php
include('db/db.php');
if(isset($_POST['add_to_cart'])) {
  $item_array = array(
    'item_id'   =>  $_POST['hidden_id'],
    'item_name'   =>  $_POST['hidden_name'],
    'item_price'   =>  $_POST['hidden_price'],
    'item_quantity'   =>  $_POST['quantity']
  );
  $cart_data[] = $item_array;
  $item_data = json_encode($cart_data);
}
