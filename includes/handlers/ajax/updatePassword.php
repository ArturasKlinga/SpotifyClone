<?php
    include("../../config.php");
    if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
        echo "Please fill in all fields";
        exit();
    }
    $username = $_POST['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    $query = mysqli_query($con, "SELECT password FROM users WHERE username='$username'");
    $queryResult = mysqli_fetch_array($query);
    if (!password_verify($oldPassword, $queryResult['password'])) {
        echo "Password is incorrect";
        exit();
    }
    if ($newPassword1 != $newPassword2) {
        echo "Your new passwords do not match";
        exit();
    }
    if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
        echo "Your password must only contain letters and/or numbers";
        exit();
    }
    if (strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
        echo "Your password must be between 5 and 30 characters";
        exit();
    }
    $newHash = password_hash($newPassword1, PASSWORD_DEFAULT);
    $query = mysqli_query($con, "UPDATE users SET password='$newHash' WHERE username='$username'");
    echo "Update successful";
?>