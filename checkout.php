<?php 
 session_start();
require_once 'enterKonn.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();



foreach($_SESSION['user'] as $item){
    
    $user_id = $item['id'];
}

$get_user_info = $conn->prepare("SELECT * FROM registration where id = ?");
$get_user_info->execute([$user_id]);
if($get_user_info->rowCount()>0){
    
    $row = $get_user_info->fetch();
    $fullname = $row['fullname'];
    $address = $row['address'];
    $phone = $row['phone'];
    $email = $row['email'];
   
}


if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    

if(!empty($_SESSION["cart"])){
	$count = count($_SESSION["cart"]);
} else {
	$count = 0;
}

$subTotal_sum = array_sum( str_replace(",", "", $_SESSION['price']));


  foreach ($_SESSION['cart'] as $item) {
    $subTotal_sum += str_replace(",", "", $item['price']);
    $product_id = $item['id'];
}

                         

if(isset($_GET['delete_id'])){
    
    $delete_id = $_GET['delete_id'];
 
  foreach ($_SESSION['cart'] as $key => $value) {
  if($value['id'] == $delete_id) {
    unset($_SESSION['cart'][$key]);
    echo '<script>location.reload();</script>';
    break;
  }
}

}


    if(!empty($_SESSION["cart"])||!empty($_SESSION["user"])){

        
?>


<html lang="en">


<!-- molla/checkout.html  22 Nov 2019 09:55:06 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mike&Cathy - Nigeria Online Store</title>
    <meta name="keywords" content="Nigeria Online Store">
    <meta name="description" content="Nigeria Online Store">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skins/skin-demo-5.css">
    <link rel="stylesheet" href="assets/css/demos/demo-5.css">
    <style>
.alert {
  padding: 10px;
  background-color: green;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



    
<script type="text/javascript">

function clickButton(){
    var title=document.getElementById('title').value;
    var price=document.getElementById('price').value;
    var img_src=document.getElementById('img_src').value;
    
    
      $("#add_to_cart").attr("disabled", true);
      
    $.ajax({
        type:"post",
        url:"my_add_cart.php",
        data: 
        {  
           'title' :title,
           'price' :price,
           'img_src' :img_src
        },
        cache:false,
        
         beforeSend: function(){
     $("#loading").show();
   },
   
   complete: function(){
     $("#loading").hide();
   },
   
 success: function (data) 
        {
          alert(data['title']);
          //enable loading 
             $("#add_to_cart").attr("disabled", false);
          
           $('#msg').html(data['message']);
           $('#count').html(data['count']);        
        }
        
    });
    return false;
 }
</script>

											
											<script>
											
        function clickMe(id) {
            
          // each row product price by it array/loop of ID
          var price = document.getElementById(id+"_price").innerHTML;
          
          // each row product total price by it array/loop of ID
           var totalPrice = document.getElementById(id+"_totalPrice").innerHTML.replace(/[^a-zA-Z0-9]/g, '');
           
           // get the single ID of subTotal
           var subTotal = document.getElementById("subTotal").innerHTML.replace(/[^a-zA-Z0-9]/g, '');
           
           //Subtracting the current subTotal from totalPrice of the + or - button clicked
           var initialSubtotal = parseInt(subTotal) - parseInt(totalPrice);
           
          // strip price of special characters
          let finalPrice =  price.replace(/[^a-zA-Z0-9]/g, '');
          
          // each row product Quantity Count by it array/loop of ID 
          var quantity = document.getElementById(id+"_quantityCount").value;
          
          // multiplying the quantity count with price of product
          var totalPrice = quantity * finalPrice;
          
          // parsing the value to display on total price
          document.getElementById(id+"_totalPrice").innerHTML = "\u20A6"+totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          
          //adding new total price to the remainder of the subtracted + or - button click 
         var subTotal= parseInt(initialSubtotal)+parseInt(totalPrice);
         
         // parsing the value to display on sub total
          document.getElementById("subTotal").innerHTML ="\u20A6"+subTotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          
          
          var finalTotalPrice = parseInt(subTotal) + 0;
           // parsing the value to display on sub total
          document.getElementById("finalTotalPrice").innerHTML ="\u20A6"+finalTotalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         
          
        }
    </script>

</head>
<body>
    <div class="page-wrapper">
        <header class="header header-5" style="color:black;background-color:black;">
            <div class="header-middle sticky-header">
                <div class="container-fluid">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="index.php" class="logo">
                            <img src="assets/images/demos/demo-5/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li>
                                    <a href="index.php" >Home</a>

                                </li>
                                 
                                                 <li>
                                    <a href="#" class="sf-with-ul">Product</a>

                                    <ul>
                                        <li><a href="product_list.php?type_product=clothing">Clothing</a></li>
                                        <li><a href="product_list.php?type_product=skincare">Skincare</a></li>
                                       
                                    </ul>
                                </li>
                                
                                
                                <li>
                                    <a href="about_us.php">About Us</a>

                                </li>
                                
                                <li>
                                    <a href="contact_us.php">Contact Us</a>

                                </li>
                
                        <li>
                                    <a href="privacy_policy.php">Privacy Policy</a>

                                </li>
                
                        </ul><!-- End .menu -->
                        

                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->
                   
                    <div class="header-right">
                        <div class="header-search header-search-extended header-search-visible">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                        
                      
                        
                                   <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-user"></i>
                          </a>




                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    <?php if(!$_SESSION['user']){ ?><div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="login.php?tab=signin&prev_url=<?php echo $url; ?>">Login</a>
                                            </h4>

                                        </div><!-- End .product-cart-details -->
                                        
                                      
                                    </div><!-- End .product -->
                                      <?php } ?>
                                      
                                      
                                      <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="cart.php">View Cart</a>
                                            </h4>

                                        </div><!-- End .product-cart-details -->

                                      
                                      
                                    </div><!-- End .product -->
                                    
                                                     
                                   <?php if($_SESSION['user']){ ?>    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                              
                                              
                                              <a href="history.php">Purchase History</a>
                                          
                                         
                                            </h4>

                                        </div><!-- End .product-cart-details -->
                               
                                      
                                      
                                    </div><!-- End .product -->
   <?php } ?>
   
                                    
                                   <?php if($_SESSION['user']){ ?>    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                              
                                              
                                              <a href="logout.php">Logout</a>
                                          
                                         
                                            </h4>

                                        </div><!-- End .product-cart-details -->
                               
                                      
                                      
                                    </div><!-- End .product -->
   <?php } ?>
   
                                 </div><!-- End .cart-product -->

                               
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
            
            
            

                       <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" >
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count" id="count"><? echo $count; ?></span>
                            </a>

                         </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                    
                </div><!-- End .container-fluid -->
                <p id="msg"></p>
       
            </div><!-- End .header-middle -->
        </header><!-- End .header -->
 <br><br><br>
         <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Checkout<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
            
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
            			<div class="checkout-discount">
            				<form action="#">
        						<input type="text" class="form-control" required id="checkout-discount-input">
            					<label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
            				</form>
            			</div><!-- End .checkout-discount -->
            			<form action="#" id="checkout_form" name="checkout_form">
		                	<div class="row">
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
		                			

	            						<label>Full Name </label>
	            						<input type="text" value="<?php echo $fullname; ?>" id="fullname" name="fullname" class="form-control" disabled>
	            						<p id = "displayFullnameError" style="color: red"></p>
	            						
	            						
	            						<input type="hidden" value="<?php echo $email; ?>" id="email" name="email" class="form-control">
	            						
	            						<input type="hidden" value="<?php echo $subTotal_sum+2500; ?>" id="amount" name="amount" class="form-control">
	            						
	            						<input type="hidden" value="<?php echo $product_id; ?>" id="product_id" name="product_id" class="form-control">
	            						
          
	            						
	            						<label>Street address *</label>
	            						<input type="text" id="address" name="address" class="form-control" placeholder="House number and Street name" value="<?php 
	            						if($address!=""){
	            						 echo $address;
	            						 } ?>" required>
	            					         <p id = "displayAddressError" style="color: red"></p>
          
	            			
		                	
	                					<label>Phone Number *</label>
	        							<input type="phone" id="phone" name="phone" value="<?php 
	            						if($phone!=""){
	            						 echo $phone;
	            						 } 
	            						 ?>" placeholder="Your reachable phone number" class="form-control" required>
     <p id = "displayPhoneError" style="color: red"></p>
          
	        					
		                		</div><!-- End .col-lg-9 -->
		                		<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                			
		                					<tbody>
		                						<tr class="summary-total">
		                							<td>Total:</td>
		                							<td>&#8358;<?php 
	                							
	                							$subTotal_sum_final = $subTotal_sum + 2500;
	                							echo number_format($subTotal_sum_final); ?></td>
		                						</tr><!-- End .summary-total -->
		                					</tbody>
		                				</table><!-- End .table table-summary -->

		                				<div class="accordion-summary" id="accordion-payment">
										    <div class="card">
										        <div class="card-header" id="heading-1">
										            <h2 class="card-title">
										                				<div class="custom-control custom-radio">
														<input type="radio" id="free-shipping" name="shipping" class="custom-control-input" checked>
														<label class="custom-control-label" for="free-shipping">Card Payment</label>
													</div><!-- End .custom-control -->
										             <img src="assets/images/payments-summary.png" alt="payments cards">
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment">
										            <!--div class="card-body">
										                Please use a valid phone number and address as our online agent will reach you through this number for delivery. Your order will be shipped to the address provided.
										            </div--><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										</div><!-- End .accordion -->
										
										
<script type="text/javascript">

function clickOrder(){
    
    document.getElementById("displayAddressError").innerHTML = "";

      if( document.checkout_form.address.value == "")
         {
          document.getElementById("displayAddressError").innerHTML = 'Street address is required';
        document.checkout_form.address.focus() ;
        return false;
         }
         
         document.getElementById("displayFullnameError").innerHTML = "";

         
         if( document.checkout_form.fullname.value == "")
         {
          document.getElementById("displayFullnameError").innerHTML = 'Full name is required';
        document.checkout_form.fullname.focus() ;
        return false;
         } 
         
             document.getElementById("displayPhoneError").innerHTML = "";

         if( document.checkout_form.phone.value == "")
         {
          document.getElementById("displayPhoneError").innerHTML = 'Phone number is required';
        document.checkout_form.phone.focus() ;
        return false;
         } 
         
         var amount = document.checkout_form.amount.value;
         var email = document.checkout_form.email.value;
         var product_id = document.checkout_form.product_id.value;
         var phone = document.checkout_form.phone.value;
         var address = document.checkout_form.address.value;
   
var form_data = new FormData();

$.ajax({ 
url: 'check_session.php', // point to server-side PHP script 
dataType: 'text', 
cache: false, 
contentType: false,
processData: false, 
data: form_data, 
type: 'post', 
success: function(the_result){ 
   if(the_result == "false"){
      window.location.replace('cart.php');

    }else{
       //ok
        window.location.replace(`initialize.php?email=${email}&amount=${amount}&id=${product_id}&phone=${phone}&address=${address}`);
    } 
} });    


}

</script>

		                				<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block" onclick="return clickOrder();">
		                					Place Order
		                				</button>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                	</div><!-- End .row -->
            			</form>
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

    <?php include("footer.php"); ?>
 </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active">
                        <a href="index.html">Home</a>

                        <ul>
                            <li><a href="index-1.html">01 - furniture store</a></li>
                            <li><a href="index-2.html">02 - furniture store</a></li>
                            <li><a href="index-3.html">03 - electronic store</a></li>
                            <li><a href="index-4.html">04 - electronic store</a></li>
                            <li><a href="index-5.html">05 - fashion store</a></li>
                            <li><a href="index-6.html">06 - fashion store</a></li>
                            <li><a href="index-7.html">07 - fashion store</a></li>
                            <li><a href="index-8.html">08 - fashion store</a></li>
                            <li><a href="index-9.html">09 - fashion store</a></li>
                            <li><a href="index-10.html">10 - shoes store</a></li>
                            <li><a href="index-11.html">11 - furniture simple store</a></li>
                            <li><a href="index-12.html">12 - fashion simple store</a></li>
                            <li><a href="index-13.html">13 - market</a></li>
                            <li><a href="index-14.html">14 - market fullwidth</a></li>
                            <li><a href="index-15.html">15 - lookbook 1</a></li>
                            <li><a href="index-16.html">16 - lookbook 2</a></li>
                            <li><a href="index-17.html">17 - fashion store</a></li>
                            <li><a href="index-18.html">18 - fashion store (with sidebar)</a></li>
                            <li><a href="index-19.html">19 - games store</a></li>
                            <li><a href="index-20.html">20 - book store</a></li>
                            <li><a href="index-21.html">21 - sport store</a></li>
                            <li><a href="index-22.html">22 - tools store</a></li>
                            <li><a href="index-23.html">23 - fashion left navigation store</a></li>
                            <li><a href="index-24.html">24 - extreme sport store</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="category.html">Shop</a>
                        <ul>
                            <li><a href="category-list.html">Shop List</a></li>
                            <li><a href="category-2cols.html">Shop Grid 2 Columns</a></li>
                            <li><a href="category.html">Shop Grid 3 Columns</a></li>
                            <li><a href="category-4cols.html">Shop Grid 4 Columns</a></li>
                            <li><a href="category-boxed.html"><span>Shop Boxed No Sidebar<span class="tip tip-hot">Hot</span></span></a></li>
                            <li><a href="category-fullwidth.html">Shop Fullwidth No Sidebar</a></li>
                            <li><a href="product-category-boxed.html">Product Category Boxed</a></li>
                            <li><a href="product-category-fullwidth.html"><span>Product Category Fullwidth<span class="tip tip-new">New</span></span></a></li>
                            <li><a href="cart.html">Cart</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                            <li><a href="wishlist.html">Wishlist</a></li>
                            <li><a href="#">Lookbook</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="product.html" class="sf-with-ul">Product</a>
                        <ul>
                            <li><a href="product.html">Default</a></li>
                            <li><a href="product-centered.html">Centered</a></li>
                            <li><a href="product-extended.html"><span>Extended Info<span class="tip tip-new">New</span></span></a></li>
                            <li><a href="product-gallery.html">Gallery</a></li>
                            <li><a href="product-sticky.html">Sticky Info</a></li>
                            <li><a href="product-sidebar.html">Boxed With Sidebar</a></li>
                            <li><a href="product-fullwidth.html">Full Width</a></li>
                            <li><a href="product-masonry.html">Masonry Sticky Info</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Pages</a>
                        <ul>
                            <li>
                                <a href="about.html">About</a>

                                <ul>
                                    <li><a href="about.html">About 01</a></li>
                                    <li><a href="about-2.html">About 02</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="contact.html">Contact</a>

                                <ul>
                                    <li><a href="contact.html">Contact 01</a></li>
                                    <li><a href="contact-2.html">Contact 02</a></li>
                                </ul>
                            </li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="faq.html">FAQs</a></li>
                            <li><a href="404.html">Error 404</a></li>
                            <li><a href="coming-soon.html">Coming Soon</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="blog.html">Blog</a>

                        <ul>
                            <li><a href="blog.html">Classic</a></li>
                            <li><a href="blog-listing.html">Listing</a></li>
                            <li>
                                <a href="#">Grid</a>
                                <ul>
                                    <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                    <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                    <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                    <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Masonry</a>
                                <ul>
                                    <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                    <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                    <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                    <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Mask</a>
                                <ul>
                                    <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                    <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Single Post</a>
                                <ul>
                                    <li><a href="single.html">Default with sidebar</a></li>
                                    <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                    <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="elements-list.html">Elements</a>
                        <ul>
                            <li><a href="elements-products.html">Products</a></li>
                            <li><a href="elements-typography.html">Typography</a></li>
                            <li><a href="elements-titles.html">Titles</a></li>
                            <li><a href="elements-banners.html">Banners</a></li>
                            <li><a href="elements-product-category.html">Product Category</a></li>
                            <li><a href="elements-video-banners.html">Video Banners</a></li>
                            <li><a href="elements-buttons.html">Buttons</a></li>
                            <li><a href="elements-accordions.html">Accordions</a></li>
                            <li><a href="elements-tabs.html">Tabs</a></li>
                            <li><a href="elements-testimonials.html">Testimonials</a></li>
                            <li><a href="elements-blog-posts.html">Blog Posts</a></li>
                            <li><a href="elements-portfolio.html">Portfolio</a></li>
                            <li><a href="elements-cta.html">Call to Action</a></li>
                            <li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="singin-email">Username or email address *</label>
                                            <input type="text" class="form-control" id="singin-email" name="singin-email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password" name="singin-password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="register-email">Your email address *</label>
                                            <input type="email" class="form-control" id="register-email" name="register-email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Password *</label>
                                            <input type="password" class="form-control" id="register-password" name="register-password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">or sign in with</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Login With Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login  btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Login With Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>


<!-- molla/checkout.html  22 Nov 2019 09:55:06 GMT -->
</html>


<?
        
        
    }else{
        
        echo header("Location:cart.php");
        
    }



?>