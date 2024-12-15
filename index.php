<?php 
include "header.php";
include "Nav.php";
include 'config.php';

error_reporting(0);

// Function to get best sellers
function getBestSellers($conn) {
    $sql = "SELECT * FROM products WHERE is_bestseller = 1 LIMIT 10";
    $result = $conn->query($sql);
    $products = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}
?>

<!-- Hero Section -->
<section id="home-section" class="hero">
    <div class="home-slider js-fullheight owl-carousel">
        <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
                <div class="row d-md-flex no-gutters slider-text js-fullheight align-items-center justify-content-end" data-scrollax-parent="true">
                    <div class="one-third order-md-last img js-fullheight" style="background-image:url(images/slider1.webp);">
                    </div>
                    <div class="one-forth d-flex js-fullheight align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">
                            <span class="subheading">KommTech eCommerce Shop</span>
                            <div class="horizontal">
                                <h3 class="vr" style="background-image: url(images/divider.jpg);">Established Since 2022</h3>
                                <h1 class="mb-4 mt-3">Choose Your Own <br><span>Laptop &amp; its color</span></h1>
                                <p><a href="#" class="btn btn-primary px-5 py-3 mt-3">Discover Now</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
                <div class="row d-flex no-gutters slider-text js-fullheight align-items-center justify-content-end" data-scrollax-parent="true">
                    <div class="one-third order-md-last img js-fullheight" style="background-image:url(images/qqq.jpg);">
                    </div>
                    <div class="one-forth d-flex js-fullheight align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">
                            <span class="subheading">KommTech eCommerce Shop</span>
                            <div class="horizontal">
                                <h3 class="vr" style="background-image: url(images/divider.jpg);">Shop Online</h3>
                                <h1 class="mb-4 mt-3">A Thoroughly <span>Modern</span> Screens</h1>
                                <p><a href="#" class="btn btn-primary px-5 py-3 mt-3">Shop Now</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/Wash.png);">
                <a href="!" class="icon popup-vimeo d-flex justify-content-center align-items-center">
                    <span class="icon-play"></span>
                </a>
            </div>
            <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                <div class="heading-section-bold mb-4 mt-md-5">
                    <div class="ml-md-0">
                        <h2 class="mb-4">Better Way to Ship Your Products</h2>
                    </div>
                </div>
                <div class="pb-md-5">
                    <div class="row ftco-services">
                        <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services">
                                <div class="icon d-flex justify-content-center align-items-center mb-4">
                                    <span class="flaticon-002-recommended"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Refund Policy</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services">
                                <div class="icon d-flex justify-content-center align-items-center mb-4">
                                    <span class="flaticon-001-box"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Premium Packaging</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services">
                                <div class="icon d-flex justify-content-center align-items-center mb-4">
                                    <span class="flaticon-003-medal"></span>
                                </div>
                                <div class="media-body">
                                    <h3 class="heading">Superior Quality</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Best Sellers</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php 
            $bestSellers = getBestSellers($conn);
            foreach($bestSellers as $product) : 
            ?>
            <div class="col-sm col-md-6 col-lg ftco-animate">
                <div class="product">
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="img-prod">
                        <img class="img-fluid" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <?php if($product['discount'] > 0) : ?>
                        <span class="status"><?php echo $product['discount']; ?>%</span>
                        <?php endif; ?>
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 px-3">
                        <h3><a href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h3>
                        <div class="d-flex">
                            <div class="pricing">
                                <p class="price">
                                    <?php if($product['discount'] > 0) : ?>
                                    <span class="mr-2 price-dc">$<?php echo number_format($product['original_price'], 2); ?></span>
                                    <span class="price-sale">$<?php echo number_format($product['discounted_price'], 2); ?></span>
                                    <?php else : ?>
                                    <span>$<?php echo number_format($product['price'], 2); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="rating">
                                <p class="text-right">
                                    <?php for($i = 0; $i < 5; $i++) : ?>
                                    <a href="#"><span class="ion-ios-star<?php echo ($i < $product['rating']) ? '' : '-outline'; ?>"></span></a>
                                    <?php endfor; ?>
                                </p>
                            </div>
                        </div>
                        <p class="bottom-area d-flex px-3">
							<a href="javascript:void(0);" class="add-to-cart text-center py-2 mr-1" 
							onclick="addToCart(<?php echo $product['id']; ?>, 
												'<?php echo addslashes($product['name']); ?>', 
												<?php echo ($product['discount'] > 0) ? $product['discounted_price'] : $product['price']; ?>, 
												'<?php echo $product['image']; ?>')">
								<span>Add to cart <i class="ion-ios-add ml-1"></i></span>
							</a>
							<a href="checkout.php?id=<?php echo $product['id']; ?>" class="buy-now text-center py-2">
								Buy now<span><i class="ion-ios-cart ml-1"></i></span>
							</a>
						</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="ftco-section bg-light">
    <!-- Your existing categories section code here -->
</section>

<!-- Counter Section -->
<section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/BG.jpg);">
    <!-- Your existing counter section code here -->
</section>

<!-- Newsletter Section -->
<section class="ftco-section-parallax">
    <!-- Your existing newsletter section code here -->
</section>

<!-- Add cart functionality JavaScript -->
<script>
function addToCart(productId, productName, productPrice, productImage) {
    $.ajax({
        url: 'cart.php',
        method: 'POST',
        data: {
            add_to_cart: true,
            product_id: productId,
            product_name: productName,
            product_price: productPrice,
            product_image: productImage
        },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    $('#cart-count').text(data.count);
                    alert('Product added to cart!');
                }
            } catch(e) {
                console.error('Error:', e);
            }
        },
        error: function() {
            alert('Error adding product to cart');
        }
    });
    return false;
}

// Update cart count on page load
$(document).ready(function() {
    $.get('cart.php?get_cart_count=1', function(data) {
        try {
            const response = JSON.parse(data);
            $('#cart-count').text(response.count);
        } catch(e) {
            console.error('Error:', e);
        }
    });
});
</script>

<!-- Add custom CSS for cart buttons -->
<style>
.add-to-cart-form {
    flex: 1;
}

.add-to-cart-form button {
    width: 100%;
    background: none;
    border: 1px solid #000;
    color: #000;
    border-radius: 0;
}

.add-to-cart-form button:hover {
    background: #000;
    color: #fff;
}
</style>

<?php include "footer.php" ?>
