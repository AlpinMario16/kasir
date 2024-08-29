<?php

function update($data){
    global $koneksi;

    $curPass = trim(mysqli_real_escape_string($koneksi, $data['curPass']));
    $newPass = trim(mysqli_real_escape_string($koneksi, $data['newPass']));
    $confPass = trim(mysqli_real_escape_string($koneksi, $data['confPass']));
    $userActive = userLogin()['username'];
    $storedPassword = userLogin()['password'];

    // Validate if the new password and confirmation password match
    if ($newPass !== $confPass) {
        echo "<script>
            alert('Konfirmasi password tidak cocok dengan password baru.');
            document.location='?msg=err1';
        </script>";
        exit;
    }

    // Validate the current password
    if (!password_verify($curPass, $storedPassword)) {
        echo "<script>
            alert('Password saat ini tidak benar.');
            document.location='?msg=err2';
        </script>";
        exit;
    } 

    // Update password using prepared statement
    $newHashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    $stmt = $koneksi->prepare("UPDATE tbl_user SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $newHashedPass, $userActive);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true; // Password update was successful
    } else {
        return false; // Password update failed
    }

    $stmt->close();
}
