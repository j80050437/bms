<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}

include 'db.php';

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = '%' . $_POST['search_query'] . '%';
}

// Fetch all users with optional search
$user_stmt = $conn->prepare("SELECT id, username, CONCAT(firstname, ' ', lastname) AS fullname, email, birthdate, sex, contact, homeaddress FROM users WHERE username LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?");
if (!$user_stmt) {
    die("Prepare failed: " . $conn->error);
}
$user_stmt->bind_param('ssss', $search_query, $search_query, $search_query, $search_query);
$user_stmt->execute();
$user_stmt->store_result();

if ($user_stmt->num_rows > 0) {
    $user_stmt->bind_result($id, $username, $fullname, $email, $birthdate, $sex, $contact, $homeaddress);
} else {
    $user_stmt->close();
    // Fallback to fetch all users without search
    $user_stmt = $conn->prepare("SELECT id, username, CONCAT(firstname, ' ', lastname) AS fullname, email, birthdate, sex, contact, homeaddress FROM users");
    if (!$user_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $user_stmt->execute();
    $user_stmt->store_result();
    $user_stmt->bind_result($id, $username, $fullname, $email, $birthdate, $sex, $contact, $homeaddress);
}

// Handle request approval/decline
$action_message = '';
if (isset($_POST['action']) && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['action'] === 'approve' ? 'approved' : 'declined';

    $update_stmt = $conn->prepare("UPDATE requests SET status=? WHERE request_id=?");
    if (!$update_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $update_stmt->bind_param('si', $status, $request_id);
    $update_stmt->execute();

    // Set the action message for pop-up
    $action_message = ($_POST['action'] === 'approve') ? "Approved successfully" : "Declined successfully";
}

// Fetch all requests
$request_stmt = $conn->prepare("SELECT r.request_id, u.firstname, u.lastname, r.purpose, r.document_type, r.date_of_request, r.status, r.payment_method, r.service_method FROM requests r INNER JOIN users u ON r.user_id = u.id");
if (!$request_stmt) {
    die("Prepare failed: " . $conn->error);
}

$request_stmt->execute();
$request_stmt->store_result();

// Bind the result variables correctly
$request_stmt->bind_result($request_id, $firstname, $lastname, $purpose, $document_type, $date_of_request, $status, $payment_method, $service_method);

// Handle delete user
if (isset($_POST['delete_user_id'])) {
    $delete_user_stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    if (!$delete_user_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $delete_user_stmt->bind_param('i', $_POST['delete_user_id']);
    $delete_user_stmt->execute();

    // Set the delete message for pop-up
    $action_message = "Successfully deleted";
    header("Location: admin.php?message=$action_message"); // Redirect with message
    exit();
}

// Fetch contact messages
$message_stmt = $conn->prepare("SELECT id, name, email, message FROM contact_messages");
if (!$message_stmt) {
    die("Prepare failed: " . $conn->error);
}
$message_stmt->execute();
$message_stmt->store_result();
$message_stmt->bind_result($message_id, $message_name, $message_email, $message_content);

// Delete a specific message
if (isset($_POST['delete_message_id'])) {
    $delete_stmt = $conn->prepare("DELETE FROM contact_messages WHERE id=?");
    if (!$delete_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $delete_stmt->bind_param('i', $_POST['delete_message_id']);
    $delete_stmt->execute();

    // Set the delete message for pop-up
    $action_message = "Successfully deleted";
    header("Location: admin.php?message=$action_message"); // Redirect with message
    exit();
}
?>

<?php include 'header.php'; ?>

<!-- Success Modal -->
<?php if ($action_message): ?>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"><?php echo htmlspecialchars($action_message); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center;">
        <td class="p-5" style="background-color: rgba(255, 255, 255, 0.8); max-width: 400px; margin: auto;">
            <div class="text-center mb-4">
                <h2 class="display-4">Admin Dashboard</h2>
                
                <!-- Search bar -->
                <form method="POST" class="form-inline justify-content-end">
                    <input type="text" name="search_query" class="form-control mr-2" placeholder="Search users..." value="<?php echo htmlspecialchars($_POST['search_query'] ?? ''); ?>">
                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <!-- User management section -->
                <h3 class="font-weight-bold text-center border-bottom">All Users</h3>
                <table class="table table-bordered text-center" style="background-color: rgba(255, 255, 255, 0.8);">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Birthdate</th>
                            <th>Sex</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($user_stmt->num_rows > 0): ?>
                            <?php while ($user_stmt->fetch()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($username); ?></td>
                                <td><?php echo htmlspecialchars($fullname); ?></td>
                                <td><?php echo htmlspecialchars($email); ?></td>
                                <td><?php echo htmlspecialchars($birthdate); ?></td>
                                <td><?php echo htmlspecialchars($sex); ?></td>
                                <td><?php echo htmlspecialchars($contact); ?></td>
                                <td><?php echo htmlspecialchars($homeaddress); ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete User">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No existing user found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Request management section -->
                <h3 class="font-weight-bold text-center border-bottom">All User Requests</h3>
                <table class="table table-bordered text-center" style="background-color: rgba(255, 255, 255, 0.8);">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Purpose</th>
                            <th>Document Type</th>
                            <th>Date of Request</th>
                            <th>Payment</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($request_stmt->num_rows > 0): ?>
                            <?php while ($request_stmt->fetch()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($firstname . ' ' . $lastname); ?></td>
                                <td><?php echo htmlspecialchars($purpose); ?></td>
                                <td><?php echo htmlspecialchars($document_type); ?></td>
                                <td><?php echo htmlspecialchars($date_of_request); ?></td>
                                <td><?php echo htmlspecialchars($payment_method); ?></td>
                                <td><?php echo htmlspecialchars($service_method); ?></td>
                                <td><?php echo htmlspecialchars($status); ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="request_id" value="<?php echo $request_id; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm" data-toggle="tooltip" title="Approve Request">Approve</button>
                                        <button type="submit" name="action" value="decline" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Decline Request">Decline</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No requests found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Notifications section -->
                <h3 class="font-weight-bold text-center border-bottom">Contact Messages</h3>
                <table class="table table-bordered text-center" style="background-color: rgba(255, 255, 255, 0.8);">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($message_stmt->num_rows > 0): ?>
                            <?php while ($message_stmt->fetch()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message_name); ?></td>
                                <td><?php echo htmlspecialchars($message_email); ?></td>
                                <td><?php echo htmlspecialchars($message_content); ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="delete_message_id" value="<?php echo $message_id; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete Message">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No messages found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="text-center mt-5">
                    <a href="backup.php" class="btn btn-warning btn-lg">Backup Database</a>
                    <a href="recover.php" class="btn btn-success btn-lg">Recover Database</a>
                </div>
            </div>
        </td>
    </table>  
</div>

<script>
    // Display pop-up notification for actions (approve/decline/delete)
    $(document).ready(function() {
        <?php if ($action_message): ?>
            $('#successModal').modal('show');
        <?php endif; ?>
    });
</script>

<?php include 'footer.php'; ?>
