<?php
require_once('db.php');
require_once('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST['email']);
    $password = test_input($_POST['pass']);
    $sqlcheck = "SELECT * FROM patient WHERE email='" . $email . "';";
    $result = mysqli_query($conn, $sqlcheck);
    $patient = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    if ($patient == NULL) {
        $noUserErr = "NO USER REGISTERED WITH THIS EMAIL-ID";
    } else if ($password != $patient['password']) {
        $passErr = "ENTERED PASSWORD DOES NOT MATCH OUR RECORDS";
    } else {
        header("Location: user_portal.php?P_id=" . $patient['P_id']);
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
    <title>USER LOGIN</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="login">
            <h2 class="pgHeading"><i class="fas fa-sign-in-alt"></i>&nbsp;LOGIN TO USER PORTAL</h2>
            <h3 class="err"><?php echo $noUserErr;
                            echo $passErr; ?></h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="email">Enter Registered EMAIL-ID :- </label>
                <input type="email" name="email" class="input" required>
                <label for="pass">Enter Password :-</label>
                <br>
                <input type="password" name="pass" class="input" required>
                <input type="submit" value="LOGIN" class="submit">
                <div class="btn-float">
                    <button><a href="verify_user.php">Forgot Password ?</a></button>
                    <button><a href="register_new_user.php">New User ? Register</a></button>
                </div>
                <h3 class="msg">India Is Running The <i class="fas fa-chart-line"></i><br> World’s Largest Vaccination Drive <br> GET VACCINATED TODAY !</h3>
            </form>
        </div>
    </div>
</body>

</html>