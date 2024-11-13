<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];

$message = ''; // Initialize message variable
$message_type = ''; // Initialize message type variable

// Ensure the uploads directory exists
$uploads_dir = 'uploads';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true); // Create the directory if it doesn't exist
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $sex = $_POST['sex'];
    $homeaddress = $_POST['homeaddress'];
    $contact = $_POST['contact'];
    
    // File upload logic for profile picture
    if ($_FILES['profile_image']['name']) {
        $file_type = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            $profile_image = $uploads_dir . '/' . uniqid() . '.' . $file_type; // Use a unique filename
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image)) {
                // Success
            } else {
                $message = "Failed to upload image.";
                $message_type = "danger"; // Error message
            }
        } else {
            $message = "Invalid file type! Only JPG, JPEG, and PNG are allowed.";
            $message_type = "danger"; // Error message
        }
    } else {
        $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($profile_image);
        $stmt->fetch();
    }

    // Update user data if there's no error
    if (empty($message)) {
        $stmt = $conn->prepare("UPDATE users SET username=?, firstname=?, lastname=?, birthdate=?, sex=?, homeaddress=?, contact=?, profile_image=? WHERE id=?");
        if ($stmt === false) {
            die('SQL Error: ' . $conn->error);
        }
        $stmt->bind_param('ssssssssi', $username, $firstname, $lastname, $birthdate, $sex, $homeaddress, $contact, $profile_image, $user_id);
        $stmt->execute();
        
        $message = "Profile updated successfully!";
        $message_type = "success"; // Success message
    }
}

// Fetch user data
$stmt = $conn->prepare("SELECT username, firstname, lastname, birthdate, sex, homeaddress, contact, profile_image FROM users WHERE id=?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username, $firstname, $lastname, $birthdate, $sex, $homeaddress, $contact, $profile_image);
$stmt->fetch();
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
            <td class="p-4" style="background-color: rgba(255, 255, 255, 0.8);">
                <h2 class="display-4 text-center">Edit Profile</h2>
                <div class="text-right mb-3">
                    <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <table class="table" style="max-width: 400px; margin: auto;">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Profile Picture</label>
                                    <input type="file" name="profile_image" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Sex</label>
                                    <select name="sex" class="form-control" required>
                                        <option value="Male" <?php echo ($sex == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($sex == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Home Address</label>
                                    <input type="text" name="homeaddress" class="form-control" value="<?php echo $homeaddress; ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" name="contact" class="form-control" value="<?php echo $contact; ?>" required>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="text-center">
                        <a href="dashboard.php" class="btn btn-secondary">Go Back</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
