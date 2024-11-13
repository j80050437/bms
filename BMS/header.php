<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0f7fa;
        }
        .nav-item {
            margin: 0 10px;
        }
        @media (max-width: 576px) {
            .nav-item {
                margin: 5px 0;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="bg-light text-dark py-2">
    <div class="container d-flex justify-content-between align-items-center">
        <img src="logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top rounded-circle me-2">
        <h4 class="mb-0">Barangay Management Services</h4>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if ($current_page !== 'dashboard.php' && $current_page !== 'request-document.php' && $current_page !== 'all-requests.php' && $current_page !== 'edit-profile.php'  && $current_page !== 'admin.php'  && $current_page !== 'backup.php'  && $current_page !== 'recover.php'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutus.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="portfolio1.php">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contactus.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Log in</a>
                        </li>
                    <?php else: ?>
                        <a href="logout.php" class="btn btn-danger" style="float: right;">Logout</a>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
    <div class="container">
        <!-- Content here -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
