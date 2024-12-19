<?php
// ob_start();
// session_start();
require './includes/db.php';

if (isset($_SESSION['user_name'])) {
    // Fetch user ID from session
    $user_id = $_SESSION['user_id'];

    // Function to get the user's IP address
    // function getUserIp()
    // {
    //     return $_SERVER['REMOTE_ADDR'];
    // }

    // $ip_add = getUserIp();
    $cart_query = "SELECT cart.*, products.product_title FROM cart 
                               JOIN products ON cart.p_id = products.product_id 
                               WHERE cart.customer_login_id = '$user_id'";
    $cart_result = $con->query($cart_query);
    $cart_items = $cart_result->num_rows;
    // echo $cart_items . ' Items';

}
?>

<style>
    .search-icon {
        font-size: 15px;
        cursor: pointer;
    }

    /* Popup Search Overlay */
    .search-popup {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.9);
        display: none;
        justify-content: center;
        align-items: flex-start;
        z-index: 1000;
        padding: 20px;
        overflow-y: auto;
    }

    .search-popup.active {
        display: flex;
    }

    /* Search Box */
    .search-box {
        position: relative;
        background-color: white;
        width: 90%;
        /* Change to 90% to better handle small screens */
        max-width: 800px;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
    }

    .search-box input {
        width: 100%;
        padding: 12px;
        font-size: 18px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: white;
        color: black;
    }

    .search-box .close-btn {
        position: absolute;
        top: 30px;
        right: 30px;
        cursor: pointer;
        font-size: 20px;
        background-color: transparent;
        border: none;
        color: #333;
    }

    /* Search Results Sections */
    .search-results {
        display: flex;
        flex-direction: column-reverse;
        /* Default to column layout on smaller screens */
        width: 100%;
        gap: 20px;
    }

    /* Product Details Section */
    .details-section {
        width: 100%;
        /* Default full width */
        padding: 10px;
        border-right: none;
        /* Remove border on smaller screens */
        display: flex;
        flex-direction: column-reverse;
        align-items: center;
    }

    .details-section img {
        width: 100%;
        max-width: 250px;
        margin-bottom: 10px;
    }

    /* Product List Section */
    .products-section {
        width: 100%;
        /* Full width on small screens */
        padding: 10px;
        display: flex;
        flex-direction: column-reverse;
        gap: 10px;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        cursor: pointer;
        background-color: #f7f7f7;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .product-item img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .product-item:hover {
        background-color: #eaeaea;
    }

    .categories {
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: uppercase;
        color: #333;
    }

    /* Scrollable products section */
    .products-section {
        max-height: 400px;
        overflow-y: auto;
    }

    #details-section {
        display: none;
    }

    #products-section {
        display: none;
    }

    .add-to-cart {
        background-color: gray;
        padding: 6px;
        border: 2px solid black;
        border-radius: 10px;
    }

    .add-to-cart:hover {
        background-color: #333;
    }

    /* Media Queries for Responsiveness */

    /* For tablets and larger mobile devices */
    @media (min-width: 600px) {
        .search-results {
            flex-direction: row;
            /* Side-by-side layout for larger screens */
        }

        .details-section {
            width: 40%;
            /* Details section occupies 40% on larger screens */
            border-right: 1px solid #ddd;
        }

        .products-section {
            width: 60%;
            /* Products section occupies 60% */
        }
    }

    /* For desktops and larger screens */
    @media (min-width: 992px) {
        .search-box {
            width: 70%;
        }
    }
</style>


<div class="top-bar">
    <span class="tb" style="font-style: italic; text-transform: uppercase;">
        <?php
        if (!isset($_SESSION['user_name'])) {
            echo "Welcome : Rider";
        } else {
            echo "Welcome : Rider " . $_SESSION['user_name'] . "";
        }
        ?>
    </span>
    <div class="top-bar-right">
        <span>
            <?php
            if (!isset($_SESSION['user_name'])) {
                echo '<a href="Signup-page">Sign Up</a>';
            } else {
                echo '<a href="./my_orders">My Account</a>';
            }
            ?>
        </span>
        <span><?php
                if (!isset($_SESSION['user_name'])) {
                    echo '<a href="Login-page">Log In</a>';
                } else {
                    echo '<a href="customer/logout">Logout</a>';
                }
                ?></span>
        <span>

            <?php
            if (isset($_SESSION['user_name'])) {
                echo '<a href="cart"><i class="fa-solid fa-cart-shopping"></i></a>';
                echo ' ' . $cart_items . ' Items';
            }
            ?>

        </span>
        <span style="margin-left: 20px;">
            <div class="search-icon" id="open-search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </span>
    </div>
</div>