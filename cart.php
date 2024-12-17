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
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = $item;
    }
    
    echo json_encode(['success' => true, 'count' => count($_SESSION['cart'])]);
    exit;
}

// Remove item
if (isset($_POST['remove_item'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    echo json_encode(['success' => true]);
    exit;
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = max(1, intval($_POST['quantity']));
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
    echo json_encode(['success' => true]);
    exit;
}

// Get cart count
if (isset($_GET['get_cart_count'])) {
    echo json_encode(['count' => count($_SESSION['cart'])]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <?php include 'Nav.php'; ?>
    
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold">Shopping Cart</h1>
        <p class="text-gray-600 mb-8">Review and modify your selected items</p>

        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty</p>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="bg-white p-6 mb-4">
                    <div class="flex items-start gap-6">
                        <div class="w-1/4">
                            <img src="images/<?php echo htmlspecialchars($item['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>"
                                 class="w-full">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-xl font-bold"><?php echo htmlspecialchars($item['name']); ?></h2>
                                    <p class="text-gray-600">SKU: <?php echo htmlspecialchars($item['id']); ?></p>
                                </div>
                                <button class="text-red-500 remove-item" data-id="<?php echo htmlspecialchars($item['id']); ?>">
                                    Remove
                                </button>
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <label>Quantity:</label>
                                    <div class="flex items-center gap-2">
                                        <button class="update-quantity px-3 py-1 border" 
                                                data-id="<?php echo htmlspecialchars($item['id']); ?>" 
                                                data-delta="-1">-</button>
                                        <span><?php echo $item['quantity']; ?></span>
                                        <button class="update-quantity px-3 py-1 border" 
                                                data-id="<?php echo htmlspecialchars($item['id']); ?>" 
                                                data-delta="1">+</button>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Price</p>
                                    <p class="text-2xl font-bold">$<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="bg-white p-6 max-w-sm ml-auto">
                <h2 class="text-xl font-bold mb-4">Cart Summary</h2>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                ?>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span class="text-green-600">Free</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="font-bold">Total</span>
                            <span class="font-bold">$<?php echo number_format($total, 2); ?></span>
                        </div>
                    </div>
                </div>
                <a href="checkout.php" class="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded mt-4">
                    Proceed to Checkout
                </a>
                <p class="text-sm text-gray-500 text-center mt-2">
                    Free shipping on all orders
                </p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateCartCount() {
                $.get('cart.php?get_cart_count=1', function(data) {
                    const response = JSON.parse(data);
                    $('#cart-count').text(response.count);
                });
            }

            $('.remove-item').click(function() {
                const id = $(this).data('id');
                $.post('cart.php', { remove_item: true, product_id: id }, function(data) {
                    location.reload();
                });
            });

            $('.update-quantity').click(function() {
                const id = $(this).data('id');
                const delta = $(this).data('delta');
                const quantityElement = $(this).siblings('span');
                const currentQuantity = parseInt(quantityElement.text());
                const newQuantity = Math.max(1, currentQuantity + delta);

                $.post('cart.php', { 
                    update_quantity: true, 
                    product_id: id,
                    quantity: newQuantity 
                }, function(data) {
                    location.reload();
                });
            });

            updateCartCount();
        });
    </script>
</body>
</html>