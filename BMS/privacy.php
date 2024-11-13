<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which option the user selected
    $privacy_agreement = $_POST['privacy_agreement'];

    // Redirect to home.php after submission
    if ($privacy_agreement == 'agree') {
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
                <h2 class="display-4 text-center">Privacy Policy</h2>
                <p>Your privacy is important to us. This privacy policy outlines the personal data we collect and how it is used, protected, and stored by the Barangay Management System.</p>

                <h4>1. Information We Collect</h4>
                <p>We collect personal data such as your name, email address, and any other information you provide to us while using the Barangay Management System.</p>

                <h4>2. How We Use Your Information</h4>
                <p>Your personal information is used solely to provide and improve the services offered by the Barangay Management System. We do not sell, rent, or share your personal information with third parties without your consent, except as required by law.</p>

                <h4>3. Data Protection</h4>
                <p>We take reasonable measures to ensure that your personal data is protected from unauthorized access, alteration, or destruction. However, no system is completely secure, and we cannot guarantee the absolute security of your data.</p>

                <h4>4. Cookies</h4>
                <p>The Barangay Management System may use cookies to enhance user experience. Cookies are small files stored on your device that help us remember your preferences.</p>

                <h4>5. Third-Party Services</h4>
                <p>Our system may contain links to external websites. We are not responsible for the privacy practices of these third-party sites, and we encourage you to review their privacy policies.</p>

                <h4>6. Your Rights</h4>
                <p>You have the right to request access to the personal data we hold about you and to correct or delete any inaccuracies. You may contact us for further information regarding your personal data.</p>

                <h4>7. Changes to Privacy Policy</h4>
                <p>We may update this privacy policy from time to time. Any changes will be reflected on this page with the updated effective date.</p>

                <h4>8. Contact Us</h4>
                <p>If you have any questions or concerns about our privacy practices, please contact us through the Barangay Management System.</p>

                <!-- Form to agree/disagree -->
                <form action="privacy.php" method="POST">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="privacy_agreement" value="agree" id="privacy_agree" required>
                        <label class="form-check-label" for="privacy_agree">I Agree</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="privacy_agreement" value="disagree" id="privacy_disagree" required>
                        <label class="form-check-label" for="privacy_disagree">I Do Not Agree</label>
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
