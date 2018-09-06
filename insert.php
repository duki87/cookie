<?php
  include('db/db.php');
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
      <h4>Insert cookies</h4><hr>
      <br><br>
      <form class="" method="post" id="insert_form" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" value="" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" name="price" id="price" value="" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea name="description" id="description" rows="8" cols="80" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="image">Image</label>
          <input type="file" name="image" id="image" value="" class="form-control" required>
          <div id="image_preview"></div>
        </div>
        <div class="form-group">
          <input type="submit" name="image" id="image" value="Insert" class="btn btn-success">
          <input type="hidden" id="image_location" name="image_location" value="">
        </div>
      </form>
    </div>
  </body>
</html>

<script type="text/javascript">
$(document).ready(function() {
  $(document).on('change', '#image', function() {
    var property = document.getElementById('image').files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();
    if(jQuery.inArray(image_extension, ["jpg","jpeg","png","gif"]) == -1) {
      alert('That data type is not allowed!');
    }
    var image_size = property.size;
    if(image_size > 5000000) {
      alert('Image size too big!');
    } else {
      var form_data = new FormData();
      form_data.append('image', property);
      $.ajax({
        url:  'image_preview.php',
        method: 'POST',
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          $('#image_preview').html(data);
          var image_location = $('#remove_button').data('location');
          $('#image_location').val(image_location);
        }
      });
    }
  });

  $(document).on('click', '#remove_button', function() {
    if(confirm("Are you sure you want to delete this image?")) {
      var location = $('#remove_button').data('location');
      $.ajax({
        url:  "image_preview.php",
        method: "POST",
        data: {location:location},
        success: function(data) {
          if(data != '') {
            $('#image_preview').html('');
          }
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('submit', '#insert_form', function(event) {
    event.preventDefault();
    var insert_form = $(this).serialize();
    $.ajax({
      url:  "insert_action.php",
      method: "POST",
      data: insert_form,
      success: function(data) {
        alert(data);
        $('#insert_form')[0].reset();
        $('#image_preview').html('');
      }
    });
  });
});

</script>
