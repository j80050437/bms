<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data
include 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT firstname, lastname, email FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $email);
$stmt->fetch();
?>

<?php include 'header.php'; ?>

<!-- Include Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 1s forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .email-text {
        margin-top: 10px;
        font-weight: bold;
    }

    .btn i {
        margin-right: 8px; /* Adds space between icon and text */
        font-size: 1.2em; /* Adjusts icon size */
    }
</style>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center; height: 80vh;">
        <tr>
            <td class="p-5" style="background-color: rgba(255, 255, 255, 0.8);">
                <div style="text-align: center;">
                    <h1 class="display-4">Dashboard</h1>
                </div>

                <!-- Welcome Message -->
                <div class="fade-in" style="color: #2F4F4F;">
                    <h3>Welcome, <?php echo htmlspecialchars($firstname . ' ' . $lastname); ?></h3>
                </div>

                <!-- Email Message -->
                <div class="fade-in email-text" style="color: #2F4F4F;">
                    <h3>Your Email: <?php echo htmlspecialchars($email); ?></h3>
                </div>

                <!-- Action Buttons with Icons -->
                <div class="mt-4">
                    <table class="table table-bordered" style="max-width: 300px; margin: auto;">
                        <tr>
                            <td>
                                <a href="edit-profile.php" class="btn btn-primary btn-lg mb-3 w-100">
                                    <i class="fas fa-user-edit"></i> Edit Profile
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="request-document.php" class="btn btn-primary btn-lg mb-3 w-100">
                                    <i class="fas fa-file-alt"></i> Request Document
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="all-requests.php" class="btn btn-primary btn-lg mb-3 w-100">
                                    <i class="fas fa-list-alt"></i> View All Requests
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>
