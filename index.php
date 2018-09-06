<?php
  include('db/db.php');
  if(isset($_POST['add_to_cart'])) {
    if(isset($_COOKIE['shopping_cart'])) {
      $cookie_data = stripslashes($_COOKIE['shopping_cart']);
      $cart_data = json_decode($cookie_data, true);
    } else {
      $cart_data = array();
    }
    $item_id_list = array_column($cart_data, 'item_id');
    if(in_array($_POST['hidden_id'], $item_id_list)) {
      foreach ($cart_data as $key => $value) {
        if($cart_data[$key]['item_id'] == $_POST['hidden_id']) {
          $cart_data[$key]['item_quantity'] = $cart_data[$key]['item_quantity'] + $_POST['quantity'];
        }
      }
    } else {
      $item_array = array(
        'item_id'       =>  $_POST['hidden_id'],
        'item_name'     =>  $_POST['hidden_name'],
        'item_price'    =>  $_POST['hidden_price'],
        'item_quantity' =>  $_POST['quantity']
      );
      $cart_data[] = $item_array;
    }
    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 30));
    header('location: index.php?success=1');
  }

  if(isset($_GET['action'])) {
    if($_GET['action'] == 'delete') {
      $cookie_data = stripslashes($_COOKIE['shopping_cart']);
      $cart_data = json_decode($cookie_data, true);
      foreach ($cart_data as $key => $value) {
        if($cart_data[$key]['item_id'] == $_GET['id']) {
          unset($cart_data[$key]);
          $item_data = json_encode($cart_data);
          setcookie('shopping_cart', $item_data, time() + (86400 * 30));
          header('location: index.php?remove=1');
        }
      }
    }
    if($_GET['action'] == 'clear') {
      setcookie('shopping_cart', '', time() - 3600);
      header('location:index.php?clearall=1');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cookie Shop</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <br>
    <div class="container">
      <br>
      <h3 align="center">Cookie shop</h3>
      <h4 align="center"><b>this site use cookies :)</b></h4>
      <br><br>
      <div id="getProducts">

      </div>
      <div style="clear:both"></div><br>
      <h3>Order Details</h3>
      <?php
      if(isset($_GET['success'])) {
        echo '<div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="Close">&times;</a>
          Item Added to Cart!
        </div>';
      }

      if(isset($_GET['remove'])) {
        echo '<div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="Close">&times;</a>
          Item Removed from Cart!
        </div>';
      }

      if(isset($_GET['clearall'])) {
        echo '<div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="Close">&times;</a>
          Your Shopping Cart is empty!
        </div>';
      }
      ?>
      <div align="right">
        <b><a href="index.php?action=clear">Clear Cart</a></b>
      </div>
      <table class="table table-bordered">
        <tr>
          <th width="50%">Item Name</th>
          <th width="10%">Quantity</th>
          <th width="10%">Price</th>
          <th width="15%">Total</th>
          <th width="5%">Action</th>
        </tr>
        <?php
          if(isset($_COOKIE['shopping_cart'])) {
            $total = 0;
            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
            $cart_data = json_decode($cookie_data, true);
            foreach ($cart_data as $key => $value) {
          ?>
            <tr>
              <td><?=$value['item_name'];?></td>
              <td align="right"><?=$value['item_quantity'];?></td>
              <td align="right"><?=$value['item_price'];?></td>
              <td align="right">$ <?=number_format($value["item_quantity"] * $value["item_price"], 2);?></td>
              <td><a href="index.php?action=delete&id=<?=$value['item_id'];?>"><span class="text-danger">Remove</span></a></td>
            </tr>
          <?php
            $total = $total + ($value["item_quantity"] * $value['item_price']);
            }
          ?>
            <tr>
              <td colspan="3" align="right">Grand Total</td>
              <td align="right">$ <?=number_format($total,2);?></td>
              <td></td>
            </tr>
          <?php
          } else {
            echo '<tr>
                    <td colspan="5" align="center">No items in Cart!</td>
                  </tr>
            ';
          }
        ?>
      </table>
    </div>
  </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    getProducts();
    function getProducts() {
      var getProducts = 1;
      $.ajax({
        url:  "fetch_products.php",
        method: "POST",
        data: {getProducts:getProducts},
        dataType: 'JSON',
        success: function(data) {
          $('#getProducts').html(data);
        }
      });
    }

    // $(document).on('click','#add_to_cart', function() {
    //   var cartAction = 1;
    //   var item = $(this).serialize();
    //   $.ajax({
    //     url:  "cart_action.php",
    //     method: "POST",
    //     data: {cartAction:cartAction,item},
    //     dataType: 'JSON',
    //     success: function(data) {
    //
    //     }
    //   });
    // });

  });
</script>
