/**************************************************
 * file         : script.js
 * written by   : KotaroW
 * date         : 12th November, 2020
 * description  : Javascript for the Technical Test for MR
 **************************************************/


/*** Shopping Cart object ***/
var ShoppingCart = {
    selectedItem : null,
    
    // this function is hooked within the html tag
    selectItem : function (selectedItemElement) {

        // careful "this" == "selectedItemElement" in this context
        ShoppingCart.selectedItem = selectedItemElement;
       
        var selectedSize = selectedItemElement.getAttribute("data-size");
        
        // populate and render the selected size
        var targetElement = document.getElementById("size-selected");
        targetElement.textContent = selectedSize;
        targetElement.style.fontWeight = "bold";
        
        // enable the add button
        document.querySelector("button").disabled = false;
        
        // all the sizes
        var sizes = document.getElementById("sizes").getElementsByTagName("span");
        
        // assuming that there are no errors
        sizes = Array.prototype.slice.call(sizes);
        
        // remove the class
        sizes.map(size => size.className = "");
        
        // add the class to the selected size
        selectedItemElement.className = "size-selected";
    },
    
    addItem : function () {
        // Technically this won't happen but just in case
        if (this.selectedItem == null) {
            alert ("Please select size");
            return;
        }
        var sku = this.selectedItem.getAttribute("data-sku");
        var size = this.selectedItem.getAttribute("data-size");
        
        // add item to the cart
        new Promise((resolve, reject) => {
            var formdata = new FormData();
            formdata.append(
                "data",
                JSON.stringify([
                    sku,
                    size
                ])
            );
            
            var xhr = new XMLHttpRequest();
            xhr.open("post", "./aja.php", true);
            xhr.send(formdata);
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        resolve(xhr.responseText);
                    }
                    else {
                        reject(xhr);
                    }
                }
            }
            
        })
        .then (response => {

            var data = JSON.parse(response);
            var numItems = data.numItems;
            document.getElementById("num-items").textContent = numItems.toString();
            document.querySelector("#cart-items").innerHTML = data.innerHTML;

        })
        .catch (err => {
            alert("ERROR");
            console.log(err);
        });
    }
    
};



/*** set listeners upon load event
this one could be in a separate file
***/
window.addEventListener(
    "load",
    function () {
        // cart toggle
        document.querySelector("#my-cart").addEventListener(
    	   "click",
            function (evt) {
        	   this.classList.toggle("cart-shown");
        	   document.querySelector("#cart-items").classList.toggle("show-cart");
            },
    	   false
        );
        // to make sure the add item button is disabled
        document.querySelector("button").disabled = true;
        
        // add item button
        document.querySelector("button").addEventListener(
            "click",
            function () {
                ShoppingCart.addItem ();
            },
            false
        );
    },
    false
);