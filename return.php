<?php
// ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<!-- Mirrored from html.merku.love/promotors/contact by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:17 GMT -->

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Return and Exchange</title>
    <?php
    include 'includes/head-links.php';
    ?>
    <style>
        /* .connn {
        background-color: #fff;
        color: #000;
        border: 1px solid black;
      } */
        .contact-section {
            margin-top: 100px;
            padding: 50px 0;
            background-color: white;
            color: #000;


        }

        .contact-form {
            /* border: 1px solid black; */
            box-shadow: 0px 10px 10px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
        }

        .contact-form input,
        .contact-form textarea {
            background-color: #fff;
            color: black;
            outline: none;
            border-bottom: 1px solid #000;
        }

        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #888;
        }

        .contact-form button {
            background-color: #f4b400;
            border: none;
            color: #000;
        }

        .contact-form button:hover {
            background-color: #e0a800;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #f4b400;
        }

        @media (max-width: 576px) {
            .contact-section {
                padding: 20px 0;
            }

            .contact-form {
                padding: 20px;
            }
        }

        /* Hide the default radio button */
        .custom-radio {
            display: none;
        }

        /* Style the custom labels */
        .custom-label {
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        /* Highlight selected option */
        .custom-radio:checked+.custom-label {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        /* Hover effect */
        .custom-label:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <?php
    include 'includes/top-bar.php';
    ?>
    <div class="page_wrapper">

        <?php
        include 'includes/header.php';
        ?>

        <main class="page_content" style="margin-top: 140px;">
            <section
                class="page_banner"
                style="background-image: url('assets/images/shapes/tyre_print_3.svg')">
                <div class="container">
                    <ul class="breadcrumb_nav unordered_list">
                        <li><a href="index">Home</a></li>
                        <li><a href="contact">Contacts</a></li>
                    </ul>
                    <h1 class="page_title wow" data-splitting>Contacts</h1>
                </div>
            </section>
            <section class="contact-section">
                <div class="container">
                    <h2 class="text-center mb-5">Contact Us</h2>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <form class="contact-form" onsubmit="submitContactForm(event)">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" maxlength="10" pattern="\d{10}" required>
                                </div>
                                <h6>Select Subject</h6>
                                <div class="mb-3">
                                    <input type="radio" name="option" id="return" class="custom-radio">
                                    <label for="return" class="form-label custom-label">Return/Refund</label>

                                    <input type="radio" name="option" id="query" class="custom-radio">
                                    <label for="query" class="form-label custom-label">Query</label>

                                    <input type="radio" name="option" id="complaint" class="custom-radio">
                                    <label for="complaint" class="form-label custom-label">Complaint</label>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Your Message</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Write your message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">Send Message</button>
                                <!-- <div id="contact_message" class="mt-3"></div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section class="contact_section section_space_lg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="contact_info_box">
                                <h3 class="item_title">Address</h3>
                                <ul class="info_list unordered_list_block pe-lg-2">
                                    <li>
                                        <span class="info_text mb-3" style="font-size: 14px;">10, Gulmarg Complex, Sapna Sangeeta Main Road. Indore 452001. M.P.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact_info_box">
                                <h3 class="item_title">Office Hours</h3>
                                <ul class="info_list unordered_list_block">
                                    <li>
                                        <span
                                            class="info_text d-flex align-items-center justify-content-between" style="font-size: 14px;"><span>Monday - Saturday</span>
                                            <span>10:30 am - 8:30 pm</span></span>
                                    </li>
                                    <li>
                                        <span
                                            class="info_text d-flex align-items-center justify-content-between" style="font-size: 14px;"><span>Sunday</span> <span>9:00 am - 5:00 pm</span></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact_info_box">
                                <h3 class="item_title">Customer Support</h3>
                                <ul class="info_list unordered_list_block">
                                    <li>
                                        <span class="info_text mb-3" style="font-size: 14px;"><span class="d-block"><a href="tel:919669196692">+91 9669196692</a> </span></span>
                                    </li>
                                    <li>
                                        <span class="info_text" style="font-size: 14px;"><span class="d-block"><a href="mailto:motodresser@gmail.com">motodresser@gmail.com</a> </span></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="gmap_canvas">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2909.152616992916!2d75.86506117530419!3d22.699492879401596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fdb5f36246d9%3A0x3955405e3a3bc26a!2sMotodresser!5e1!3m2!1sen!2sin!4v1729561042470!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
            </section>
        </main>
        <?php
        include 'includes/footer.php';
        ?>
    </div>
    <?php
    include 'includes/script-links.php';
    ?>

    <script>
        function submitContactForm(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const message = document.getElementById('message').value;

            // Simple validation for empty fields
            if (!name || !email || !phone || !message) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please fill in all fields.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Show the processing alert
            Swal.fire({
                title: 'Sending...',
                text: 'Please wait while we send your message.',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX request to send the contact form data
            $.ajax({
                url: '#', // Adjust the URL if necessary
                type: 'POST',
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    message: message
                },
                success: function(response) {
                    const res = JSON.parse(response);

                    if (res.success) {
                        Swal.fire({
                            title: 'Message Sent!',
                            text: 'Thank you for contacting us. We will get back to you soon!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            document.querySelector('.contact-form').reset(); // Reset the form after success
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while sending your message. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>

</body>
<!-- Mirrored from html.merku.love/promotors/contact by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Sep 2024 07:17:17 GMT -->

</html>