<?php
// Include database connection
include 'db.php';

$message = ''; // Initialize message variable
$message_type = ''; // Initialize message type variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check_email->bind_param('s', $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        $message = "Email is already in use!";
        $message_type = "danger"; // Error message
    } else {
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $firstname, $lastname, $username, $email, $password);

        if ($stmt->execute()) {
            $message = "Registration successful! You can <a href='login.php'>login here</a>.";
            $message_type = "success"; // Success message
        } else {
            $message = "Something went wrong!";
            $message_type = "danger"; // Error message
        }
    }
}
?>

<?php include 'header.php'; ?>

<!-- Success/Error Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center;">
        <tr>
            <td class="p-4" style="background-color: rgba(255, 255, 255, 0.8); max-width: 350px; margin: auto;">
                <h2 class="display-4 text-center">Register</h2>
                <div class="forms-container">
                    <form action="register.php" method="POST" class="sign-up-form">
                        <h2 class="signup-title text-center">Create Account</h2>
                        <table class="table" style="max-width: 400px; margin: auto;">
                            <tr>
                                <td class="text-left">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left">
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password</label>
                                        <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" required>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="text-center mt-1">
                            <input type="submit" class="btn" style="background-color: green; color: white;" value="Sign Up">
                        </div>
                        <div class="text-center mt-0">
                            <h3>Or sign up with:</h3>
                            <a href="facebook-login.php" class="btn btn-primary me-2">Facebook</a>
                            <a href="gmail-login.php" class="btn btn-danger">Gmail</a>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>

<!-- Add jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Show modal if there is a message
        <?php if (!empty($message)): ?>
            $('#notificationModal').modal('show');
        <?php endif; ?>
    });
</script>
