<?php
require_once('db.php');
require_once('functions.php');
$pass = 0;
$email = test_input($_POST["email"]);
$password = test_input($_POST["pass"]);
$repassword = test_input($_POST["repass"]);
$name = test_input($_POST["name"]);
$idno = test_input($_POST["idno"]);
$verify = $_POST['verify'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sqlcheck = "SELECT * FROM hospital WHERE email='" . $email . "' OR idno='" . $idno . "';";
    $result = mysqli_query($conn, $sqlcheck);
    $repeat = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if ($verify != 1) {
        $pass = -1;
        $tickErr = "PLEASE TICK THE CHECKBOX TO CONTINUE";
    } else if ($password != $repassword) {
        $pass = -1;
        $passMatchErr = "PASSWORDS DO NOT MATCH";
    } else if ($repeat != NULL) {
        $pass = -1;
        $userPresentErr = "USER ALREADY CREATED FOR THIS ID No. OR EMAIL";
    } else {
        $sqlinsert = "INSERT INTO hospital (email,password,name,idno) VALUES ('";
        $sqlinsert .= $email . "','" . $password . "','" . $name . "','" . $idno . "');";
        if (mysqli_query($conn, $sqlinsert)) {
            $success = 1;
        }
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
    <title>REGISTER NEW HOSPITAL</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>

        <div class="login">
            <h2 class="pgHeading"><i class="fas fa-hospital-user"></i>&nbsp;WELCOME TO REGISTER NEW HOSPITAL PORTAL</h2>
            <h3 class="err"><?php if ($pass == -1) {
                                echo $passMatchErr;
                                echo $ageLessErr;
                                echo $userPresentErr;
                                echo $tickErr;
                            }
                            ?></h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="<?php if ($success == 1) {
                                                                                            echo "dnone";
                                                                                        } ?>" method="post">
                <label for="email">Enter Email-ID: </label>
                <input type="email" name="email" required>

                <label for="password">Create Password: </label>
                <input type="password" name="pass" required>

                <label for="repassword">Confirm Password: </label>
                <input type="password" name="repass" required>

                <label for="name">Enter Full Name of The Hospital: </label>
                <input type="text" name="name" required>

                <label for="idno">Enter Hospital Registered Govt. ID No.: </label>
                <input type="text" name="idno" required>

                <span>
                    <input type="checkbox" name="verify" value="1">&nbsp;
                    <label for="verify">Details provided are true to best of my belief </label>
                </span>

                <input type="submit" value="CONFIRM AND REGISTER" class="submit">
            </form>
        </div>
    </div>
    <?php if ($success == 1) { ?>
        <div class="success">
            <h2>SUCCESSFULLY REGISTERED ON THE PORTAL</h2>
            <a href="hospital_login.php" class="href">
                <button>CONTINUE TO LOGIN PAGE</button>
            </a>
        </div>
    <?php } ?>
</body>

</html>