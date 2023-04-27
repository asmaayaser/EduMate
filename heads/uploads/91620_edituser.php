<?php
require('config.php');

?>
<!DOCTYPE html>
<html lang="en">

<?php

$edit_id = $_GET['editid'];


$query = "select * from users where id = $edit_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$name = $row['name'];
$email = $row['email'];
$password = $row['password'];
$type = $row['type'];

if (isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_pass = $_POST['user_pass'];
    $user_type = $_POST['user_type'];




    $update = "UPDATE `users` SET name='$user_name' , email='$user_email' , password='$user_pass' ,  type='$user_type' WHERE id='$user_id'  ";
    // mysqli_query($conn, $update);
    if (mysqli_query($conn, $update)) {
        header("Location: dashboard_users.php");
    }
}


?>

<head>
    <link rel="stylesheet" href="./css/userEditition.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
</head>

<body>
    <div class="back">
        <div class="container">
            <?php if (isset($_GET['editid'])) : ?>
                <div class="login-box">
                    <p>Edit User's Info</p>
                    <!-- <form method="post" action="dashboard_users.php" enctype="multipart/form-data"> -->
                    <form method="post">

                        <div class="user-box">
                            <input required="" name="user_id" type="text" value="<?php echo $id; ?>" readonly>
                            <label>User ID</label>
                        </div>
                        <div class="user-box">
                            <input required="" name="user_name" type="text" value="<?php echo $name; ?>">
                            <label>Name</label>
                        </div>
                        <div class="user-box">
                            <textarea name="user_email" required=""><?php echo $email; ?></textarea>
                            <label>Email</label>
                        </div>
                        <div class="user-box">
                            <input required="" name="user_pass" type="text" value="<?php echo $password; ?>">
                            <label>Password</label>
                        </div>
                        <div class="user-box">
                            <input required="" name="user_type" type="text" value="<?php echo $type; ?>">
                            <label>Type</label>
                        </div>


                        <button name="edit_user" type="submit" style="cursor:pointer" class="animatedBtn"><span></span>
                            <span></span>
                            <span></span>
                            <span></span> Edit User</button>

                    </form>

                </div>
            <?php else : ?>
                <div class="login-box">
                    <p>Please select a book first</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>


</html>