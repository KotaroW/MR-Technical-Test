<?php
/**************************************************
 * file         : index.php
 * written by   : KotaroW
 * date         : 11 November, 2020
 * description  :
 *      To display the demo product, please append url query ?product=classic-tee
 **************************************************/
error_reporting(0);

session_start();

// header-guard
define("MR", "MR");
// URL query key
define('QUERY_KEY', 'product');
// serialised shopping cart
define('SESSION_KEY', 'MY_CART'); // <- repeated ... rectify it later 
// size element format *** this could have been a button element ***
define('SIZE_ELEM_FORMAT', '<span data-sku="%s" data-size="%s" onclick="ShoppingCart.selectItem(this);">%s</span>');

//include necesary php files
include_once('includes/classes.php');

$my_cart = null;
// is shopping cart there?
if (!empty($_SESSION[SESSION_KEY])) {
    $my_cart = unserialize($_SESSION[SESSION_KEY]);
}


$product = null;

// get URL query
if (!empty($_GET[QUERY_KEY])) {
    $sku = htmlspecialchars($_GET[QUERY_KEY]);
    $product = new Product($sku);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>MR Frontend Developer Technical Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="author" content="KotaroW">
    <meta name="keywords" content="Moustache Republic, Technical Test">
    <meta name="description" content="This is a Technical Test for the Frontend Developer position at Moustache Republic">
    <link rel="stylesheet" type="text/css" href="./css/style.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

    <!-- We don't necessarily have to have this but -->
    <main>
        <!-- cart section -->
        <section>
            <div>
                <span id="my-cart"><span id="cart-text">My Cart</span><i id="cart-fa" class="fas fa-shopping-cart"></i> ( <span id="num-items"><?php if ($my_cart) echo $my_cart->get_num_items(); else echo '0'; ?></span> )</span>
                <div id="cart-items">
<?php
    if ($my_cart) {
        echo $my_cart->generate_html_contents();
    } else {
?>
                    <p style="text-align:center;">Cart is empty</p>
<?php
    }
?>
                </div>
            </div>
        </section>
        
        <!-- product section -->
        <section>
<?php
    if ($product->sku != null) {
?>
            <!-- for the product image -->
            <div id="product-img">
                <img src="<?php echo $product->img; ?>" alt="<?php echo $product->name; ?>">
            </div>
            <div id="product-details">
                <h3><?php echo $product->name; ?></h3>
                <span>$<?php echo $product->price; ?></span>
                <p><?php echo $product->description; ?></p>
                <span></span>
                <div id="size-selection">
                    <span>SIZE<span>*</span></span>
                    <span id="size-selected">(Please select)</span>
                    <div id="sizes">
<?php
    foreach ($product->size as $size) {
                        echo sprintf(SIZE_ELEM_FORMAT, $product->sku, $size, $size) . PHP_EOL;
    }
?>
                    </div>
                    <button disabled>Add to cart</button>
                </div>
                
            </div>
<?php
    } else {
?>
            <p style="width:100%;text-align:center;" class="err-msg">No product to display. Please access at <em style="color:#369;">(your folder)/index.php?product=classic-tee</em></p>
<?php
    }
?>
            
        </section>
    
    
    </main>
    
    <script src="js/script.js"></script>
    
</body>


</html>