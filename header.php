<?php session_start(); ?> // conserver les infos des users 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>KommTech</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/homestyle.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .top-bar {
            background: linear-gradient(135deg, #5e5db1 0%, #4a49a1 100%);
            padding: 10px 0;
            font-family: 'Poppins', sans-serif;
        }
        
        .contact-info {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
        }
        
        .contact-info .icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .contact-info:hover .icon {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .auth-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .auth-links a {
            color: white;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .auth-links a.login {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .auth-links a.register {
            background: #ffa45c;
            color: #333;
        }
        
        .auth-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .welcome-text {
            color: white;
            font-weight: 500;
            margin: 0;
        }
        
        .account-links {
            display: flex;
            gap: 15px;
        }
        
        .account-links a {
            color: #ffd700;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .account-links a:hover {
            color: white;
        }
    </style>
</head>

<body class="goto-here">
    <div class="top-bar">
        <div class="container">   <!-- /boots -->        
            <div class="row align-items-center">     <!-- /boots -->                          
				
                <div class="col-md-4">  <!-- sys grille bootstrap responsivite  -->
                    <div class="contact-info">
                        <div class="icon d-flex justify-content-center align-items-center">  <!-- centrer verticalement -->
                            <span class="icon-phone2"></span>
                        </div>
                        <span>0666334422</span>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="contact-info">
                        <div class="icon d-flex justify-content-center align-items-center">
                            <span class="icon-paper-plane"></span>
                        </div>
                        <span>mama.marouainfo11@gmail.com</span>
                    </div>
                </div>

                <div class="col-md-4 text-right">
                    <?php if(!isset($_SESSION['id'])): ?>
                        <div class="auth-links">
                            <a href="loginpage.php" class="login">Login</a>
                            <a href="reg.php" class="register">Register</a>
                        </div>
                    <?php else: ?>
                        <div class="account-links">
                            <h6 class="welcome-text">Welcome <?php echo $_SESSION['username']; ?></h6>
                            <a href="account.php">Account</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>