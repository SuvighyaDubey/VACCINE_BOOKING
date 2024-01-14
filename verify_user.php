<?php
require_once('db.php');
require_once('functions.php');
$pass = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $idno = test_input($_POST["idno"]);
    $dob = test_input($_POST["dob"]);

    $sqlcheck = "SELECT * FROM patient WHERE email='" . $email . "' AND dob='" . $dob . "' AND idno='" . $idno . "';";
    $result = mysqli_query($conn, $sqlcheck);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if ($user == NULL) {
        $userPresentErr = "NO SUCH USER EXISTS WITH THESE DETAILS";
    } else {
        header("Location: change_user_password.php?P_id=" . $user['P_id']);
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
    <title>VERIFY USER</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="login">
            <h2 class="pgHeading"><i class="fas fa-key"></i>&nbsp;RESET USER Login PASSWORD PORTAL</h2>
            <h3 class="err"><?php echo $userPresentErr; ?></h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2>Verify with your registered details</h2>
                <hr>
                <label for="email">Enter Registered EMAIL-ID</label>
                <input type="email" name="email" required>
                <label for="dob">Enter DATE OF BIRTH </label>
                <input type="date" name="dob" required>
                <label for="idno">Enter Government ID no.</label>
                <input type="text" name="idno" required>
                <br>
                <input type="submit" value="CONTINUE TO CHANGE PASSWORD" class="submit">
            </form>
        </div>
    </div>
</body>

</html>