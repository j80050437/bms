<?php
// Check if the message was sent successfully
$message_sent = false; // Initialize the variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your existing code to handle form submission
    include 'db.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $message_sent = true; // Set to true if message sent successfully
    } else {
        // Handle error if needed
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include 'header.php'; ?>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Message Sent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Message sent successfully.
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
            <td class="p-5" style="background-color: rgba(255, 255, 255, 0.8); max-width: 400px; margin: auto;">
                <h2 class="display-4 text-center">Contact Us</h2>
                <form action="contactus.php" method="POST">
                    <table class="table" style="max-width: 300px; margin: auto;">
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <button type="submit" class="btn" style="background-color: blue; color: white;">Send</button>
                            </td>
                        </tr>
                    </table>
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
        <?php if ($message_sent): ?>
            $('#successModal').modal('show');
        <?php endif; ?>
    });
</script>
