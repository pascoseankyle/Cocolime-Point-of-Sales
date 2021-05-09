<?php
 include "../includes/database.php"; // Database !!
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../styles/styles.css">
        <link rel="stylesheet" href="../styles/fontawesome/css/all.css">
    </head>
<?php
    session_start(); // Start Session
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM tbl_users WHERE user_username = '$username' AND user_password = '$password' ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1){ // Input results and database results
        $row = mysqli_fetch_assoc($result);
        if ($row['user_username'] === $username && $row['user_password'] === $password){
            $_SESSION['user_username'] = $row['user_username'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];
            setcookie("name", "{$row['user_name']}", time() + 86400);
            header("Location: index.php");
        }
    }
    else {
?>
   <body>
        <div class='div-container'>
            <div class='div-no-user'>
                <i class='fas fa-times-circle' style='color:red'></i>&nbspNo user Found!
                <br><br>
                <button onclick='back()' style='width: 200px'>back</button>
            </div>
        </div>
   </body>
<?php 
    }
?>
</html>
<script>
    function back(){
        location.replace("login.php");
    }
</script>