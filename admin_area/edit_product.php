<?php

if (!isset($_SESSION['admin_email'])) {

  echo "<script>window.open('login','_self')</script>";
} else {

?>

  <?php

  if (isset($_GET['edit_product'])) {

    $edit_id = $_GET['edit_product'];

    $get_p = "select * from products where product_id='$edit_id'";

    $run_edit = mysqli_query($con, $get_p);

    $row_edit = mysqli_fetch_array($run_edit);

    $p_id = $row_edit['product_id'];

    $p_title = $row_edit['product_title'];

    $p_cat = $row_edit['p_cat_id'];

    $cat = $row_edit['cat_id'];

    $m_id = $row_edit['manufacturer_id'];

    $p_price = $row_edit['product_price'];

    $p_desc = $row_edit['product_desc'];

    $p_short_desc = $row_edit['product_short_desc'];

    $p_keywords = $row_edit['product_keywords'];

    $psp_price = $row_edit['product_psp_price'];

    $p_shipping_charges = $row_edit['shipping_charges'];

    $p_label = $row_edit['product_label'];

    // $p_url = $row_edit['product_url'];

    $p_features = $row_edit['product_features'];

    // $p_video = $row_edit['product_video'];
  }

  $get_manufacturer = "select * from manufacturers where manufacturer_id='$m_id'";

  $run_manufacturer = mysqli_query($con, $get_manufacturer);

  $row_manfacturer = mysqli_fetch_array($run_manufacturer);

  $manufacturer_id = $row_manfacturer['manufacturer_id'];

  $manufacturer_title = $row_manfacturer['manufacturer_title'];


  $get_p_cat = "select * from product_categories where p_cat_id='$p_cat'";

  $run_p_cat = mysqli_query($con, $get_p_cat);

  $row_p_cat = mysqli_fetch_array($run_p_cat);

  $p_cat_id = $row_p_cat['p_cat_id'];

  $p_cat_title = $row_p_cat['p_cat_title'];


  $get_cat = "select * from categories where cat_id='$cat'";

  $run_cat = mysqli_query($con, $get_cat);

  $row_cat = mysqli_fetch_array($run_cat);

  $cat_title = $row_cat['cat_title'];

  $cat_id = $row_cat['cat_id'];


  // Fetch product details
  $productQuery = "SELECT * FROM products WHERE product_id = '$p_id'";
  $productResult = mysqli_query($con, $productQuery);
  $product = mysqli_fetch_assoc($productResult);

  // Fetch product colors
  $colorQuery = "SELECT * FROM product_colors WHERE product_id = '$p_id'";
  $colorResult = mysqli_query($con, $colorQuery);
  $colors = [];
  while ($colorRow = mysqli_fetch_assoc($colorResult)) {
    $colors[] = $colorRow;
  }

  // Fetch product sizes
  $sizeQuery = "SELECT * FROM product_sizes WHERE product_id = '$p_id'";
  $sizeResult = mysqli_query($con, $sizeQuery);
  $sizes = [];
  while ($sizeRow = mysqli_fetch_assoc($sizeResult)) {
    $sizes[] = $sizeRow;
  }

  // Fetch product images
  $imageQuery = "SELECT * FROM product_images WHERE product_id = '$p_id'";
  $imageResult = mysqli_query($con, $imageQuery);
  $images = [];
  while ($imageRow = mysqli_fetch_assoc($imageResult)) {
    $images[] = $imageRow;
  }

  // Fetch suggested products with their titles
  $suggestionQuery = "
SELECT ps.id, ps.suggested_product_id, p.product_title 
FROM product_suggestions ps 
JOIN products p ON ps.suggested_product_id = p.product_id 
WHERE ps.product_id = '$p_id'
";
  $suggestionResult = mysqli_query($con, $suggestionQuery);
  $suggestedProducts = [];
  while ($suggestionRow = mysqli_fetch_assoc($suggestionResult)) {
    $suggestedProducts[] = [
      'id' => $suggestionRow['suggested_product_id'],
      'title' => $suggestionRow['product_title'],
      'id_sugg' => $suggestionRow['id']
    ];
  }
  ?>




  <!DOCTYPE html>

  <html>

  <head>

    <title> Edit Products </title>

    <script src="https://cdn.tiny.cloud/1/ilxmnvavt27i9067549554do76ljitygk312q7ka1ipem14k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#product_desc,#product_features',
        height: 500, // Editor height set karo
        plugins: [
          'advlist autolink link image lists charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
          'save table directionality emoticons template paste'
        ], // Enable more plugins
        toolbar: 'undo redo | styleselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify |' +
          'bullist numlist outdent indent | link image media | code preview fullscreen | forecolor backcolor emoticons |' +
          'table insertdatetime charmap hr anchor', // Add more buttons to the toolbar
        menubar: 'file edit view insert format tools table', // You can enable a full menubar too
        image_advtab: true, // Image advanced tab enabled
        branding: false, // Remove TinyMCE branding
        content_css: '//www.tiny.cloud/css/codepen.min.css' // Custom content CSS
      });
    </script>

  </head>

  <body>

    <div class="row"><!-- row Starts -->

      <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <ol class="breadcrumb"><!-- breadcrumb Starts -->

          <li class="active">

            <i class="fa fa-dashboard"> </i> Dashboard / Edit Products

          </li>

        </ol><!-- breadcrumb Ends -->

      </div><!-- col-lg-12 Ends -->

    </div><!-- row Ends -->


    <div class="row"><!-- 2 row Starts -->

      <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <div class="panel panel-default"><!-- panel panel-default Starts -->

          <div class="panel-heading"><!-- panel-heading Starts -->

            <h3 class="panel-title">

              <i class="fa fa-money fa-fw"></i> Edit Products

            </h3>
            <h3 style="text-align: center; color: red;">Note - 'Please fill Seriously Don't be play with color, sizes and image etc.'</h3>


          </div><!-- panel-heading Ends -->

          <div class="panel-body"><!-- panel-body Starts -->

            <form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Title </label>

                <div class="col-md-6">

                  <input type="text" name="product_title" class="form-control" required value="<?php echo $p_title; ?>">

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group">
                <label class="col-md-3 control-label">Select A Brand</label>
                <div class="col-md-6">
                  <select class="form-control" name="manufacturer">
                    <option value="<?php echo $manufacturer_id; ?>"><?php echo $manufacturer_title; ?></option>
                    <?php
                    $get_manufacturer = "SELECT * FROM manufacturers";
                    $run_manufacturer = mysqli_query($con, $get_manufacturer);
                    while ($row_manufacturer = mysqli_fetch_array($run_manufacturer)) {
                      $manufacturer_id = $row_manufacturer['manufacturer_id'];
                      $manufacturer_title1 = $row_manufacturer['manufacturer_title'];
                      if ($manufacturer_title === $manufacturer_title1) {
                        continue;
                      }
                      echo "<option value='$manufacturer_id'>$manufacturer_title1</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Category</label>
                <div class="col-md-6">
                  <select id="product_category" name="product_cat" class="form-control">
                    <option value="<?php echo $p_cat_id; ?>"><?php echo $p_cat_title; ?></option>
                    <?php
                    $get_p_cats = "SELECT * FROM product_categories";
                    $run_p_cats = mysqli_query($con, $get_p_cats);
                    while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
                      $p_cat_id1 = $row_p_cats['p_cat_id'];
                      $p_cat_title1 = $row_p_cats['p_cat_title'];
                      if ($p_cat_title === $p_cat_title1) {
                        continue;
                      }
                      echo "<option value='$p_cat_id1'>$p_cat_title1</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Sub-Category</label>
                <div class="col-md-6">
                  <select id="product_sub_category" name="cat" class="form-control">
                    <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                    <?php
                    $get_cats = "SELECT * FROM categories where p_cat_id = $p_cat_id";
                    $run_cats = mysqli_query($con, $get_cats);
                    while ($row_cats = mysqli_fetch_array($run_cats)) {
                      $cat_id1 = $row_cats['cat_id'];
                      $cat_title1 = $row_cats['cat_title'];
                      if ($cat_title === $cat_title1) {
                        continue;
                      }
                      echo "<option value='$cat_id1'>$cat_title1</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <h5 style="text-align: center; color: red; border: 1px solid black; padding: 4px; background-color: yellow;">Note: Keep in mind that if you delete or change a color, its corresponding image will also be deleted</h5>

              <div id="colorsContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Available Colors</label>
                  <div class="col-md-6">
                    <?php foreach ($colors as $color): ?>
                      <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <input type="text" name="colors[]" class="form-control"
                          value="<?php echo htmlspecialchars($color['color']); ?>" readonly>
                        <input type="hidden" name="color_ids[]" value="<?php echo $color['id']; ?>">
                        <button style="margin-left: 5px;" type="button" class="btn btn-danger btn-sm delete-color"
                          data-id="<?php echo $color['id']; ?>"
                          data-color-name="<?php echo htmlspecialchars($color['color']); ?>" data-product-id="<?php echo $color['product_id']; ?>" ;>Delete</button>
                      </div>

                      <!-- Display images associated with the color -->
                      <div class="color-images" style="margin-left: 10px; margin-bottom: 15px; display: flex; flex-wrap: wrap;">
                        <?php
                        // Fetch images for the current color from `product_images` table
                        $colorName = $color['color'];
                        $productId = $color['product_id'];
                        $imageQuery = "SELECT id, image FROM product_images WHERE color = ? AND product_id = ?";
                        $stmt = $con->prepare($imageQuery);
                        $stmt->bind_param("si", $colorName, $productId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Display each image with delete button
                        while ($image = $result->fetch_assoc()): ?>
                          <div style="margin-right: 10px; display: flex; flex-direction: column;">
                            <img src="product_images/<?php echo htmlspecialchars($image['image']); ?>"
                              alt="<?php echo htmlspecialchars($colorName); ?>"
                              style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                            <button style="padding: 2px; margin-top: 3px;" class="btn btn-danger btn-sm delete-image"
                              data-image-id="<?php echo $image['id']; ?>">Delete</button>
                          </div>
                        <?php endwhile; ?>
                        <?php $stmt->close(); ?>
                      </div>

                    <?php endforeach; ?>
                    <button type="button" id="addColor" class="btn btn-info">Add Color</button>
                  </div>
                </div>
              </div>

              <!-- Add Images Section -->
              <div id="imagesContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Upload Images</label>
                  <div class="col-md-6">
                    <button type="button" id="addImageButton" class="btn btn-info">Add Image</button>
                  </div>
                </div>
              </div>


              <div id="sizesContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Available Sizes</label>
                  <div class="col-md-6">
                    <?php foreach ($sizes as $size): ?>
                      <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <input type="text" name="sizes[]" class="form-control"
                          value="<?php echo htmlspecialchars($size['size']); ?>" readonly>
                        <input type="hidden" name="size_ids[]" value="<?php echo $size['id']; ?>">
                        <button style="margin-left: 5px;" type="button" class="btn btn-danger btn-sm delete-size"
                          data-id="<?php echo $size['id']; ?>">Delete</button>
                      </div>
                    <?php endforeach; ?>
                    <button type="button" id="addSize" class="btn btn-info">Add Size</button>
                  </div>
                </div>
              </div>



              <!-- <div id="imageContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Product Images</label>
                  <div class="col-md-6">
                    <?php foreach ($images as $image): ?>
                      <div style="border: 1px solid black; padding: 20px; margin-bottom: 10px;">
                        <input type="file" name="images[]">
                        <br><img src="product_images/<?php echo $image['image']; ?>" width="70" height="70">
                        <span>Color: <strong><?php echo $image['color']; ?></strong></span>
                        <input type="hidden" name="image_ids[]" value="<?php echo $image['id']; ?>">
                        <input type="checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>"> Delete
                      </div>
                    <?php endforeach; ?>
                    <button type="button" id="addImage" class="btn btn-info">Add Image</button>
                  </div>
                </div>
              </div> -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Price </label>

                <div class="col-md-6">

                  <input type="text" name="product_price" class="form-control" required value="<?php echo $p_price; ?>">

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Sale Price </label>

                <div class="col-md-6">

                  <input type="text" name="psp_price" class="form-control" required value="<?php echo $psp_price; ?>">

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Keywords </label>

                <div class="col-md-6">

                  <input type="text" name="product_keywords" class="form-control" required value="<?php echo $p_keywords; ?>">

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Label </label>

                <div class="col-md-6">

                  <input type="text" name="product_label" class="form-control" required value="<?php echo $p_label; ?>">

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Short Description </label>

                <div class="col-md-6">

                  <input type="text" name="product_short_desc" class="form-control" required value="<?php echo $p_short_desc; ?>">

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group">
                <label class="col-md-3 control-label">Shipping Charges</label>
                <div class="col-md-6">
                  <input type="text" name="shipping_charges" class="form-control" value="<?php echo $p_shipping_charges; ?>">
                </div>
              </div>

              <div id="suggestedProductsContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Already Suggested Products</label>
                  <div class="col-md-6">
                    <?php foreach ($suggestedProducts as $suggestedProduct): ?>
                      <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <input type="text" name="suggested_products[]" class="form-control"
                          value="<?php echo $suggestedProduct['title']; ?>" readonly>
                        <input type="hidden" name="suggested_product_ids[]" value="<?php echo $suggestedProduct['id_sugg']; ?>">
                        <button style="margin-left: 5px;" type="button" class="btn btn-danger btn-sm delete-suggested-product"
                          data-id="<?php echo $suggestedProduct['id_sugg']; ?>">
                          Delete
                        </button>
                      </div>
                    <?php endforeach; ?>
                    <button type="button" id="addSuggestedProduct" class="btn btn-info">Add Suggested Product</button>
                  </div>
                </div>
              </div>


              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"> Product Tabs </label>

                <div class="col-md-6">

                  <ul class="nav nav-tabs"><!-- nav nav-tabs Starts -->

                    <li class="active">

                      <a data-toggle="tab" href="#description"> Product Description </a>

                    </li>

                    <li>

                      <a data-toggle="tab" href="#features"> Product Features </a>

                    </li>

                  </ul><!-- nav nav-tabs Ends -->

                  <div class="tab-content"><!-- tab-content Starts -->

                    <div id="description" class="tab-pane fade in active"><!-- description tab-pane fade in active Starts -->

                      <br>

                      <textarea name="product_desc" class="form-control" rows="15" id="product_desc">

<?php echo $p_desc; ?>

</textarea>

                    </div><!-- description tab-pane fade in active Ends -->


                    <div id="features" class="tab-pane fade in"><!-- features tab-pane fade in Starts -->

                      <br>

                      <textarea name="product_features" class="form-control" rows="15" id="product_features">

<?php echo $p_features; ?>

</textarea>

                    </div><!-- features tab-pane fade in Ends -->


                  </div><!-- tab-content Ends -->

                </div>

              </div><!-- form-group Ends -->

              <div class="form-group"><!-- form-group Starts -->

                <label class="col-md-3 control-label"></label>

                <div class="col-md-6">

                  <input type="submit" name="update" value="Update Product" class="btn btn-primary form-control">

                </div>

              </div><!-- form-group Ends -->

            </form><!-- form-horizontal Ends -->

          </div><!-- panel-body Ends -->

        </div><!-- panel panel-default Ends -->

      </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->


    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const imagesContainer = document.getElementById('imagesContainer');
        const addImageButton = document.getElementById('addImageButton');

        // Handle Add Image button click
        addImageButton.addEventListener('click', function() {
          // Create the outer form group div for styling consistency
          const formGroup = document.createElement('div');
          formGroup.className = 'form-group';

          // Label for Image and Color Selection
          const imageLabel = document.createElement('label');
          imageLabel.className = 'col-md-3 control-label';
          imageLabel.textContent = 'Product Image';

          // Container for dropdown, file input, and remove button
          const inputContainer = document.createElement('div');
          inputContainer.className = 'col-md-6 d-flex align-items-center';
          inputContainer.style.display = 'flex';
          inputContainer.style.gap = '10px'; // Adjusts spacing between elements

          // Generate color options from available colors in the DOM
          let colorOptions = '<option value="">Select Color</option>';
          document.querySelectorAll('input[name="colors[]"], input[name="new_colors[]"]').forEach(colorInput => {
            colorOptions += `<option value="${colorInput.value}">${colorInput.value}</option>`;
          });

          // Color select dropdown
          const colorSelect = document.createElement('select');
          colorSelect.name = 'image_colors[]';
          colorSelect.className = 'form-control';
          colorSelect.innerHTML = colorOptions;
          colorSelect.required = true;

          // Image file input
          const imageInput = document.createElement('input');
          imageInput.type = 'file';
          imageInput.name = 'images[]';
          imageInput.accept = 'image/*';
          imageInput.className = 'form-control-file';
          imageInput.required = true;

          // Remove button
          const removeButton = document.createElement('button');
          removeButton.type = 'button';
          removeButton.className = 'btn btn-danger btn-sm';
          removeButton.textContent = 'Remove';
          removeButton.addEventListener('click', function() {
            formGroup.remove(); // Removes the entire form group div
          });

          // Append select, input, and button to the input container
          inputContainer.appendChild(colorSelect);
          inputContainer.appendChild(imageInput);
          inputContainer.appendChild(removeButton);

          // Append label and input container to the form group
          formGroup.appendChild(imageLabel);
          formGroup.appendChild(inputContainer);

          // Append the entire form group to the main container
          imagesContainer.appendChild(formGroup);
        });

      });


      document.addEventListener('DOMContentLoaded', function() {
        // Handle deletion of colors
        document.querySelectorAll('.delete-color').forEach(button => {
          button.addEventListener('click', function() {
            const colorId = this.getAttribute('data-id');
            const colorName = this.getAttribute('data-color-name');
            const productId = this.getAttribute('data-product-id');

            // AJAX request to delete color and its associated images
            fetch('delete_color.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  id: colorId,
                  color: colorName,
                  productId: productId
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  this.closest('div').remove(); // Remove deleted item from the DOM
                  location.reload();
                } else {
                  alert('Failed to delete color.');
                }
              })
              .catch(error => console.error('Error:', error));
          });
        });

        document.querySelectorAll('.delete-image').forEach(function(deleteButton) {
          deleteButton.addEventListener('click', function() {
            const imageId = this.dataset.imageId;

              // Make AJAX request to delete the image from the database
              fetch('delete_image.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                  },
                  body: JSON.stringify({
                    image_id: imageId
                  })
                })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    alert('Image deleted successfully!');
                    // Remove the image from the UI
                    this.closest('.color-images').removeChild(this.closest('div'));
                  } else {
                    alert('An error occurred while deleting the image.');
                  }
                })
                .catch(error => {
                  alert('Error: ' + error);
                });
          });
        });


        // Add new color input field
        document.getElementById('addColor').addEventListener('click', function() {
          const container = document.getElementById('colorsContainer');

          // Create the outer div for the form group
          const formGroup = document.createElement('div');
          formGroup.className = 'form-group';

          // Create the label for the color input
          const colorLabel = document.createElement('label');
          colorLabel.className = 'col-md-3 control-label';
          colorLabel.textContent = 'Product Color';

          // Create the div to hold the input and remove button, styled with flex
          const inputContainer = document.createElement('div');
          inputContainer.className = 'col-md-6 d-flex align-items-center';
          inputContainer.style.display = 'flex';
          inputContainer.style.gap = '10px'; // Adjusts gap between input and button

          // Color input field
          const colorInput = document.createElement('input');
          colorInput.type = 'text';
          colorInput.name = 'new_colors[]';
          colorInput.className = 'form-control';
          colorInput.placeholder = 'Enter color';

          // Remove button
          const removeButton = document.createElement('button');
          removeButton.type = 'button';
          removeButton.className = 'btn btn-danger btn-sm';
          removeButton.textContent = 'Remove';
          removeButton.addEventListener('click', function() {
            formGroup.remove(); // Removes the entire form group
          });

          // Append input and button to the input container
          inputContainer.appendChild(colorInput);
          inputContainer.appendChild(removeButton);

          // Append label and input container to the form group
          formGroup.appendChild(colorLabel);
          formGroup.appendChild(inputContainer);

          // Append the entire form group to the container
          container.appendChild(formGroup);
        });

      });



      document.addEventListener('DOMContentLoaded', function() {
        // Handle deletion of sizes
        document.querySelectorAll('.delete-size').forEach(button => {
          button.addEventListener('click', function() {
            const sizeId = this.getAttribute('data-id');

            // AJAX request to delete size
            fetch('delete_size.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  id: sizeId
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  this.closest('div').remove(); // Remove deleted item from the DOM
                } else {
                  alert('Failed to delete size.');
                }
              })
              .catch(error => console.error('Error:', error));
          });
        });

        // Add new size input field
        document.getElementById('addSize').addEventListener('click', function() {
          // Create the outer form group div for styling consistency
          const formGroup = document.createElement('div');
          formGroup.className = 'form-group';

          // Label for the new size input
          const sizeLabel = document.createElement('label');
          sizeLabel.className = 'col-md-3 control-label';
          sizeLabel.textContent = 'Product Size';

          // Container for the input and remove button
          const inputContainer = document.createElement('div');
          inputContainer.className = 'col-md-6 d-flex align-items-center';
          inputContainer.style.display = 'flex';
          inputContainer.style.gap = '10px'; // Adjusts spacing between elements

          // New size input field
          const sizeInput = document.createElement('input');
          sizeInput.type = 'text';
          sizeInput.name = 'new_sizes[]';
          sizeInput.className = 'form-control';
          sizeInput.placeholder = 'Enter size';

          // Remove button
          const removeButton = document.createElement('button');
          removeButton.type = 'button';
          removeButton.className = 'btn btn-danger btn-sm';
          removeButton.textContent = 'Remove';
          removeButton.addEventListener('click', function() {
            formGroup.remove(); // Removes the entire form group div
          });

          // Append input and button to the input container
          inputContainer.appendChild(sizeInput);
          inputContainer.appendChild(removeButton);

          // Append label and input container to the form group
          formGroup.appendChild(sizeLabel);
          formGroup.appendChild(inputContainer);

          // Append the entire form group to the main container
          document.getElementById('sizesContainer').appendChild(formGroup);
        });

      });


      document.addEventListener('DOMContentLoaded', function() {
        // Handle deletion of suggested products
        document.querySelectorAll('.delete-suggested-product').forEach(button => {
          button.addEventListener('click', function() {
            const suggestionId = this.getAttribute('data-id');

            // AJAX request to delete suggestion
            fetch('delete_suggested_product.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  id: suggestionId
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  this.closest('div').remove(); // Remove deleted item from the DOM
                } else {
                  alert('Failed to delete suggested product.');
                }
              })
              .catch(error => console.error('Error:', error));
          });
        });

        // Add new suggested product input field
        document.getElementById('addSuggestedProduct').addEventListener('click', function() {
          const container = document.getElementById('suggestedProductsContainer');
          const newSuggestedProductDiv = document.createElement('div');

          // Create the outer form group div for styling consistency
          const formGroup = document.createElement('div');
          formGroup.className = 'form-group';

          // Label for the new suggested product input
          const label = document.createElement('label');
          label.className = 'col-md-3 control-label';
          label.textContent = 'Suggested Product';

          // Create the input container for flex layout
          const inputContainer = document.createElement('div');
          inputContainer.className = 'col-md-6 d-flex align-items-center';
          inputContainer.style.display = 'flex';
          inputContainer.style.gap = '10px'; // Adjusts spacing between dropdown and button

          // Create the product select dropdown
          const productSelect = document.createElement('select');
          productSelect.name = 'new_suggested_products[]';
          productSelect.className = 'form-control';

          // Fetch products from PHP and populate the dropdown
          const products = <?php
                            $allProductsQuery = "SELECT product_id, product_title FROM products";
                            $allProductsResult = mysqli_query($con, $allProductsQuery);
                            $productArray = [];
                            while ($product = mysqli_fetch_assoc($allProductsResult)) {
                              $productArray[] = [
                                'product_id' => $product['product_id'],
                                'product_title' => $product['product_title']
                              ];
                            }
                            echo json_encode($productArray);
                            ?>;

          // Add options to the dropdown
          products.forEach(function(product) {
            const option = document.createElement('option');
            option.value = product.product_id;
            option.textContent = product.product_title;
            productSelect.appendChild(option);
          });

          // Create the remove button
          const removeButton = document.createElement('button');
          removeButton.type = 'button';
          removeButton.className = 'btn btn-danger btn-sm';
          removeButton.textContent = 'Remove';

          // Add event listener to remove the suggested product when clicked
          removeButton.addEventListener('click', function() {
            formGroup.remove(); // Remove the entire form group (dropdown + remove button)
          });

          // Append the dropdown and remove button to the input container
          inputContainer.appendChild(productSelect);
          inputContainer.appendChild(removeButton);

          // Append the label and input container to the form group
          formGroup.appendChild(label);
          formGroup.appendChild(inputContainer);

          // Append the entire form group to the container
          container.appendChild(formGroup);
        });

      });
    </script>

  </body>

  </html>

  <?php

  if (isset($_POST['update'])) {



    if (!empty($_POST['new_colors'])) {
      foreach ($_POST['new_colors'] as $newColor) {
        $insertQuery = "INSERT INTO product_colors (product_id, color) 
                          VALUES ('$p_id', '$newColor')";
        mysqli_query($con, $insertQuery);
      }
    }

    if (!empty($_POST['delete_sizes'])) {
      foreach ($_POST['delete_sizes'] as $sizeId) {
        $deleteQuery = "DELETE FROM product_sizes WHERE id='$sizeId'";
        mysqli_query($con, $deleteQuery);
      }
    }

    // Insert new sizes if any
    if (!empty($_POST['new_sizes'])) {
      foreach ($_POST['new_sizes'] as $newSize) {
        $insertQuery = "INSERT INTO product_sizes (product_id, size) 
                          VALUES ('$p_id', '$newSize')";
        mysqli_query($con, $insertQuery);
      }
    }

    // Delete selected images
    if (!empty($_POST['delete_images'])) {
      $delete_images = $_POST['delete_images'];
      foreach ($delete_images as $image_id) {
        $delete_image_query = "DELETE FROM product_images WHERE id='$image_id'";
        mysqli_query($con, $delete_image_query);
      }
    }

    if (!empty($_POST['delete_suggested_products'])) {
      foreach ($_POST['delete_suggested_products'] as $suggestionId) {
        $deleteQuery = "DELETE FROM product_suggestions WHERE id='$suggestionId'";
        mysqli_query($con, $deleteQuery);
      }
    }

    // Insert new suggested products
    if (!empty($_POST['new_suggested_products'])) {
      foreach ($_POST['new_suggested_products'] as $suggestedProductId) {
        $insertQuery = "INSERT INTO product_suggestions (product_id, suggested_product_id) 
                          VALUES ('$p_id', '$suggestedProductId')";
        mysqli_query($con, $insertQuery);
      }
    }



    // Escape user inputs to prevent SQL injection
    $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_cat = mysqli_real_escape_string($con, $_POST['product_cat']);
    $cat = mysqli_real_escape_string($con, $_POST['cat']);
    $manufacturer_id = mysqli_real_escape_string($con, $_POST['manufacturer']);
    $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
    $product_desc = mysqli_real_escape_string($con, $_POST['product_desc']);
    $product_short_desc = mysqli_real_escape_string($con, $_POST['product_short_desc']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $psp_price = mysqli_real_escape_string($con, $_POST['psp_price']);
    $product_label = mysqli_real_escape_string($con, $_POST['product_label']);
    $product_features = mysqli_real_escape_string($con, $_POST['product_features']);
    $product_shipping_charges = mysqli_real_escape_string($con, $_POST['shipping_charges']);

    // Update main product details
    $update_product = "UPDATE products SET 
      product_short_desc='$product_short_desc',
      p_cat_id='$product_cat',
      cat_id='$cat',
      manufacturer_id='$manufacturer_id',
      date=NOW(),
      product_title='$product_title',
      product_price='$product_price',
      product_psp_price='$psp_price',
      product_desc='$product_desc',
      product_features='$product_features',
      product_keywords='$product_keywords',
      product_label='$product_label',
      shipping_charges='$product_shipping_charges'
      WHERE product_id='$p_id'";

    $run_product = mysqli_query($con, $update_product);

    if ($run_product) {





      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // $productId = $_POST['product_id'];
        // $uploadedImages = [];

        // Loop through each uploaded image and its corresponding color
        foreach ($_FILES['images']['name'] as $index => $imageName) {
          $color = $_POST['image_colors'][$index];
          $imageTmpName = $_FILES['images']['tmp_name'][$index];
          $uploadDir = 'product_images/';
          $filePath = $uploadDir . basename($imageName);

          // Move each uploaded image to the uploads folder
          if (move_uploaded_file($imageTmpName, $filePath)) {
            // Insert into database
            $insertImageQuery = "INSERT INTO product_images (product_id, image, color) VALUES (?, ?, ?)";
            $stmt = $con->prepare($insertImageQuery);
            $stmt->bind_param("iss", $p_id, $imageName, $color);
            $stmt->execute();
          }
        }
      }




      echo "<script> alert('Product has been updated successfully') </script>";
      echo "<script>window.open('index?view_products','_self')</script>";
    } else {
      echo "<script> alert('Error updating product') </script>";
    }
  }

  ?>


<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#product_category').change(function() {
      var p_cat_id = $(this).val(); // Get selected category ID
      if (p_cat_id) {
        $.ajax({
          type: 'POST',
          url: 'fetch_product_sub_categories', // Your PHP file to fetch subcategories
          data: {
            p_cat_id: p_cat_id
          },
          success: function(html) {
            $('#product_sub_category').html(html); // Populate subcategory dropdown
          }
        });
      } else {
        $('#product_sub_category').html('<option value="">Select a Product Sub-Category</option>'); // Reset subcategory dropdown
      }
    });
  });
</script>