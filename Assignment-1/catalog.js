function changeBackground(img) {
    var buttonImage = img.parentNode;
    buttonImage.style.width = img.width + 'px';
    buttonImage.style.height = img.height + 'px';
}

// Quantity On Change
function handleOnInput(id, stock){
    var value = document.getElementById(id).value;
    if(value < 0){
        document.getElementById(id).value=0;
    }else{
        var max_amount = Math.min(stock, 50);
        if(value > max_amount){
            document.getElementById(id).value=max_amount;
        }
    }
}


// check quantity for non-null and non-zero
function checkValue(inputValue, max_quantity){
    inputValue = parseInt(inputValue);
    if (Number.isInteger(inputValue) && inputValue > 0 && inputValue <= max_quantity) {
      return true;
    } else {
      return false;
    }
}

function setCookie(id, value, change){
    
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            addRow(id, value);
            // Update Total Price
            addTotal(id, change);
            // Change Checkout
            changeCheckout();
        }
    };
    
    xhttp.open("GET", "cart/cart.php?cookieValue=" + encodeURIComponent(value) + "&cookieId=" + encodeURIComponent(id), true);
    xhttp.send();
    
}

function addRow(id, quantity){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const cart_frame = parent.document.getElementById("cart-frame");
            // Get the window of the iframe
            const iframe2Doc = cart_frame.contentWindow.document;
            // Update the content of the "table"
            var content = iframe2Doc.getElementById("table");
            content.innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET", "cart/cart_table.php?id=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity), true);
    xhttp.send();
}

function addTotal(id, quantity){
    var xhttp = new XMLHttpRequest();
    const cart_frame = parent.document.getElementById("cart-frame");
    const iframe2Doc = cart_frame.contentWindow.document;
    const total = parseFloat(iframe2Doc.getElementById("total-price-value").innerHTML.slice(1));
    const change = quantity;
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Update the content of the "table"
            const content = iframe2Doc.getElementById("total-price");
            content.innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET", "cart/cart_total_price.php?quantity=" + encodeURIComponent(change) + "&id=" + encodeURIComponent(id) + "&current=" + encodeURIComponent(total), true);
    xhttp.send();
}

function changeCheckout(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Update the content of the "table"
            const checkout_frame = parent.document.getElementById("checkout-frame");
            const iframe3Doc = checkout_frame.contentWindow.document;
            var content = iframe3Doc.getElementById("checkout_button");
            content.innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET", "/checkout.php?enabled=true", true);
    xhttp.send();
}

function handleAddCart(id, stock){
    const buttons = document.querySelectorAll('.button-image');
      buttons.forEach((button) => {
        button.classList.add('disabled');
      });
    var quantity = 0;
    quantity = parseInt(document.getElementById(id+"_quantity").value);
    if(isNaN(quantity)){
        quantity = 0;
    };
    
    if(quantity == 0)
    {
      alert("Minimum order is 1");
      buttons.forEach((button) => {
        button.classList.remove('disabled');
      });
    }
    
    
    var new_cart_quantity = quantity;
    const cart_frame = parent.document.getElementById("cart-frame");
    try{
        const old_cart_quantity = parseInt(cart_frame.contentWindow.document.getElementById(id+"_quantity").value);
        new_cart_quantity = old_cart_quantity + quantity;
    }catch{
       
    }
    
    var max_quantity = Math.min(stock, 50);
    
    if(checkValue(new_cart_quantity, max_quantity)){
      
        // Add to cart
        setCookie(id, new_cart_quantity, quantity);
        
        // Disable button for 1 second
        setTimeout(() => {
          buttons.forEach((button) => {
            button.classList.remove('disabled');
          });
        }, 1000);
        
        document.getElementById(id+"_quantity").value = "";
    }
    
    // Check for accurate order quantity
    else if(new_cart_quantity > max_quantity){
      alert("Maximum order in cart is "+ max_quantity + ".");
      buttons.forEach((button) => {
        button.classList.remove('disabled');
      });
    }
}