<?php
include './includes/db.php';

$query_head1 = "SELECT * FROM manufacturers where manufacturer_top = 'yes'";
$result_head1 = mysqli_query($con, $query_head1);

$query_head2 = "SELECT * FROM product_categories where p_cat_top = 'yes'";
$result_head2 = mysqli_query($con, $query_head2);
?>

<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<style>
    .add-to-cart a {
        color: white;
        text-decoration: none;
    }

    @media (max-width:768px) {
        .media-use {
            margin-top: 6rem;
        }

    }
</style>

<div class="backtotop">
    <a href="#" class="scroll"><i class="fa-solid fa-arrow-up"></i></a>
</div>

<header class="site_header">
    <div class="header_bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg col">
                    <div class="site_logo">
                        <a class="site_link" href="index"><img
                                class="dark_theme_logo  "
                                src="./Moto Dresser/Moto_dresser.png"
                                alt="Site Logo – ProMotors – Car Service & Detailing Template" />
                            <img
                                class="light_theme_logo"
                                src="./Moto Dresser/Moto_dresser.png" alt="Site Logo – ProMotors – Car Service & Detailing Template" /></a>
                    </div>
                </div>
                <div class="col-lg-6 col-2">

                    <nav class="main_menu navbar navbar-expand-lg media-use">
                        <div class="main_menu_inner collapse navbar-collapse justify-content-center" id="main_menu_dropdown">
                            <ul class="main_menu_list unordered_list_center">

                                <li class="<?= ($current_page == 'index') ? 'active' : ''; ?>">
                                    <a class="nav-link" href="index" id="home_submenu" role="button" aria-expanded="false">Home</a>
                                </li>

                                <li class="dropdown <?= ($current_page == 'category' || $current_page == 'shop_product_sub_category') ? 'active' : ''; ?>">
                                    <a class="nav-link" href="#" id="pages_submenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                                    <ul class="dropdown-menu" aria-labelledby="pages_submenu">
                                        <?php while ($post = mysqli_fetch_assoc($result_head2)) : ?>
                                            <li class="dropdown">
                                                <a class="nav-link" href="#!" id="about_submenu" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $post['p_cat_title'] ?></a>
                                                <ul class="dropdown-menu" aria-labelledby="about_submenu">
                                                    <?php
                                                    $p_sub_cat_head = $post['p_cat_id'];
                                                    $query_head3 = "SELECT * FROM categories WHERE cat_top = 'yes' AND p_cat_id = $p_sub_cat_head";
                                                    $result_head3 = mysqli_query($con, $query_head3);
                                                    while ($post2 = mysqli_fetch_assoc($result_head3)) : ?>
                                                        <li>
                                                            <a href="shop_product_sub_category?id=<?= $post2['cat_id'] ?>" class="<?= ($current_page == 'shop_product_sub_category' && isset($_GET['id']) && $_GET['id'] == $post2['cat_id']) ? 'active' : ''; ?>">
                                                                <?= $post2['cat_title'] ?>
                                                            </a>
                                                        </li>
                                                    <?php endwhile; ?>
                                                </ul>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </li>

                                <li class="dropdown <?= ($current_page == 'shop_brands') ? 'active' : ''; ?>">
                                    <a class="nav-link" href="#" id="home_submenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">Brand</a>
                                    <ul class="dropdown-menu" aria-labelledby="home_submenu" style="columns: 2; padding: 10px; width: 400px;">
                                        <?php while ($post = mysqli_fetch_assoc($result_head1)) : ?>
                                            <li>
                                                <a href="shop_brands?id=<?= $post['manufacturer_id'] ?>" class="<?= ($current_page == 'shop_brands' && isset($_GET['id']) && $_GET['id'] == $post['manufacturer_id']) ? 'active' : ''; ?>">
                                                    <?= $post['manufacturer_title'] ?>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </li>

                                <li class="<?= ($current_page == 'shop') ? 'active' : ''; ?>">
                                    <a class="nav-link" href="shop">Shop</a>
                                </li>

                                <li class="<?= ($current_page == 'blog') ? 'active' : ''; ?>">
                                    <a class="nav-link" href="blog">Blog</a>
                                </li>

                                <li class="dropdown <?= ($current_page == 'contact' || $current_page == 'faq') ? 'active' : ''; ?>">
                                    <a class="nav-link" href="#" id="service_submenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contact</a>
                                    <ul class="dropdown-menu" aria-labelledby="service_submenu">
                                        <li><a href="contact" class="<?= ($current_page == 'contact') ? 'active' : ''; ?>">Contact us</a></li>
                                        <li><a href="#!" class="<?= ($current_page == 'faq') ? 'active' : ''; ?>">F.A.Q</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </nav>


                </div>
                <div class="col-lg col">
                    <ul class="header_btns_group unordered_list_end">
                        <li>
                            <button
                                class="mobile_menu_btn"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#main_menu_dropdown"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                        </li>
                        <!-- <li>
                    <div
                      class="mode-switch nob"
                      data-bs-toggle="mode"
                      data-cursor="-opaque"
                      data-magnetic
                    >
                      <input id="theme-mode-btn" type="checkbox" />
                    </div>
                  </li> -->
                        <li>
                            <a class="btn_hotline" href=""><span class="btn_text" data-text="">+ 91 96691-96692</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="search-popup" id="search-popup">
    <div class="search-box">
        <button class="close-btn" id="close-search"><i class="fas fa-times"></i></button>
        <input type="text" id="search-input" placeholder="Search for products..." autocomplete="off">

        <!-- Search Results Section -->
        <div class="search-results">
            <!-- Left side details -->
            <div class="details-section" id="details-section">
                <h3>Product Details</h3>
                <!-- <img src="" alt="Product Image" id="details-image" /> -->
                <p id="details-description">Hover over a product to see details here</p>
                <!-- <p><strong>Price:</strong> <span id="details-price"></span></p> -->
                <!-- <button class="add-to-cart" id="add-to-cart-btn">Add to cart</button> -->
            </div>

            <!-- Right side products list -->
            <div class="products-section" id="products-section">
                <div class="categories">Categories</div>
                <div id="categories">Helmet</div>

                <div class="categories">Products</div>
                <!-- List of products matching the search query will appear here -->
            </div>
        </div>
    </div>
