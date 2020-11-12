<?php
/**************************************************
 * file         : index.php
 * written by   : KotaroW
 * date         : 11 November, 2020
 * description  :
 *      To display the demo product, please append url query ?product=classic-tee
 **************************************************/
define ('POST_KEY', 'data');

// Simplified safety measure
if (empty($_POST[POST_KEY]))
    exit; // or header to 404


session_start();
define('MR', 'MR');
// for serialized object retrieval
define ('SESSION_KEY', 'MY_CART');
include_once('includes/classes.php');

$data = json_decode($_POST[POST_KEY], true);
$my_cart = null;

// serialized object stored?
if (!empty($_SESSION[SESSION_KEY])) {
    $my_cart = unserialize($_SESSION[SESSION_KEY]);
}
else {
    $my_cart = new My_Cart();
}

$my_cart->add_item($data[My_Cart::INDEX_SKU], $data[My_Cart::INDEX_SIZE]);

// prepare return value
$retval = array(
    'numItems' => $my_cart->get_num_items(),
    'innerHTML' => $my_cart->generate_html_contents()
);

echo json_encode($retval);

// store the object for the later use
$_SESSION[SESSION_KEY] = serialize($my_cart);

?>