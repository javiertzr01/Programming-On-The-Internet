<html>
    <head>
        <link href="catalog.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body>
        <div class="content-container"></div>
        <script>
            $(document).ready(function() {
                load_catalog(); 
            
                // setInterval(function() {
                //     load_catalog(); 
                // }, 5000);
            });
            
            
            function load_catalog(){
                $.ajax({
                    url: 'load_json.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var container = $('.content-container');
                        var html = "";
                        $.each(data, function(index, car) {
                            var name = car["brand"] + "-" + car["model"] + "-" + car["model year"];
                            var cart_name = "'" + car["model year"] + "-" + car["brand"] + "-" + car["model"] + "'";
                            var img_src = "'assets/cars/" + name + ".jpg'";
                            var catalog_item = '<div class="catalog-item">' + 
                                            '<h3>' + name + '</h3>' +
                                            '<div class="image-container">' +
                                                '<img src="assets/cars/' + name + '.jpg" alt=' + name + '>' +
                                            '</div>' +
                                            '<div class="info-container">' +
                                                '<div class="info">' +
                                                '<p><strong>Mileage:</strong> ' + car["mileage"] +'kms</p>' +
                                                '<p><strong>Fuel Type:</strong> ' + car["fuel-type"] +'</p>' +
                                                '<p><strong>Seats:</strong> ' + car["seats"] +'</p>' +
                                                '<p><strong>Price per Day:</strong> $' + car["price/day"] +'</p>' +
                                                '<p><strong>Availability:</strong> ' + car["availability"] +'</p>' +
                                                '<p><strong>Description:</strong> ' + car["description"] +'</p>' +
                                                '</div>' +
                                                '<div class="add-button-container">' +
                                                    '<div class="button" id=' + index + ' onclick="add_to_cart('+ car["availability"] + ',' + cart_name + ',' + img_src + ',' + car["price/day"] + ')">Add To Cart</div>' +
                                                '</div>' +
                                            '</div>' +
                                          '</div>';
                            html += catalog_item;
                        });
                        container.html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
            
            function add_to_cart(availability, name, img_src, ppd){
                if (availability == true){
                    var data = {
                        "name": name,
                        "img_src": img_src,
                        "ppd": ppd,
                        "rental_days": 1
                    };
                    $(document).ready(function() {
                        $.ajax({
                            url: "add_to_session.php",
                            type: "POST",
                            data: { data: data },
                            dataType: "json",
                            success: function(response) {
                                console.log("Car added to session:", response);
                                alert(response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                            }
                        });
                    });
                }
                else{
                    alert("Sorry, the car is not available now. Please try other cars.");
                }
            }
        </script>
    </body>
</html>