</div>

<script>
    const openSearchBtn = document.getElementById('open-search');
    const closeSearchBtn = document.getElementById('close-search');
    const searchPopup = document.getElementById('search-popup');
    const productsSection = document.getElementById('products-section');
    const detailsSection = document.getElementById('details-section');
    const detailsImage = document.getElementById('details-image');
    const detailsDescription = document.getElementById('details-description');
    const detailsPrice = document.getElementById('details-price');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    // Show search popup
    openSearchBtn.addEventListener('click', () => {
        searchPopup.classList.add('active');
    });

    // Close search popup
    closeSearchBtn.addEventListener('click', () => {
        searchPopup.classList.remove('active');
        clearResults();
    });

    // Dummy product data (replace with AJAX fetch later)
    // const products = [{
    //         name: "Aster Helmet",
    //         price: "₹1,000",
    //         image: "helmet1.png",
    //         description: "High quality Aster Helmet for ultimate safety."
    //     },
    //     {
    //         name: "Bolt Dice Helmet",
    //         price: "₹600",
    //         image: "helmet2.png",
    //         description: "Bolt Dice Helmet offering style and protection."
    //     },
    //     {
    //         name: "Apex Streak Helmet 2",
    //         price: "₹600",
    //         image: "helmet3.png",
    //         description: "Apex Streak Helmet 2 for modern racers."
    //     }
    // ];

    function renderProducts(products) {
        if (products.length == 0) {
            productsSection.innerHTML =
                `
        <div>
            <span>No Product</span>
        </div>
    `
        }
        // console.log(products.length);
        productsSection.innerHTML += products.map(product => `
        <div style="margin-bottom: 6px;" class="product-item" data-product-id="${product.product_id}" data-name="${product.product_title}" data-description="${product.product_desc}" data-image="${product.image}" data-price="${product.product_psp_price}" data-category="${product.product_keywords}">
            <span style="display:flex; align-items: center;"><img src="admin_area/product_images/${product.image}" alt="${product.name}"><div> ${product.product_title} </div></span>
            <span>₹${product.product_psp_price}</span>
        </div>
    `).join('');
    }


    function handleHover() {
        const productItems = document.querySelectorAll('.product-item');
        productItems.forEach(item => {
            item.addEventListener('mouseenter', (e) => {
                const name = e.currentTarget.getAttribute('data-name');
                const description = e.currentTarget.getAttribute('data-description');
                const image = e.currentTarget.getAttribute('data-image');
                const price = e.currentTarget.getAttribute('data-price');
                const category = e.currentTarget.getAttribute('data-category');
                const product_id = e.currentTarget.getAttribute('data-product-id')

                detailsSection.innerHTML = `
                    <img style="width: 250px; height:250px;" src="admin_area/product_images/${image}" alt="Product Image" id="details-image" />
                    <h4>${name}</h4>
                    <p><strong>Price:</strong> <span id="details-price">₹${price}</span></p>
                    <button class="add-to-cart" id="add-to-cart-btn"><a href="shop_details?id=${product_id}">Shop Now</a></button> `;

                // detailsImage.src = `images/${image}`;
                // detailsDescription.textContent = description;
                // detailsPrice.textContent = `₹${price}`;
            });
        });
    }

    function clearResults() {
        productsSection.style.display = 'none'; // Hide products section
        detailsSection.style.display = 'none'; // Hide details section
        productsSection.innerHTML = ''; // Clear results
        detailsSection.innerHTML = `<h3>Product Details</h3>
                    <p id="details-description">Hover over a product to see details here</p>`;
    }

    function showResults() {
        productsSection.style.display = 'block'; // Hide products section
        detailsSection.style.display = 'block'; // Hide details section
    }


    const searchInput = document.getElementById('search-input');
    // console.log(searchInput);
    // Listen for input changes to fetch search results
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();
        console.log(query)

        if (query.length == 0) {
            clearResults()
        }

        if (query.length > 2) { // Fetch when query is more than 2 characters
            fetch(`./search?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    // Clear previous products
                    productsSection.innerHTML = '';

                    // Render new products from search results
                    showResults()
                    renderProducts(data);
                    handleHover();
                })
                .catch(error => console.error('Error fetching products:', error));
        }
    });
</script>