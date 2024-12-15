<?php
// create-product.php
session_start();
require_once 'config.php';

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $original_price = floatval($_POST['original_price']);
        $discount = intval($_POST['discount']);
        $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
        $rating = intval($_POST['rating']);

        // Calculate discounted price
        $discounted_price = $original_price * (1 - ($discount / 100));

        // Handle file upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if (in_array(strtolower($filetype), $allowed)) {
                // Create unique filename
                $newname = uniqid() . '.' . $filetype;
                $target = 'images/' . $newname;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $image = $newname;
                } else {
                    throw new Exception('Failed to move uploaded file.');
                }
            } else {
                throw new Exception('Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.');
            }
        }

        // Prepare SQL statement
        $sql = "INSERT INTO products (name, description, price, original_price, discounted_price, 
                discount, image, rating, is_bestseller) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdddiisi", $name, $description, $price, $original_price, 
                         $discounted_price, $discount, $image, $rating, $is_bestseller);

        if ($stmt->execute()) {
            $message = "Product created successfully!";
            $messageType = "success";
        } else {
            throw new Exception("Error executing query: " . $conn->error);
        }

    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product - KommTech E-commerce</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "Nav.php"; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Create New Product</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="original_price">Original Price</label>
                                    <input type="number" class="form-control" id="original_price" name="original_price" step="0.01" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="price">Current Price</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="discount">Discount (%)</label>
                                    <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" value="0">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="rating">Rating (1-5)</label>
                                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="5">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Product Image</label>
                                <input type="file" class="form-control-file" id="image" name="image" required>
                                <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG, GIF</small>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_bestseller" name="is_bestseller">
                                    <label class="custom-control-label" for="is_bestseller">Mark as Best Seller</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Product</button>
                            <a href="index.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Auto-calculate discount when prices change
        document.querySelectorAll('#original_price, #price').forEach(input => {
            input.addEventListener('change', () => {
                const originalPrice = parseFloat(document.getElementById('original_price').value) || 0;
                const currentPrice = parseFloat(document.getElementById('price').value) || 0;
                
                if (originalPrice > 0 && currentPrice > 0) {
                    const discount = Math.round(((originalPrice - currentPrice) / originalPrice) * 100);
                    document.getElementById('discount').value = discount;
                }
            });
        });
    </script>
</body>
</html>