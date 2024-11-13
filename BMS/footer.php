<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div>
    <footer class="bg-light py-3 mt-4">
        <div class="container">
            <?php if ($current_page !== 'dashboard.php'&& $current_page !== 'request-document.php' && $current_page !== 'edit-profile.php' && $current_page !== 'all-requests.php'  && $current_page !== 'admin.php'  && $current_page !== 'backup.php'  && $current_page !== 'recover.php'): ?>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="home.php">Home</a></li>
                            <li><a href="aboutus.php">About Us</a></li>
                            <li><a href="portfolio1.php">Portfolio</a></li>
                            <li><a href="contactus.php">Contact Us</a></li>
                            <li><a href="login.php">Log In</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Legal</h5>
                        <ul class="list-unstyled">
                            <li><a href="terms.php">Terms and Conditions</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <div class="text-center py-1 mt-1">
                <p>© 2024 Barangay Management Services. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
