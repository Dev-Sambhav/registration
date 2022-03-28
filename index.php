<?php
$indianStates = [
    'AP' => 'Andhra Pradesh',
    'AR' => 'Arunachal Pradesh',
    'AS' => 'Assam',
    'BR' => 'Bihar',
    'CT' => 'Chhattisgarh',
    'GA' => 'Goa',
    'GJ' => 'Gujarat',
    'HR' => 'Haryana',
    'HP' => 'Himachal Pradesh',
    'JK' => 'Jammu and Kashmir',
    'JH' => 'Jharkhand',
    'KA' => 'Karnataka',
    'KL' => 'Kerala',
    'MP' => 'Madhya Pradesh',
    'MH' => 'Maharashtra',
    'MN' => 'Manipur',
    'ML' => 'Meghalaya',
    'MZ' => 'Mizoram',
    'NL' => 'Nagaland',
    'OR' => 'Odisha',
    'PB' => 'Punjab',
    'RJ' => 'Rajasthan',
    'SK' => 'Sikkim',
    'TN' => 'Tamil Nadu',
    'TG' => 'Telangana',
    'TR' => 'Tripura',
    'UP' => 'Uttar Pradesh',
    'UT' => 'Uttarakhand',
    'WB' => 'West Bengal',
    'AN' => 'Andaman and Nicobar Islands',
    'CH' => 'Chandigarh',
    'DN' => 'Dadra and Nagar Haveli',
    'DD' => 'Daman and Diu',
    'LD' => 'Lakshadweep',
    'DL' => 'National Capital Territory of Delhi',
    'PY' => 'Puducherry'
];

//include db
include('config/db.php');

$username = $password = $email = $mobile = $pan = $city = $zip = '';
$errors = array('username' => "", 'password' => "", 'email' => "", 'mobile' => "", 'pan' => "", 'city' => "", 'zip' => "");

if (isset($_POST['submit'])) {
    // check username
    if (empty($_POST['username'])) {
        $errors['username'] = "Please enter your username";
    } else {
        $username = htmlspecialchars($_POST['username']);
        if (!preg_match('/^[A-Za-z0-9]{5,31}$/', $username)) {
            $errors['username'] = "Invalid username format";
        }
    }
    // check password
    if (empty($_POST['password'])) {
        $errors['password'] = "Please enter password";
    } else {
        $password = $_POST['password'];
        if (!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password)) {
            $errors['password'] = "Provide a strong password";
        }
    }

    // check email
    if (empty($_POST['email'])) {
        $errors['email'] = "Please enter email";
    } else {
        $email = $_POST['email'];
    }

    // check mobile
    if (empty($_POST['mobile'])) {
        $errors['mobile'] = "Please enter mobile number";
    } else {
        $mobile = htmlspecialchars($_POST['mobile']);
        if (!preg_match('/^[0-9]{10}$/', $mobile)) {
            $errors['mobile'] = "Invalid phone number";
        }
    }

    // check pan
    if (empty($_POST['pan'])) {
        $errors['pan'] = "Please enter pan number";
    } else {
        $pan = htmlspecialchars($_POST['pan']);
        if (!preg_match('/^[0-9A-Za-z]{10}$/', $pan)) {
            $errors['pan'] = "Invalid pan number";
        }
    }

    // check city
    if (empty($_POST['city'])) {
        $errors['city'] = "Please enter city name";
    } else {
        $city = htmlspecialchars($_POST['city']);
        if (!preg_match('/^[a-zA-Z]+$/', $city)) {
            $errors['city'] = "Invalid city name";
        }
    }

    // check zip
    if (empty($_POST['zip'])) {
        $errors['zip'] = "Please enter zip code";
    } else {
        $zip = htmlspecialchars($_POST['zip']);
        if (!preg_match('/^[0-9]{6}$/', $zip)) {
            $errors['zip'] = "Invalid zip code";
        }
    }

    // Redirect to the User if there is no errors and saving data into database
    if (!array_filter($errors)) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
        $pan = mysqli_real_escape_string($connection, $_POST['pan']);
        $city = mysqli_real_escape_string($connection, $_POST['city']);
        $state = mysqli_real_escape_string($connection, $_POST['state']);
        $zip = mysqli_real_escape_string($connection, $_POST['zip']);

        // hashing password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // create sql
        $sql = "INSERT INTO users(username,password,email,mobile,pan,city,state,zip) VALUES ('$username','$hashed_password','$email','$mobile','$pan','$city','$state','$zip')";

        // check and save data into db
        if (mysqli_query($connection, $sql)) {
            //success
            header("Location: login.php");
        } else {
            //error
            echo "Could not save your data: " . mysqli_error($connection);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php") ?>

<section id="register">
    <form method="POST">
        <div class="form-title">
            Sign Up
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Username:</label>
                <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                <small class="form-text text-white"><?php echo $errors['username'] ?></small>
            </div>
            <div class="form-group col-md-6">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" value="<?php echo $password ?>">
                <small class="form-text text-white"><?php echo $errors['password'] ?></small>
            </div>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" placeholder="e.g sam@gmail.com" name="email" value="<?php echo $email ?>">
            <small class="form-text text-white"><?php echo $errors['email'] ?></small>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Mobile:</label>
                <input type="text" class="form-control" name="mobile" value="<?php echo $mobile ?>">
                <small class="form-text text-white"><?php echo $errors['mobile'] ?></small>
            </div>
            <div class="form-group col-md-6">
                <label>PAN:</label>
                <input type="text" class="form-control" name="pan" value="<?php echo $pan ?>">
                <small class="form-text text-white"><?php echo $errors['pan'] ?></small>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>City</label>
                <input type="text" class="form-control" name="city" value="<?php echo $city ?>">
                <small class="form-text text-white"><?php echo $errors['city'] ?></small>
            </div>
            <div class="form-group col-md-3">
                <label for="inputState">State</label>
                <select id="inputState" name="state" class="form-control" required>
                    <option value="" selected>Choose...</option>
                    <?php foreach ($indianStates as $indianState) : ?>
                        <option><?php echo htmlspecialchars($indianState) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Zip</label>
                <input type="text" class="form-control" name="zip" value="<?php echo $zip ?>">
                <small class="form-text text-white"><?php echo $errors['zip'] ?></small>
            </div>
        </div>
        <div class="button-flex">
            <button type="submit" name="submit" class="btn btn-secondary btn-lg">Sign in</button>
            <small class="text-white mr-5 mt-2">Already an account? <a class="font-weight-bold ml-2 text-body" href="login.php">Login</a></small>
        </div>
    </form>
</section>


<!-- <?php include("templates/footer.php") ?> -->

</html>