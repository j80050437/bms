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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purpose = $_POST['purpose'];
    $document_type = $_POST['document_type'];
    $payment_method = $_POST['payment_method'];
    $service_method = $_POST['service_method'];
    $valid_id_type = $_POST['valid_id_type'];
    $date_of_request = $_POST['date_of_request']; // New date_of_request
    $fee = $_POST['fee']; // New fee
    $service_method = $_POST['service_method']; // New service method

    // File upload logic for valid ID
    $valid_id_front = 'uploads/' . basename($_FILES['valid_id_front']['name']);
    move_uploaded_file($_FILES['valid_id_front']['tmp_name'], $valid_id_front);
    
    $valid_id_back = 'uploads/' . basename($_FILES['valid_id_back']['name']);
    move_uploaded_file($_FILES['valid_id_back']['tmp_name'], $valid_id_back);

    // Prepare SQL query with new fields
    $stmt = $conn->prepare("INSERT INTO requests (user_id, purpose, document_type, valid_id_type, valid_id_front, valid_id_back, payment_method, service_method, date_of_request, fee, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param('issssssssd', $user_id, $purpose, $document_type, $valid_id_type, $valid_id_front, $valid_id_back, $payment_method, $service_method, $date_of_request, $fee);
    
    if ($stmt->execute()) {
        $message = "Request submitted successfully!";
        $message_type = "success"; // Success message
    } else {
        $message = "Something went wrong!";
        $message_type = "danger"; // Error message
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
            <td class="p-4" style="background-color: rgba(255, 255, 255, 0.8);">
                <h2 class="display-4 text-center">Request Document</h2>
                <form method="POST" enctype="multipart/form-data">
                <table class="table" style="max-width: 400px; margin: auto;">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Purpose</label>
                                    <input type="text" name="purpose" class="form-control" maxlength="50" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Document Type</label>
                                    <select name="document_type" class="form-control" required>
                                        <option value="Barangay Clearance">Barangay Clearance</option>
                                        <option value="Certificate of Indigency">Certificate of Indigency</option>
                                        <option value="Barangay ID">Barangay ID</option>
                                        <option value="Community Tax Return (Cedula)">Community Tax Return (Cedula)</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Valid ID Type</label>
                                    <select name="valid_id_type" class="form-control" required>
                                        <option value="School ID">School ID</option>
                                        <option value="Barangay ID">Barangay ID</option>
                                        <option value="Voter's ID">Voter's ID</option>
                                        <option value="Senior Citizen ID">Senior Citizen ID</option>
                                        <option value="PWD ID">PWD ID</option>
                                        <option value="PhilHealth ID">PhilHealth ID</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driver's License">Driver's License</option>
                                        <option value="SSS Card">SSS Card</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Upload Valid ID (Front)</label>
                                    <input type="file" name="valid_id_front" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Upload Valid ID (Back)</label>
                                    <input type="file" name="valid_id_back" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="form-control" required>
                                        <option value="Cash on Delivery">Cash on Delivery (COD)</option>
                                        <option value="On Pick-up">On Pick-up</option>
                                        <option value="Gcash">Gcash</option>
                                        <option value="Paymaya">Paymaya</option>
                                        <option value="Credit Card">Credit Card</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Service Method</label>
                                    <select name="service_method" class="form-control" required>
                                        <option value="Delivery">Delivery</option>
                                        <option value="Pick-up">Pick-up</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Date of Request</label>
                                    <input type="date" name="date_of_request" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Fee (in PHP)</label>
                                    <input type="number" name="fee" class="form-control" step="0.01" required>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="text-center mt-0">
                        <a href="dashboard.php" class="btn btn-secondary">Go Back</a>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
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
