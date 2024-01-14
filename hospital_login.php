<?php
require_once('db.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST['email']);
    $password = test_input($_POST['pass']);
    $sqlcheck = "SELECT * FROM hospital WHERE email='" . $email . "';";
    $result = mysqli_query($conn, $sqlcheck);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    if ($user == NULL) {
        $noUserErr = "NO USER REGISTERED WITH THIS EMAIL-ID";
    } else if ($password != $user['password']) {
        $passErr = "ENTERED PASSWORD DOES NOT MATCH OUR RECORDS";
    } else {
        header("Location: hospital_portal.php?H_id=" . $user['H_id']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&amp;display=swap" rel="stylesheet">
    <title>HOSPITAL LOGIN</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="login">
            <h2 class="pgHeading"><i class="fas fa-sign-in-alt"></i>&nbsp;LOGIN TO HOSPITAL PORTAL</h2>
            <h3 class="err"><?php echo $noUserErr;
                            echo $passErr; ?></h3>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="email">Enter Registered EMAIL-ID :- </label>
                <input type="email" name="email" class="input" required>
                <label for="pass">Enter Password :-</label>
                <input type="password" name="pass" class="input" required>
                <input type="submit" value="LOGIN" class="submit">
                <div class="btn-float">
                    <button><a href="verify_hospital.php">Forgot Password ?</a></button>
                    <button><a href="register_new_hospital.php">New User ? Register</a></button>
                </div>
                <h3 class="msg">To All Health Care Heroes <i class="fas fa-heartbeat"></i><br> THANK YOU FRONTLINERS !</h3>
            </form>
        </div>
    </div>
</body>

</html>