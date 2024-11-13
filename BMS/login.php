<?php
// Include database connection
include 'db.php';
session_start();

$error_message = ""; // Initialize an error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid email or password!";
    }
}
?>

<?php include 'header.php'; ?>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Login Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($error_message): ?>
                    <?php echo $error_message; ?>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center; height: 80vh;">
        <tr>
            <td class="p-4" style="background-color: rgba(255, 255, 255, 0.8); max-width: 350px; margin: auto;">
                <h2 class="display-4">Login</h2>
                <form method="POST" action="login.php">
                    <table class="table" style="max-width: 300px; margin: auto;">
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <p class="mt-3">New here? <a href="register.php">Create an account</a></p>
                
                <h3>Or sign in using:</h3>
                <div class="text-center mt-0">
                    <a href="facebook-login.php" class="btn btn-primary me-2">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="gmail-login.php" class="btn btn-danger">
                        <i class="fab fa-google"></i> Gmail
                    </a>
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
        <?php if ($error_message): ?>
            $('#errorModal').modal('show');
        <?php endif; ?>
    });
</script>

<!-- Add Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
