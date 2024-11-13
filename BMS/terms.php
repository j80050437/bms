<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which option the user selected
    $agreement = $_POST['agreement'];

    // Redirect to home.php after submission
    if ($agreement == 'agree') {
        header("Location: home.php"); // Redirect to home page if user agrees
        exit();
    } else {
        // Optionally, you could redirect to another page if they disagree, like a page with a message.
        // For now, we'll just redirect them to the home page if they do not agree
        header("Location: home.php");
        exit();
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center; height: 80vh;">
        <tr>
            <td class="p-5" style="background-color: rgba(255, 255, 255, 0.8); max-width: 800px; margin: auto;">
                <h2 class="display-4 text-center">Terms and Conditions</h2>
                <p>By accessing and using the Barangay Management System, you agree to comply with the following terms and conditions. If you do not agree with any part of these terms, you must immediately discontinue the use of the system.</p>

                <h4>1. Acceptance of Terms</h4>
                <p>By accessing the Barangay Management System, you agree to abide by these Terms and Conditions, as well as all applicable laws and regulations. If you do not agree to these terms, do not use the system.</p>

                <h4>2. User Responsibilities</h4>
                <p>You are responsible for maintaining the confidentiality of your account information and password. You agree to immediately notify the Barangay Management System administrators of any unauthorized access to your account.</p>

                <h4>3. Privacy and Data Collection</h4>
                <p>The system collects personal data as outlined in our Privacy Policy (see <a href="privacy.php">Privacy Policy</a>).</p>

                <h4>4. Restrictions on Use</h4>
                <p>You may not use the Barangay Management System for any unlawful purpose or engage in any activity that could harm the system or other users.</p>

                <h4>5. Termination of Access</h4>
                <p>We reserve the right to suspend or terminate your access to the Barangay Management System at any time without prior notice if you violate these Terms and Conditions.</p>

                <h4>6. Limitation of Liability</h4>
                <p>The Barangay Management System is provided on an "as-is" basis. We are not liable for any damages arising from your use or inability to use the system.</p>

                <h4>7. Changes to Terms</h4>
                <p>We may update or modify these Terms and Conditions at any time without prior notice. You are responsible for reviewing these terms periodically.</p>

                <h4>8. Contact Information</h4>
                <p>If you have any questions regarding these Terms and Conditions, please contact us through the Barangay Management System.</p>

                <!-- Form to agree/disagree -->
                <form action="terms.php" method="POST">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="agreement" value="agree" id="agree" required>
                        <label class="form-check-label" for="agree">I Agree</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="agreement" value="disagree" id="disagree" required>
                        <label class="form-check-label" for="disagree">I Do Not Agree</label>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn" style="background-color: blue; color: white;">Submit</button>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
