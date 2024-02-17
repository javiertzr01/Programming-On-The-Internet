// URL Creation Function
function cookie_url(id, value){
  return "update_cookies.php?cookieValue=" + encodeURIComponent(value) + "&cookieId=" + encodeURIComponent(id);
}

function table_url(id="none", quantity="none", mode){
  return "cart_table.php?id=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity) + "&mode=" + encodeURIComponent(mode);
}

function total_price_url(total){
  return "cart_total_price.php?total=" + encodeURIComponent(total);
}

// xhttp Functions
function xhttp(callback, url){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          callback(this.responseText);
    };
  }
  xhttp.open("GET", url, true);
  xhttp.send();
}

function update_cookies(id, value){
  const url = cookie_url(id, value);
  xhttp(function(){}, url);
}

function update_table(row, id, quantity, mode) {
  const content = row.parentNode.parentNode;
  const url = table_url(id, quantity, mode);
  xhttp(function(responseText) {
    content.innerHTML = responseText;
    update_total_price();
    update_checkout();
  }, url);
}

function update_total_price(){
  const inputs = document.querySelectorAll('.cart-input');
  const content = document.getElementById("total-price");
  var id = 0;
  var total = 0;
  inputs.forEach(input => {
    id = input.id.slice(0, -9);
    let price = parseFloat(document.getElementById(id+"_price").innerHTML.slice(1));
    total += price;
  })
  
  const url = total_price_url(total);
  xhttp(function(responseText) {
    content.innerHTML = responseText;
  }, url);
  
}

function update_checkout(){
    const inputs = document.querySelectorAll('.cart-input');
    var enabled = false;
    if (inputs.length > 0){
      enabled = true;
    }
    const url = "../checkout.php?enabled=" + encodeURIComponent(enabled);
    xhttp(function(responseText){
      const checkout_frame = parent.document.getElementById("checkout-frame");
      const iframe3Doc = checkout_frame.contentWindow.document;
      var content = iframe3Doc.getElementById("checkout_button");
      content.innerHTML = responseText;
    }, url);
}


// Specific Items
function handleQuantityChange(event, row, id, stock) {
  const inputs = document.querySelectorAll('.cart-input'); // Get all inputs with class 'cart-input'
  inputs.forEach(input => {
    input.disabled = true; // Disable all inputs
  });
  
  // Activity comes here
  var new_quantity = document.getElementById(id+"_quantity").value;
  
  const max_stock = Math.min(stock, 50);
  
  if(new_quantity > max_stock){
    new_quantity = max_stock;
  }
  
  update_cookies(id, new_quantity);
  update_table(row, id, new_quantity, "change");
  
  setTimeout(() => {
    inputs.forEach(input => {
      input.disabled = false; // Enable all inputs
    });
  }, 1000); // Enable after 1 second
}

function delete_item(row, id){
  update_cookies(id, 0);
  update_table(row, id, 0, "remove");
}

function clear_cart(){
  const inputs = document.querySelectorAll('.cart-input'); // Get all inputs with class 'cart-input'
  var id = 0;
  inputs.forEach(input => {
    id = input.id.slice(0, -9);
    let row = document.getElementById(id+"_quantity");
    delete_item(row, id);
  });
}