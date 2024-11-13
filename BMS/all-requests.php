<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT purpose, document_type, date_of_request, status FROM requests WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($purpose, $document_type, $date_of_request, $status);
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center; height: 80vh;">
        <tr>
            <td class="p-4" style="background-color: rgba(255, 255, 255, 0.8);">
                <h2 class="display-4 text-center">All Requests</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Purpose</th>
                            <th>Document Type</th>
                            <th>Date of Request</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($stmt->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($purpose); ?></td>
                            <td><?php echo htmlspecialchars($document_type); ?></td>
                            <td><?php echo htmlspecialchars($date_of_request); ?></td>
                            <td><?php echo htmlspecialchars($status); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="text-center mt-4">
                    <a href="dashboard.php" class="btn btn-secondary">Go Back to Dashboard</a>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>

<!-- Add jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
