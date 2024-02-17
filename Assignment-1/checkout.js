function disable_cart_changes(){
    // Disable add to cart
    const catalog_frame = parent.document.getElementById("view-frame");
    const catalog_document = catalog_frame.contentWindow.document;
    const buttons = catalog_document.querySelectorAll('.button-image');
    buttons.forEach((button) => {
        button.classList.add('disabled');
    });
    // Disable quantity change
    const cart_frame = parent.document.getElementById("cart-frame");
    const cart_document = cart_frame.contentWindow.document;
    const quantity_change = cart_document.querySelectorAll('.cart-input');
    quantity_change.forEach(input => {
        input.disabled = true;
    });
    
    // Disable remove from cart
    const remove_btn = cart_document.querySelectorAll('.remove-btn');
    remove_btn.forEach((button) => {
        button.classList.add('disabled');
    });
    
    // Disable changing pages
    // const allLinks = parent.document.querySelectorAll('a');
    // allLinks.forEach(link => {
    //   link.addEventListener('click', event => {
    //     event.preventDefault();
    //   });
    // });
    
    // Disable clear cart button
    const clear_btn = cart_document.getElementById('clear-cart');
    clear_btn.disabled = true;
    
    // Disable checkout button
    const checkout_btn = document.querySelector('.page-container');
    checkout_btn.classList.add('disabled');
}

function enable_cart_changes(){
    // Enable add to cart
    const catalog_frame = parent.document.getElementById("view-frame");
    const catalog_document = catalog_frame.contentWindow.document;
    const buttons = catalog_document.querySelectorAll('.button-image');
    buttons.forEach((button) => {
        button.classList.remove('disabled');
    });
    // Enable quantity change
    const cart_frame = parent.document.getElementById("cart-frame");
    const cart_document = cart_frame.contentWindow.document;
    const quantity_change = cart_document.querySelectorAll('.cart-input');
    quantity_change.forEach(input => {
        input.disabled = false;
    });
    
    // Enable remove from cart
    const remove_btn = cart_document.querySelectorAll('.remove-btn');
    remove_btn.forEach((button) => {
        button.classList.remove('disabled');
    });
    
    // Enable changing pages
    // const allLinks = parent.document.querySelectorAll('a');
    // allLinks.forEach(link => {
    //     link.removeEventListener('click', event => {
    //         event.preventDefault();
    //     });
    // });
    
    // Enable clear cart button
    const clear_btn = cart_document.getElementById('clear-cart');
    clear_btn.disabled = false;
    
    // Enable checkout button
    const checkout_btn = document.querySelector('.page-container');
    checkout_btn.classList.remove('disabled');
}

function checkout(s_array){
    disable_cart_changes();
    var newWindow = window.open("order_form.php?order=" + s_array ,'_blank');
    checkWindowStatus();
    
    function checkWindowStatus() {
        if (newWindow.closed) {
            enable_cart_changes();
            clear_cart();
        } else {
            setTimeout(checkWindowStatus, 1000);
        }
    }
}

function clear_cart(){
    const checkout_frame = parent.document.getElementById("cart-frame");
    const iframeDoc = checkout_frame.contentWindow.document;
    var content = iframeDoc.getElementById("clear-cart");
    content.click();
}