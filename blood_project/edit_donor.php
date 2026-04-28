<?php 
include 'db.php'; 

// 1. Get the Donor's current data
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM donors WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
}

// 2. Update the data when the form is submitted
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $bg = $_POST['blood_group'];
    $phone = $_POST['phone'];
    $id = $_POST['id'];

    $sql = "UPDATE donors SET name='$name', blood_group='$bg', phone='$phone' WHERE id=$id";
    
    if(mysqli_query($conn, $sql)){
        header("Location: view_donors.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Donor</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0px 10px 25px rgba(0,0,0,0.1); width: 350px; }
        h2 { color: #d9534f; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .update-btn { background-color: #5cb85c; color: white; border: none; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Donor Info</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        <input type="text" name="blood_group" value="<?php echo $row['blood_group']; ?>" required>
        <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required>
        <input type="submit" name="update" value="Save Changes" class="update-btn">
    </form>
    <a href="view_donors.php" style="display:block; text-align:center; margin-top:10px; color:#666; text-decoration:none;">Cancel</a>
</div>
</body>
</html>