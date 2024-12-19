<?php


if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login','_self')</script>";
} else {




?>

    <nav class="navbar navbar-inverse navbar-fixed-top"><!-- navbar navbar-inverse navbar-fixed-top Starts -->

        <div class="navbar-header"><!-- navbar-header Starts -->

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><!-- navbar-ex1-collapse Starts -->


                <span class="sr-only">Toggle Navigation</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>


            </button><!-- navbar-ex1-collapse Ends -->

            <a class="navbar-brand" href="index?dashboard">Admin Panel</a>


        </div><!-- navbar-header Ends -->

        <ul class="nav navbar-right top-nav"><!-- nav navbar-right top-nav Starts -->

            <li class="dropdown"><!-- dropdown Starts -->

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><!-- dropdown-toggle Starts -->

                    <i class="fa fa-user"></i>

                    <?php echo $admin_name; ?> <b class="caret"></b>


                </a><!-- dropdown-toggle Ends -->

                <ul class="dropdown-menu"><!-- dropdown-menu Starts -->

                    <li><!-- li Starts -->

                        <a href="index?user_profile=<?php echo $admin_id; ?>">

                            <i class="fa fa-fw fa-user"></i> Profile


                        </a>

                    </li><!-- li Ends -->

                    <li><!-- li Starts -->

                        <a href="index?view_products">

                            <i class="fa fa-fw fa-envelope"></i> Products

                            <span class="badge"><?php echo $count_products; ?></span>


                        </a>

                    </li><!-- li Ends -->

                    <li><!-- li Starts -->

                        <a href="index?view_customers">

                            <i class="fa fa-fw fa-gear"></i> Customers

                            <span class="badge"><?php echo $count_customers; ?></span>


                        </a>

                    </li><!-- li Ends -->

                    <li><!-- li Starts -->

                        <a href="index?view_p_cats">

                            <i class="fa fa-fw fa-gear"></i> Product Categories

                            <span class="badge"><?php echo $count_p_categories; ?></span>


                        </a>

                    </li><!-- li Ends -->

                    <li class="divider"></li>

                    <li><!-- li Starts -->

                        <a href="logout">

                            <i class="fa fa-fw fa-power-off"> </i> Log Out

                        </a>

                    </li><!-- li Ends -->

                </ul><!-- dropdown-menu Ends -->




            </li><!-- dropdown Ends -->


        </ul><!-- nav navbar-right top-nav Ends -->

        <div class="collapse navbar-collapse navbar-ex1-collapse"><!-- collapse navbar-collapse navbar-ex1-collapse Starts -->

            <ul class="nav navbar-nav side-nav"><!-- nav navbar-nav side-nav Starts -->

                <li><!-- li Starts -->

                    <a href="index?dashboard">

                        <i class="fa fa-fw fa-dashboard"></i> Dashboard

                    </a>

                </li><!-- li Ends -->

                <li><!-- Products li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#products">

                        <i class="fa fa-fw fa-table"></i> Products

                        <i class="fa fa-fw fa-caret-down"></i>


                    </a>

                    <ul id="products" class="collapse">

                        <li>
                            <a href="index?insert_product"> Insert Products </a>
                        </li>

                        <li>
                            <a href="index?view_products"> View Products </a>
                        </li>


                    </ul>

                </li><!-- Products li Ends -->

                <li><!-- manufacturer li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#manufacturers"><!-- anchor Starts -->

                        <i class="fa fa-fw fa-briefcase"></i> Brands

                        <i class="fa fa-fw fa-caret-down"></i>


                    </a><!-- anchor Ends -->

                    <ul id="manufacturers" class="collapse"><!-- ul collapse Starts -->

                        <li>
                            <a href="index?insert_manufacturer"> Insert Brand </a>
                        </li>

                        <li>
                            <a href="index?view_manufacturers"> View Brands </a>
                        </li>

                    </ul><!-- ul collapse Ends -->


                </li><!-- manufacturer li Ends -->


                <li><!-- li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#p_cat">

                        <i class="fa fa-fw fa-pencil"></i> Products Categories

                        <i class="fa fa-fw fa-caret-down"></i>


                    </a>

                    <ul id="p_cat" class="collapse">

                        <li>
                            <a href="index?insert_p_cat"> Insert Product Category </a>
                        </li>

                        <li>
                            <a href="index?view_p_cats"> View Products Categories </a>
                        </li>


                    </ul>

                </li><!-- li Ends -->


                <li><!-- li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#cat">

                        <i class="fa fa-fw fa-arrows-v"></i> Product Sub-Categories

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <ul id="cat" class="collapse">

                        <li>
                            <a href="index?insert_cat"> Insert Product Sub-Categories </a>
                        </li>

                        <li>
                            <a href="index?view_cats"> View Product Sub-Categories </a>
                        </li>


                    </ul>

                </li><!-- li Ends -->

                <li><!-- manufacturer li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#blog_category"><!-- anchor Starts -->

                        <i class="fa fa-fw fa-briefcase"></i> Blog Category

                        <i class="fa fa-fw fa-caret-down"></i>


                    </a><!-- anchor Ends -->

                    <ul id="blog_category" class="collapse"><!-- ul collapse Starts -->

                        <li>
                            <a href="index?insert_blog_category"> Insert Blog Category </a>
                        </li>

                        <li>
                            <a href="index?view_blog_category"> View Blog Category </a>
                        </li>

                    </ul><!-- ul collapse Ends -->


                </li><!-- manufacturer li Ends -->

                <li><!-- Coupons Section li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#coupons"><!-- anchor Starts -->

                        <i class="fa fa-fw fa-arrows-v"></i> Coupons

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a><!-- anchor Ends -->

                    <ul id="coupons" class="collapse"><!-- ul collapse Starts -->

                        <li>
                            <a href="index?insert_coupon"> Insert Coupon </a>
                        </li>

                        <li>
                            <a href="index?view_coupons"> View Coupons </a>
                        </li>

                    </ul><!-- ul collapse Ends -->

                </li><!-- Coupons Section li Ends -->



                <li><!-- terms li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#terms"><!-- anchor Starts -->

                        <i class="fa fa-fw fa-table"></i> Terms

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a><!-- anchor Ends -->

                    <ul id="terms" class="collapse"><!-- ul collapse Starts -->

                        <li>
                            <a href="index?insert_term"> Insert Terms </a>
                        </li>

                        <li>
                            <a href="index?view_terms"> View Terms </a>
                        </li>

                    </ul><!-- ul collapse Ends -->


                </li><!-- terms li Ends -->


                <li><!-- Products li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#blogs">

                        <i class="fa fa-fw fa-table"></i> Blogs

                        <i class="fa fa-fw fa-caret-down"></i>


                    </a>

                    <ul id="blogs" class="collapse">

                        <li>
                            <a href="index?insert_blog"> Insert Blog </a>
                        </li>

                        <li>
                            <a href="index?view_blogs"> View Blogs </a>
                        </li>

                        <li>
                            <a href="index?view_blog_comments"> View Blog Comments </a>
                        </li>

                    </ul>

                </li><!-- Products li Ends -->


                <li><!-- terms li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#landing_images"><!-- anchor Starts -->

                        <i class="fa fa-fw fa-table"></i> Landing Images

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a><!-- anchor Ends -->

                    <ul id="landing_images" class="collapse"><!-- ul collapse Starts -->

                        <li>
                            <a href="index?insert_landing_image"> Insert landing image </a>
                        </li>

                        <li>
                            <a href="index?view_landing_images"> View landing images </a>
                        </li>

                    </ul><!-- ul collapse Ends -->


                </li><!-- terms li Ends -->






                <li><!-- terms li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#testimonials"><!-- anchor Starts -->

                        <i class="fa fa-fw fa-table"></i> Testimonials

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a><!-- anchor Ends -->

                    <ul id="testimonials" class="collapse"><!-- ul collapse Starts -->

                        <li>
                            <a href="index?insert_testimonial"> Insert testimonial </a>
                        </li>

                        <li>
                            <a href="index?view_testimonials"> View testimonials </a>
                        </li>

                    </ul><!-- ul collapse Ends -->


                </li><!-- terms li Ends -->




                <li>

                    <a href="index?view_customers">

                        <i class="fa fa-fw fa-edit"></i> View Customers

                    </a>

                </li>

                <li>

                    <a href="index?view_orders">

                        <i class="fa fa-fw fa-list"></i> View Orders

                    </a>

                </li>

                <li>

                    <a href="index?view_product_reviews">

                        <i class="fa fa-fw fa-arrows"></i> View Product Reviews

                    </a>

                </li>

                <li>

                    <a href="index?view_user_cart">

                        <i class="fa fa-fw fa-caret-down"></i> View User Cart

                    </a>

                </li>

                <li>

                    <a href="index?view_user_wishlist">

                        <i class="fa fa-fw fa-list"></i> View User Wishlist

                    </a>

                </li>

                <li>

                    <a href="index?view_contact_us">

                        <i class="fa fa-fw fa-list"></i> View Contact Us

                    </a>

                </li>

                <li>

                    <a href="index?view_subscription">

                        <i class="fa fa-fw fa-list"></i> View Subscription

                    </a>

                </li>

                <li>

                    <a href="index?view_payments">

                        <i class="fa fa-fw fa-pencil"></i> View Payments

                    </a>

                </li>

                <li><!-- li Starts -->

                    <a href="#" data-toggle="collapse" data-target="#users">

                        <i class="fa fa-fw fa-gear"></i> Admin Users

                        <i class="fa fa-fw fa-caret-down"></i>


                    </a>

                    <ul id="users" class="collapse">

                        <li>
                            <a href="index?insert_user"> Insert Admin User </a>
                        </li>

                        <li>
                            <a href="index?view_users"> View Admin Users </a>
                        </li>

                        <li>
                            <a href="index?user_profile=<?php echo $admin_id; ?>"> Edit Profile </a>
                        </li>

                    </ul>

                </li><!-- li Ends -->

                <li><!-- li Starts -->

                    <a href="logout">

                        <i class="fa fa-fw fa-power-off"></i> Log Out

                    </a>

                </li><!-- li Ends -->

            </ul><!-- nav navbar-nav side-nav Ends -->

        </div><!-- collapse navbar-collapse navbar-ex1-collapse Ends -->

    </nav><!-- navbar navbar-inverse navbar-fixed-top Ends -->

<?php } ?>