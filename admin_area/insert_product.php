<?php

if (!isset($_SESSION['admin_email'])) {
  echo "<script>window.open('login','_self')</script>";
} else {

?>
  <!DOCTYPE html>
  <html>

  <head>
    <title> Insert Products </title>
    <script src="https://cdn.tiny.cloud/1/ilxmnvavt27i9067549554do76ljitygk312q7ka1ipem14k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#product_desc,#product_features',
        height: 500,
        plugins: [
          'advlist autolink link image lists charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
          'save table directionality emoticons template paste'
        ],
        toolbar: 'undo redo | styleselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify |' +
          'bullist numlist outdent indent | link image media | code preview fullscreen | forecolor backcolor emoticons |' +
          'table insertdatetime charmap hr anchor',
        menubar: 'file edit view insert format tools table',
        image_advtab: true,
        branding: false,
        content_css: '//www.tiny.cloud/css/codepen.min.css'
      });
    </script>

    <style>
      .center_vs {
        width: 100%;
        display: flex;
        justify-content: center;
      }

      .flex_vs {
        display: flex;
        gap: 5px;
      }
    </style>
  </head>

  <body>
    <div class="row">
      <div class="col-lg-12">
        <ol class="breadcrumb">
          <li class="active"><i class="fa fa-dashboard"> </i> Dashboard / Insert Products</li>
        </ol>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Insert Products</h3>
            <h3 style="text-align: center; color: red;">Note - 'Please fill Seriously Don't be play with color, sizes and image etc.'</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-md-3 control-label">Product Title</label>
                <div class="col-md-6">
                  <input type="text" name="product_title" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Select A Brand</label>
                <div class="col-md-6">
                  <select class="form-control" name="manufacturer">
                    <option>Select A Brand</option>
                    <?php
                    $get_manufacturer = "SELECT * FROM manufacturers";
                    $run_manufacturer = mysqli_query($con, $get_manufacturer);
                    while ($row_manufacturer = mysqli_fetch_array($run_manufacturer)) {
                      $manufacturer_id = $row_manufacturer['manufacturer_id'];
                      $manufacturer_title = $row_manufacturer['manufacturer_title'];
                      echo "<option value='$manufacturer_id'>$manufacturer_title</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Category</label>
                <div class="col-md-6">
                  <select id="product_category" name="product_cat" class="form-control">
                    <option value="">Select a Product Category</option>
                    <?php
                    $get_p_cats = "SELECT * FROM product_categories";
                    $run_p_cats = mysqli_query($con, $get_p_cats);
                    while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
                      $p_cat_id = $row_p_cats['p_cat_id'];
                      $p_cat_title = $row_p_cats['p_cat_title'];
                      echo "<option value='$p_cat_id'>$p_cat_title</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Sub-Category</label>
                <div class="col-md-6">
                  <select id="product_sub_category" name="cat" class="form-control">
                    <option value="">Select a Product Sub-Category</option>
                  </select>
                </div>
              </div>

              <div id="colorContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Colors</label>
                  <div class="col-md-6">
                    <button type="button" id="addColor" class="btn btn-info">Add Color</button>
                  </div>
                </div>
              </div>

              <div id="sizeContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Sizes</label>
                  <div class="col-md-6">
                    <button type="button" id="addSize" class="btn btn-info">Add Size</button>
                  </div>
                </div>
              </div>

              <div id="imageContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Product Image</label>
                  <div class="col-md-6">
                    <button type="button" id="addImage" class="btn btn-info">Add Images</button>
                  </div>
                </div>
              </div>

              <!-- <div id="priceContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Product Price</label>
                  <div class="col-md-6">
                    <button type="button" id="addPrice" class="btn btn-info">Add Price</button>
                  </div>
                </div>
              </div>

              <div id="pricePSPContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Product Sell Price</label>
                  <div class="col-md-6">
                    <button type="button" id="addPSPPrice" class="btn btn-info">Add PSP Price</button>
                  </div>
                </div>
              </div> -->

              <div class="form-group">
                <label class="col-md-3 control-label">Product Price</label>
                <div class="col-md-6">
                  <input type="text" name="product_price" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Sale Price</label>
                <div class="col-md-6">
                  <input type="text" name="psp_price" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Keywords</label>
                <div class="col-md-6">
                  <input type="text" name="product_keywords" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Label</label>
                <div class="col-md-6">
                  <input type="text" name="product_label" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Product Short Description</label>
                <div class="col-md-6">
                  <input type="text" name="product_short_desc" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Shipping Charges</label>
                <div class="col-md-6">
                  <input type="text" name="shipping_charges" class="form-control" placeholder="Enter Shipping Charges (or leave empty for no charges)">
                </div>
              </div>

              <div id="suggestedProductsContainer">
                <div class="form-group">
                  <label class="col-md-3 control-label">Suggested Products</label>
                  <div class="col-md-6">
                    <button type="button" id="addSuggestedProduct" class="btn btn-info">Add Suggested Product</button>
                  </div>
                </div>
              </div>




              <div class="form-group">
                <label class="col-md-3 control-label">Product Tabs</label>
                <div class="col-md-6">
                  <ul class="nav nav-tabs">
                    <li class="active">
                      <a data-toggle="tab" href="#description">Product Description</a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#features">Product Features</a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div id="description" class="tab-pane fade in active">
                      <br>
                      <textarea name="product_desc" class="form-control" rows="15" id="product_desc"></textarea>
                    </div>
                    <div id="features" class="tab-pane fade in">
                      <br>
                      <textarea name="product_features" class="form-control" rows="15" id="product_features"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <input type="submit" name="submit" value="Insert Product" class="btn btn-primary form-control">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      let colorCounter = 1;
      let sizeCounter = 1;
      let imageCounter = 1;
      // let priceCounter = 1;
      // let pricePSPContainer = 1;

      let suggestedProductCounter = 1;

      <?php
      // Include your database connection file
      include './includes/db.php';

      // Fetch available products from the database
      $get_products = "SELECT * FROM products"; // Adjust the query as needed
      $run_products = mysqli_query($con, $get_products);
      $products_options = '';

      while ($row_products = mysqli_fetch_array($run_products)) {
        $product_id = $row_products['product_id'];
        $product_title = htmlspecialchars($row_products['product_title'], ENT_QUOTES);
        $products_options .= "<option value='$product_id'>$product_title</option>";
      }
      ?>

      document.getElementById('addSuggestedProduct').addEventListener('click', function() {
        const suggestedProductGroup = document.createElement('div');
        suggestedProductGroup.className = 'form-group';

        const suggestedProductLabel = document.createElement('label');
        suggestedProductLabel.textContent = `Suggested Product ${suggestedProductCounter++}`;
        suggestedProductLabel.className = 'col-md-3 control-label';

        const suggestedProductDiv = document.createElement('div');
        suggestedProductDiv.className = 'col-md-6 flex_vs';

        const suggestedProductSelect = document.createElement('select');
        suggestedProductSelect.name = 'suggested_products[]';
        suggestedProductSelect.className = 'form-control';
        suggestedProductSelect.required = true;
        suggestedProductSelect.innerHTML = `<option value=''>Select Suggested Product</option>` + `<?php echo $products_options; ?>`;

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
          suggestedProductGroup.remove();
        });

        suggestedProductDiv.appendChild(suggestedProductSelect);
        suggestedProductDiv.appendChild(removeButton);

        suggestedProductGroup.appendChild(suggestedProductLabel);
        suggestedProductGroup.appendChild(suggestedProductDiv);

        document.getElementById('suggestedProductsContainer').appendChild(suggestedProductGroup);
      });




      document.getElementById('addColor').addEventListener('click', function() {
        const colorGroup = document.createElement('div');
        colorGroup.className = 'form-group';

        const colorLabel = document.createElement('label');
        colorLabel.textContent = `Color ${colorCounter++}`;
        colorLabel.className = 'col-md-3 control-label';

        const colorInput = document.createElement('input');
        colorInput.type = 'text';
        colorInput.name = 'colors[]';
        colorInput.className = 'form-control';
        colorInput.placeholder = 'Add Color';

        const colorDiv = document.createElement('div');
        colorDiv.className = 'col-md-6 flex_vs';
        colorDiv.appendChild(colorInput);

        // Remove button
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
          colorGroup.remove();
        });
        colorDiv.appendChild(removeButton);

        colorGroup.appendChild(colorLabel);
        colorGroup.appendChild(colorDiv);

        document.getElementById('colorContainer').appendChild(colorGroup);
      });

      document.getElementById('addSize').addEventListener('click', function() {
        const sizeGroup = document.createElement('div');
        sizeGroup.className = 'form-group';

        const sizeLabel = document.createElement('label');
        sizeLabel.textContent = `Size ${sizeCounter++}`;
        sizeLabel.className = 'col-md-3 control-label';

        const sizeInput = document.createElement('input');
        sizeInput.type = 'text';
        sizeInput.name = 'sizes[]';
        sizeInput.className = 'form-control';
        sizeInput.placeholder = 'Add Size';

        const sizeDiv = document.createElement('div');
        sizeDiv.className = 'col-md-6 flex_vs';
        sizeDiv.appendChild(sizeInput);

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
          sizeGroup.remove();
        });
        sizeDiv.appendChild(removeButton);

        sizeGroup.appendChild(sizeLabel);
        sizeGroup.appendChild(sizeDiv);

        document.getElementById('sizeContainer').appendChild(sizeGroup);
      });





      document.getElementById('addImage').addEventListener('click', function() {
        const imageGroup = document.createElement('div');
        imageGroup.className = 'form-group row flex_vs';

        const imageLabel = document.createElement('label');
        imageLabel.textContent = `Image ${imageCounter}`;
        imageLabel.className = 'col-md-3 control-label';

        const imageInputDiv = document.createElement('div');
        imageInputDiv.className = 'col-md-4';

        const imageInput = document.createElement('input');
        imageInput.type = 'file';
        imageInput.name = 'product_images[]';
        imageInput.className = 'form-control';
        imageInputDiv.appendChild(imageInput);

        const colorLabel = document.createElement('label');
        colorLabel.textContent = `Color for Image ${imageCounter}`;
        colorLabel.className = 'col-md-3 control-label';

        const colorSelectDiv = document.createElement('div');
        colorSelectDiv.className = 'col-md-2';

        const colorSelect = document.createElement('select');
        colorSelect.name = 'image_colors[]';
        colorSelect.className = 'form-control';

        // Fetch colors from the colorContainer
        const colorOptions = document.querySelectorAll('#colorContainer input');
        colorOptions.forEach(colorInput => {
          const option = document.createElement('option');
          option.value = colorInput.value;
          option.textContent = colorInput.value;
          colorSelect.appendChild(option);
        });

        colorSelectDiv.appendChild(colorSelect);

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
          imageGroup.remove();
        });

        imageGroup.appendChild(imageLabel);
        imageGroup.appendChild(imageInputDiv);
        imageGroup.appendChild(colorLabel);
        imageGroup.appendChild(colorSelectDiv);
        imageGroup.appendChild(removeButton);

        document.getElementById('imageContainer').appendChild(imageGroup);

        imageCounter++;
      });




      // //purana
      // document.getElementById('addImage').addEventListener('click', function() {
      //   const imageGroup = document.createElement('div');
      //   imageGroup.className = 'form-group row';

      //   // Label for the image input
      //   const imageLabel = document.createElement('label');
      //   imageLabel.textContent = `Image ${imageCounter}`;
      //   imageLabel.className = 'col-md-3 control-label';

      //   // Image input
      //   const imageInputDiv = document.createElement('div');
      //   imageInputDiv.className = 'col-md-4';

      //   const imageInput = document.createElement('input');
      //   imageInput.type = 'file';
      //   imageInput.name = 'product_images[]';
      //   imageInput.className = 'form-control';
      //   imageInputDiv.appendChild(imageInput);

      //   // Label for the color select
      //   const colorLabel = document.createElement('label');
      //   colorLabel.textContent = `Color for Image ${imageCounter}`;
      //   colorLabel.className = 'col-md-3 control-label';

      //   // Color select dropdown
      //   const colorSelectDiv = document.createElement('div');
      //   colorSelectDiv.className = 'col-md-2';

      //   const colorSelect = document.createElement('select');
      //   colorSelect.name = 'image_colors[]';
      //   colorSelect.className = 'form-control';

      //   // Fetch colors from the colorContainer
      //   const colorOptions = document.querySelectorAll('#colorContainer input');
      //   colorOptions.forEach(colorInput => {
      //     const option = document.createElement('option');
      //     option.value = colorInput.value;
      //     option.textContent = colorInput.value;
      //     colorSelect.appendChild(option);
      //   });

      //   colorSelectDiv.appendChild(colorSelect);

      //   // Append all elements to the group
      //   imageGroup.appendChild(imageLabel);
      //   imageGroup.appendChild(imageInputDiv);
      //   imageGroup.appendChild(colorLabel);
      //   imageGroup.appendChild(colorSelectDiv);

      //   // Add the new image group to the image container
      //   document.getElementById('imageContainer').appendChild(imageGroup);

      //   // Increment image counter
      //   imageCounter++;
      // });
    </script>
  </body>

  </html>


  <?php
  if (isset($_POST['submit'])) {
    $product_title = $_POST['product_title'];
    $manufacturer_id = $_POST['manufacturer'];
    $product_cat = $_POST['product_cat'];
    $product_sub_cat = $_POST['cat'];
    $colors = $_POST['colors'];
    $sizes = $_POST['sizes'];
    $product_price = $_POST['product_price'];
    $psp_price = $_POST['psp_price'];
    $product_keywords = $_POST['product_keywords'];
    $product_label = $_POST['product_label'];
    $product_short_desc = $_POST['product_short_desc'];
    $product_desc = $_POST['product_desc'];
    $product_features = $_POST['product_features'];
    $suggested_products = $_POST['suggested_products'];

    // Handle shipping charges - if empty, set to 0
    $shipping_charges = !empty($_POST['shipping_charges']) ? $_POST['shipping_charges'] : 0;

    // $suggested_products = isset($_POST['suggested_products']) ? $_POST['suggested_products'] : [];
    // $suggested_product_ids = implode(',', $suggested_products);

    // Insert the product into the products table with shipping charges
    $insert_product = "INSERT INTO products (
        product_title, manufacturer_id, p_cat_id, cat_id, product_keywords, product_label, product_short_desc, 
        product_desc, product_features, product_price, product_psp_price, shipping_charges
    ) VALUES (
        '$product_title', '$manufacturer_id', '$product_cat', '$product_sub_cat', '$product_keywords', 
        '$product_label', '$product_short_desc', '$product_desc', '$product_features', '$product_price', 
        '$psp_price', '$shipping_charges'
    )";

    $run_product = mysqli_query($con, $insert_product);

    if ($run_product) {
      // Get the last inserted product ID
      $product_id = mysqli_insert_id($con);

      // Process colors
      foreach ($colors as $color) {
        // Insert color into product_colors table
        $insert_color = "INSERT INTO product_colors (product_id, color) VALUES ('$product_id', '$color')";
        mysqli_query($con, $insert_color);
      }

      // Process sizes
      foreach ($sizes as $size) {
        // Insert size into product_sizes table
        $insert_size = "INSERT INTO product_sizes (product_id, size) VALUES ('$product_id', '$size')";
        mysqli_query($con, $insert_size);
      }

      foreach ($suggested_products as $suggested_product_id) {
        // Insert each suggested product into your database table
        $insert_suggested_product = "INSERT INTO product_suggestions (product_id, suggested_product_id) VALUES ('$product_id', '$suggested_product_id')";
        mysqli_query($con, $insert_suggested_product);
      }

      //process prices
      // $product_prices = $_POST['product_prices'];
      // $price_sizes = $_POST['price_sizes'];

      // foreach ($product_prices as $index => $product_price) {
      //   $insert_price = "INSERT INTO product_prices (product_id, price, size) VALUES ('$product_id', '$product_price', '{$price_sizes[$index]}')";
      //   mysqli_query($con, $insert_price);
      // }

      //process psp prices
      // $product_psp_prices = $_POST['product_psp_prices'];
      // $psp_price_sizes = $_POST['psp_price_sizes'];

      // foreach ($product_psp_prices as $index => $product_psp_price) {
      //   $insert_psp_price = "INSERT INTO product_psp_prices (product_id, psp_price, size) VALUES ('$product_id', '$product_psp_price', '{$psp_price_sizes[$index]}')";
      //   mysqli_query($con, $insert_psp_price);
      // }

      // Process images
      $image_names = $_FILES['product_images']['name'];
      $image_colors = $_POST['image_colors'];

      foreach ($image_names as $index => $image_name) {
        if ($_FILES['product_images']['error'][$index] == 0) {
          $temp_name = $_FILES['product_images']['tmp_name'][$index];
          move_uploaded_file($temp_name, "product_images/$image_name");

          // Insert into product_images table
          $insert_image = "INSERT INTO product_images (product_id, image, color) VALUES ('$product_id', '$image_name', '{$image_colors[$index]}')";
          mysqli_query($con, $insert_image);
        }
      }
      echo "<script>alert('Product has been inserted successfully!')</script>";
      echo "<script>window.open('index?view_products', '_self')</script>";
    } else {
      echo "<script>alert('Product insertion failed!')</script>";
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