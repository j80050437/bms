<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Default admin credentials
    $default_username = "admin";
    $default_password = "admin123";

    if ($username === $default_username && $password === $default_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center; height: 80vh;">
        <tr>
            <td class="p-5" style="background-color: rgba(255, 255, 255, 0.8); max-width: 400px; margin: auto;">
                <h2 class="display-4 text-center">Admin Login</h2>
                <?php if (isset($error)) echo "<div class='alert alert-danger text-center'>$error</div>"; ?>
                <form method="POST">
                    <table class="table" style="max-width: 300px; margin: auto;">
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" required>
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
                    <button type="submit" class="btn" style="background-color: blue; color: white;">Login</button>
                </form>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>
