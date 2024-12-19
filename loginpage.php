<?php
include 'config.php';
session_start();
error_reporting(0);

if (isset($_SESSION['id'])) {
    header("Location: homepage.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Educational demonstration - DO NOT use in production
    if ($password === "' OR 1=1 --") {
        // Show a teaching moment page instead of actual login
        header("Location: hint.php");
        exit();
    }
    
    // Real login logic using prepared statements
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['user_name'];
            header("Location: index.php");
        } else {
            echo "<script>alert('Incorrect email or password.')</script>";
        }
    } else {
        echo "<script>alert('User not found.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/loginpage.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body class="color">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card text-white" style="border-radius: 1rem; background-color: #293A80;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <div class="form-outline form-white mb-4">
                                        <input name="email" type="email" id="typeEmailX" class="form-control form-control-lg" placeholder="Email" required/>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input name="password" type="password" id="typePasswordX" class="form-control form-control-lg" placeholder="Password" required/>
                                    </div>
                                    <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
                                    <button name="submit" class="btn btn-outline-light btn-lg px-5" type="submit" style="background-color: #537EC5;">Login</button>
                                </div>
                                </form>
                                <div>
                                    <p class="mb-0">Don't have an account? <a href="reg.php" class="text-white-50 fw-bold">Sign Up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>