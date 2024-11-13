<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}

// Database backup logic
$backup_file = 'backups/bmms_backup_' . date("Y-m-d_H-i-s") . '.sql';
$command = "mysqldump --user=root --password= --host=localhost bmms > $backup_file";

system($command);
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <table class="table table-bordered text-center" style="background-image: url('img/bg.jpg'); background-size: cover; background-position: center; height: 80vh;">
        <tr>
            <td class="p-5" style="background-color: rgba(255, 255, 255, 0.8);">
                <h1 class="display-3">Backup Successful!</h1>
                <p class="lead">Your database has been successfully backed up.</p>
                <a href="admin.php" class="btn btn-primary btn-lg">Go Back to Admin Dashboard</a>
            </td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>
