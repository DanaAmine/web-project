<?php
// cart.php - Cart management functions
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add to cart function
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    
    $item = array(
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price,
        'image' => $product_image,
        'quantity' => 1
    );
    
    // If product already in cart, increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = $item;
    }
    
    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);
    exit;
}

// Get cart count
if (isset($_GET['get_cart_count'])) {
    echo json_encode(['count' => count($_SESSION['cart'])]);
    exit;
}
?>

<!-- view_cart.php - Cart display page -->
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'Nav.php'; ?>
    
    <div class="container mt-5">
        <h2>Shopping Cart</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty</p>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="images/<?php echo $item['image']; ?>" class="card-img" alt="<?php echo $item['name']; ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                        <p class="card-text">Price: $<?php echo number_format($item['price'], 2); ?></p>
                                        <p class="card-text">Quantity: <?php echo $item['quantity']; ?></p>
                                        <button class="btn btn-danger btn-sm remove-item" data-id="<?php echo $item['id']; ?>">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cart Summary</h5>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $item) {
                                $total += $item['price'] * $item['quantity'];
                            }
                            ?>
                            <p class="card-text">Total: $<?php echo number_format($total, 2); ?></p>
                            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Update cart count
            function updateCartCount() {
                $.get('cart.php?get_cart_count=1', function(data) {
                    const response = JSON.parse(data);
                    $('#cart-count').text(response.count);
                });
            }

            // Remove item from cart
            $('.remove-item').click(function() {
                const id = $(this).data('id');
                $.post('cart.php', { remove_item: true, product_id: id }, function(data) {
                    location.reload();
                });
            });

            updateCartCount();
        });
    </script>
</body>
</html>
