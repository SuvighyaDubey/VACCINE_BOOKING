<?php
require_once('db.php');
require_once('functions.php');
if (!isset($_GET['P_id'])) {
    header("Location: verify_user.php");
}
$P_id = $_GET['P_id'];
$sql = "SELECT * FROM patient WHERE P_id='" . $P_id . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
mysqli_free_result($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = test_input($_POST["pass"]);
    $repassword = test_input($_POST["repass"]);

    if ($password != $repassword) {
        $pass = -1;
        $passMatchErr = "PASSWORDS DO NOT MATCH";
    } else {
        $sqlUpPass = "UPDATE patient set password='" . $password . "' WHERE P_id='" . $P_id . "' ;";
        if (mysqli_query($conn, $sqlUpPass)) {
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
    <style>
        .success{
            top: 70%;
        }
    </style>
    <title>RESET PASSWORD</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="verified">
            <h2 class="tablediv">SUCCESSFULLY VERIFIED YOUR DETAILS AS:</h2>
            <table>
                <tbody>
                    <tr>
                        <td>Full Name</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['name'] ?></td>
                    </tr>
                    <tr>
                        <td>DOB [YYYY-MM-DD]</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['dob'] ?></td>
                    </tr>
                    <tr>
                        <td>Government ID No.</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['idno'] ?></td>
                    </tr>
                    <tr>
                        <td>Registered EMAIL-ID</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['email'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pgBody <?php if ($success == 1) {
                                echo "dnone";
                            } ?>">
            <div class="login">
                <h2 class="pgHeading"><i class="fas fa-key"></i>&nbsp;CREATE NEW LOGIN PASSSWORD</h2>
                <h3 class="err"><?php echo $passMatchErr; ?></h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?P_id=" . $P_id); ?>" method="post">
                    <label for="pass">CREATE NEW PASSWORD</label>
                    <input type="password" name="pass" required>
                    <label for="repass">RETYPE PASSWORD</label>
                    <input type="password" name="repass" required>
                    <input type="submit" value="RESET PASSWORD" class="submit">
                </form>
            </div>
        </div>
    </div>
    <?php if ($success == 1) { ?>
        <div class="success">
            <h3>SUCCESSFULLY CHANGED PASSWORD</h3>
            <a href="user_login.php">
                <button>CONTINUE TO LOGIN</button>
            </a>
        </div>
    <?php } ?>
</body>

</html>