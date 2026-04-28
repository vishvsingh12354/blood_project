<?php
include 'db.php';

// Check if an ID was sent in the URL
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // SQL to delete the record with that specific ID
    $sql = "DELETE FROM donors WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        // Redirect back to the view page after deleting
        header("Location: view_donors.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>