<?php
/**************************************************
 * file         : classes.php
 * written by   : KotaroW
 * date         : 11 November, 2020
 * description  : dummy classes for the test
**************************************************/

/* Let's go simple */
if (!defined('MR')) exit;

/***
    Product list. Could be json.
    We don't need any instances of this class in this case.
***/
abstract class Product_Catalog {
    
    // the first array key is an imaginary SKU (classic-tee)
    private const PRODUCT_LIST = array(
        'classic-tee' => array(
            'name'  => 'Classic Tee',
            'price' => '75.00',
            'size'  => ['S', 'M', 'L'],
            'description' => 'Cras convallis, est id sodales tempus, ipsum dolor lobortis nisl, eu euismod augue turpis sit amet dolor. Fusce quis ultricies lectus. Phasellus ut pharetra purus. Praesent hendrerit imperdiet pretium. Quisque massa risus, sollicitudin aliquet nulla at, rhoncus vehicula massa. Mauris elementum elementum nulla fermentum tristique. Integer vestibulum neque sit amet leo feugiat, in consequat nunc condimentum. Cras vel convallis ligula. Ut ipsum massa, tristique tincidunt justo eu, ullamcorper imperdiet orci. Donec quis consequat erat.',
            'img'   => './image/classic-tee.jpg'
        )
    );
    
    /*** function to get the product information.
     * @params
     *  $sku: string
     * returns array or null
     ***/
    public static function get_product_info($sku) {
        if (array_key_exists($sku, self::PRODUCT_LIST)) {
            // if the product found, prepend the sku
            // sku part is redundant. Correct it if you have time
            return array_merge(
                array("sku" => $sku),
                self::PRODUCT_LIST[$sku]
            );
        }
        return null;
    }
}

/***
 * Product class
 ***/
class Product {
    private $sku;
    private $name;
    private $price;
    private $size;
    private $description;
    private $img;

    /*** constructor
     * @params
     *  $sku: string
     ***/
    public function __construct($sku) {
        $product_info = Product_Catalog::get_product_info($sku);
        
        if ($product_info != null) {
            $this->sku = $sku;
            
            foreach($product_info as $key => $value) {
                $this->$key = $value;
            }
        }
        // no product info means the sku is incorrect
        else {
            $this->sku = null;
        }
    }
    
    /* magic method get */
    public function __get($name) {
        return $this->$name;
    }
}


/***
 * Simplified shopping cart
 ***/
class My_Cart {
    // we only increment by 1 (one)
    const DEFAULT_QTY = 1;
    
    // POST array index for SKU and Size
    const INDEX_SKU = 0;
    const INDEX_SIZE = 1;
    
    // total number of items ...
    private $num_items = 0;
    
    // sku => { size => qty, ..., ... } format. lazy though
    public $items = null;
    
    public function __construct() {
        $this->items = array();
    }
    
    public function add_item ($sku, $size, $qty = self::DEFAULT_QTY) {
        if (!array_key_exists($sku, $this->items)) {
            $this->items[$sku][$size] = $qty;
        }
        else {
            if (array_key_exists($size, $this->items[$sku])) {
                $this->items[$sku][$size] += $qty;
            }
            else {
                $this->items[$sku][$size] = $qty;
            }
        }
        $this->num_items++;
    }
    
    /*** we do not need remove_item / clear_cart in this case ***/
    
    // returns total number of items
    public function get_num_items() {
        return $this->num_items;
    }
    
    // generate the cart contents (html)
    public function generate_html_contents() {
        $format =<<<MR
            <div class="cart-item">
                <div>
                    <img src="%s" alt="%s">
                </div>
                <div>
                    <span>%s</span>
                    <span>%s &times; $%s</span>
                    <span>Size: %s</span>
                </div>
            </div>
MR;
        
        $retval = [];
        
        foreach($this->items as $sku => $sizes) {
            $product = new Product($sku);
            
            foreach($sizes as $size => $qty) {
                $htmloutput = sprintf(
                    $format,
                    $product->img,
                    $product->name,
                    $product->name,
                    $qty,
                    $product->price,
                    $size
                );
                array_push($retval, $htmloutput); 
            }
        }
        
        return implode("\n", $retval);
        
    }    
}

?>