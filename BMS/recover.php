<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $backup_file = $_POST['backup_file'];
    
    // Database recovery logic
    $command = "mysql --user=root --password= --host=localhost bmms < backups/$backup_file";
    system($command);
    
    echo "Database successfully restored!";
}
?>

<?php include 'header.php'; ?>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Database successfully restored!
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
            <td class="p-4" style="background-color: rgba(255, 255, 255, 0.8); max-width: 400px; margin: auto;">
                <h2 class="display-4 text-center">Recover Database</h2>
                <form method="POST">
                    <table class="table" style="max-width: 300px; margin: auto;">
                        <tr>
                            <td class="text-left">
                                <div class="form-group">
                                    <label>Select Backup File</label>
                                    <select name="backup_file" class="form-control" style="width: 100%;">
                                        <?php
                                        $files = glob('backups/*.sql');
                                        foreach ($files as $file) {
                                            $filename = basename($file);
                                            echo "<option value='$filename'>$filename</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="text-center mt-0">
                        <a href="admin.php" class="btn btn-secondary me-2">Go Back</a>
                        <button type="submit" class="btn" style="background-color: green; color: white;">Recover</button>
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
        <?php if (isset($backup_file)): ?>
            $('#successModal').modal('show');
        <?php endif; ?>
    });
</script>
