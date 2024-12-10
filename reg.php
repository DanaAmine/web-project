<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Redirect if already logged in
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $_POST['password']);
    $lowercase = preg_match('@[a-z]@', $_POST['password']);
    $number = preg_match('@[0-9]@', $_POST['password']);
    $specialchars = preg_match('@[^\w]@', $_POST['password']);

    $error = '';
    
    if (!$uppercase || !$lowercase || !$number || !$specialchars || strlen($_POST['password']) < 8) {
        $error = 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.';
    } elseif ($password != $cpassword) {
        $error = 'Passwords do not match.';
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
              $_SESSION['registration_success'] = true;
              header('Location: loginpage.php');
              exit();
          } else {
              echo "Error: " . mysqli_error($conn);
              die('Failed to execute query.');
          }          
          
        } else {
            $error = 'Email already exists.';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="signuppage.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <section class="vh-100" style="background-color: white;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 55px; background-color: #293A80;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4" style="color: white;">Sign up</p>
                                    
                                    <?php if(isset($error) && !empty($error)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form class="mx-1 mx-md-4" action="" method="POST">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" name="username" class="form-control" placeholder="Your Name" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="email" class="form-control" placeholder="Your Email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password" class="form-control" placeholder="Password" required />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="cpassword" class="form-control" placeholder="Repeat your password" required />
                                            </div>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <input class="form-check-input me-2" type="checkbox" value="" required />
                                            <label class="form-check-label" style="color: white;">
                                                I agree to all statements in <a href="#!" style="color: #537EC5;">Terms of service</a>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button name="submit" type="submit" class="btn btn-lg" style="background-color: #537EC5; color: white;">Register</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="images/Join.jpg" class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>