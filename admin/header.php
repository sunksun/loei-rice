<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
define("ADMIN_URL", $base_url);
$str = explode('admin/',ADMIN_URL);
define("SITE_URL", $str[0]);

$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/datepicker3.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/all.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/select2.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/jquery.fancybox.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/on-off-switch.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">Ecommerce</span>
			</a>

			<nav class="navbar navbar-static-top">
				
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li>
							<a href="../" target="_blank">Visit Website</a>
						</li>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>

  		<aside class="main-sidebar">
    		<section class="sidebar">
      
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
			            <i class="fa fa-hand-o-right"></i> <span>Dashboard</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'setting-logo.php') || ($cur_page == 'setting-favicon.php') || ($cur_page == 'setting-footer.php') || ($cur_page == 'setting-contact.php') || ($cur_page == 'setting-email.php') || ($cur_page == 'setting-post.php') || ($cur_page == 'setting-home.php') || ($cur_page == 'setting-banner.php') || ($cur_page == 'setting-payment.php') || ($cur_page == 'setting-currency.php') || ($cur_page == 'setting-head-body.php') || ($cur_page == 'setting-advertisement.php') || ($cur_page == 'setting-color.php') || ($cur_page == 'setting-preloader.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Settings</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="<?php echo BASE_URL; ?>setting-logo.php"><i class="fa fa-circle-o"></i> Logo</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-favicon.php"><i class="fa fa-circle-o"></i> Favicon</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-footer.php"><i class="fa fa-circle-o"></i> Footer</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-contact.php"><i class="fa fa-circle-o"></i> Contact</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-email.php"><i class="fa fa-circle-o"></i> Email</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-post.php"><i class="fa fa-circle-o"></i> Post</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-home.php"><i class="fa fa-circle-o"></i> Home Page</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-banner.php"><i class="fa fa-circle-o"></i> Banner</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-payment.php"><i class="fa fa-circle-o"></i> Payment</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-currency.php"><i class="fa fa-circle-o"></i> Currency</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-head-body.php"><i class="fa fa-circle-o"></i> Head and Body</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-advertisement.php"><i class="fa fa-circle-o"></i> Advertisements</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-color.php"><i class="fa fa-circle-o"></i> Color</a></li>
							<li><a href="<?php echo BASE_URL; ?>setting-preloader.php"><i class="fa fa-circle-o"></i> Preloader</a></li>
						</ul>
					</li>

			        <li class="treeview <?php if( ($cur_page == 'slider.php') ) {echo 'active';} ?>">
			          <a href="slider.php">
			            <i class="fa fa-hand-o-right"></i> <span>Slider</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'service.php') ) {echo 'active';} ?>">
			          <a href="service.php">
			            <i class="fa fa-hand-o-right"></i> <span>Service</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'testimonial.php') ) {echo 'active';} ?>">
			          <a href="testimonial.php">
			            <i class="fa fa-hand-o-right"></i> <span>Testimonial</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'faq.php') ) {echo 'active';} ?>">
			          <a href="faq.php">
			            <i class="fa fa-hand-o-right"></i> <span>FAQ</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'photo.php') || ($cur_page == 'video.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Gallery</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="photo.php"><i class="fa fa-circle-o"></i> Photo Gallery</a></li>
							<li><a href="video.php"><i class="fa fa-circle-o"></i> Video Gallery</a></li>
						</ul>
					</li>

					<li class="treeview <?php if( ($cur_page == 'post.php') ||($cur_page == 'post-add.php') ||($cur_page == 'post-edit.php') || ($cur_page == 'category.php') || ($cur_page == 'category-add.php') || ($cur_page == 'category-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Blog Posts</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="category.php"><i class="fa fa-circle-o"></i> Category</a></li>
							<li><a href="post.php"><i class="fa fa-circle-o"></i> Posts</a></li>
						</ul>
					</li>

					<li class="treeview <?php if( ($cur_page == 'size.php') || ($cur_page == 'size-add.php') || ($cur_page == 'size-edit.php') || ($cur_page == 'color.php') || ($cur_page == 'color-add.php') || ($cur_page == 'color-edit.php') || ($cur_page == 'country.php') || ($cur_page == 'country-add.php') || ($cur_page == 'country-edit.php') || ($cur_page == 'shipping-cost.php') || ($cur_page == 'shipping-cost-edit.php') || ($cur_page == 'top-category.php') || ($cur_page == 'top-category-add.php') || ($cur_page == 'top-category-edit.php') || ($cur_page == 'mid-category.php') || ($cur_page == 'mid-category-add.php') || ($cur_page == 'mid-category-edit.php') || ($cur_page == 'end-category.php') || ($cur_page == 'end-category-add.php') || ($cur_page == 'end-category-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Shop Section</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="size.php"><i class="fa fa-circle-o"></i> Size</a></li>
							<li><a href="color.php"><i class="fa fa-circle-o"></i> Color</a></li>
							<li><a href="country.php"><i class="fa fa-circle-o"></i> Country</a></li>
							<li><a href="shipping-cost.php"><i class="fa fa-circle-o"></i> Shipping Cost</a></li>
							<li><a href="top-category.php"><i class="fa fa-circle-o"></i> Top Level Category</a></li>
							<li><a href="mid-category.php"><i class="fa fa-circle-o"></i> Mid Level Category</a></li>
							<li><a href="end-category.php"><i class="fa fa-circle-o"></i> End Level Category</a></li>
						</ul>
					</li>


					<li class="treeview <?php if( ($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php') ) {echo 'active';} ?>">
			          <a href="product.php">
			            <i class="fa fa-hand-o-right"></i> <span>Product</span>
			          </a>
			        </li>


			        <li class="treeview <?php if( ($cur_page == 'order.php') ) {echo 'active';} ?>">
			          <a href="order.php">
			            <i class="fa fa-hand-o-right"></i> <span>Order</span>
			          </a>
			        </li>


			        <li class="treeview <?php if( ($cur_page == 'rating.php') ) {echo 'active';} ?>">
			          <a href="rating.php">
			            <i class="fa fa-hand-o-right"></i> <span>Rating</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'language.php') ) {echo 'active';} ?>">
			          <a href="language.php">
			            <i class="fa fa-hand-o-right"></i> <span>Language Settings</span>
			          </a>
			        </li>
					
					<li class="treeview <?php if( ($cur_page == 'customer-message.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Message</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="customer-message.php"><i class="fa fa-circle-o"></i> Customer Message</a></li>
						</ul>
					</li>


					<li class="treeview <?php if( ($cur_page == 'customer.php') || ($cur_page == 'customer-add.php') || ($cur_page == 'customer-edit.php') ) {echo 'active';} ?>">
			          <a href="customer.php">
			            <i class="fa fa-hand-o-right"></i> <span>Customer</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'page.php') ) {echo 'active';} ?>">
			          <a href="page.php">
			            <i class="fa fa-hand-o-right"></i> <span>Page</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'file-add.php')||($cur_page == 'file.php')||($cur_page == 'file-edit.php') ) {echo 'active';} ?>">
			          <a href="file.php">
			            <i class="fa fa-hand-o-right"></i> <span>File Upload</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'social-media.php') ) {echo 'active';} ?>">
			          <a href="social-media.php">
			            <i class="fa fa-hand-o-right"></i> <span>Social Media</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'advertisement.php') ) {echo 'active';} ?>">
			          <a href="advertisement.php">
			            <i class="fa fa-hand-o-right"></i> <span>Advertisement</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'subscriber.php')||($cur_page == 'subscriber.php') ) {echo 'active';} ?>">
			          <a href="subscriber.php">
			            <i class="fa fa-hand-o-right"></i> <span>Subscriber</span>
			          </a>
			        </li>			        

			        


      			</ul>
    		</section>
  		</aside>

  		<div class="content-wrapper">