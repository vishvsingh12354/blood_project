<?php
include 'db.php';
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // Update status to Approved
    mysqli_query($conn, "UPDATE requests SET status='Approved' WHERE request_id=$id");
    header("Location: view_request.php?msg=Request Approved");
}
?>