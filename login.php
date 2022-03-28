<?php

//include db
include('config/db.php');

$username = $password = "";
$errors = array('username' => "", 'password' => "");

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // create sql
    $sql = "SELECT * FROM users WHERE username = '$username'";

    // make a query
    $result = mysqli_query($connection, $sql);

    // fetch all the data and store as a array
    $user_details = mysqli_fetch_assoc($result);

    if ($user_details) {
        $hashed_password = $user_details['password'];
        if (password_verify($password, $hashed_password)) {
            echo "<script>alert('Login Successfully')
            window.location.replace('index.php');</script>";
        } else {
            $errors['password'] = "Password does not matched";
        }
    } else {
        $errors['username'] = "User not exists";
    }

    // close the connection
    mysqli_close($connection);
}

?>


<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php") ?>
<section id="login">
    <form class="login-form" method="POST">
        <div class="login-title mb-5">
            Sign Up
        </div>
        <div class="form-group row mb-4">
            <label class="col-md-6">Username:</label>
            <input type="text" class="form-control col-md-6" placeholder="Enter username" value="<?php echo $username ?>" name="username">
            <small class="form-text login-error text-white col-md-6 ml-auto mt-0"><?php echo $errors['username'] ?></small>
        </div>
        <div class="form-group row mb-5">
            <label class="col-md-6">Password:</label>
            <input type="password" class="form-control col-md-6" placeholder="Enter password" value="<?php echo $password ?>" name="password">
            <small class="form-text login-error text-white col-md-6 ml-auto mt-0"><?php echo $errors['password'] ?></small>
        </div>
        <button type="submit" name="submit" class="btn btn-dark btn-lg">Login</button>
    </form>
</section>
<?php include("templates/footer.php") ?>

</body>

</html>