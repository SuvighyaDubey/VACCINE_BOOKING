<?php
require_once('db.php');
if (!isset($_GET['P_id']) || !isset($_GET['dose'])) {
    header("Location: user_login.php");
}
$P_id = $_GET['P_id'];
$dose = $_GET['dose'];

if ($dose == 2) {
    $sqld1 = "SELECT * from vaccinated WHERE P_id='" . $P_id . "'LIMIT 1";
    $result1 = mysqli_query($conn, $sqld1);
    $d1 = mysqli_fetch_assoc($result1);
    mysqli_free_result($result1);
}

$sql = "SELECT * FROM patient WHERE P_id='" . $P_id . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
mysqli_free_result($result);

$sqlgetstock = "SELECT * FROM stock , hospital WHERE stock.H_ID = hospital.H_id ;";
$avail = mysqli_query($conn, $sqlgetstock);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $option = $_POST['choose'];

    $sqlupstock = "UPDATE stock set count=count-1 WHERE S_id='" . $option . "' ;";
    $sqlgetstock = "SELECT * from stock where S_id='" . $option . "' ;";
    $result2 = mysqli_query($conn, $sqlgetstock);
    $stockdetail = mysqli_fetch_assoc($result2);
    mysqli_free_result($result2);

    if ($stockdetail['count'] == 0) {
        $stockErr = "<h2 class='err'>Sorry, Out of Stock</h2>";
    } else if ($dose == 2 && ($stockdetail['type'] != $d1['type'])) {
        $MatchErr = "<h2 class='err'>Please Select Vaccine Type Corresponding to you DOSE 1 type</h2>";
    } else {
        $sqlupdatevaccinated = "INSERT INTO vaccinated(type,P_id,H_id,dose) values('";
        $sqlupdatevaccinated .= $stockdetail['type'] . "','" . $P_id . "','" . $stockdetail['H_id'] . "','" . $dose . "');";
        if (mysqli_query($conn, $sqlupstock) && mysqli_query($conn, $sqlupdatevaccinated)) {
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
    <link rel="stylesheet" href="./css/portal.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&amp;display=swap" rel="stylesheet">
    <title><?php echo $user['name']; ?></title>
    <style>
        form {
            all: none;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="username">COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="welcomeBar">
            <span>
                <h1><i class="fas fa-user"></i>&nbsp;Welcome <b><?php echo $user['name']; ?></b></h1>
                <h2>BOOK YOUR VACCINATION DOSE</h2>
            </span>
        </div>
        <?php echo $MatchErr;
        echo $stockErr; ?>
        <form action="" method="post">
            <div class="tablediv">
                <table border='solid'>
                    <thead>
                        <td>HOSPITAL NAME</td>
                        <td>TYPE</td>
                        <td>AVAILABLE</td>
                        <td>CHOOSE</td>
                    </thead>
                    <tbody>
                        <?php while ($stock = mysqli_fetch_assoc($avail)) { ?>
                            <tr>
                                <td><?php echo $stock['name']; ?></td>
                                <td><?php echo $stock['type']; ?></td>
                                <td><?php echo $stock['count']; ?></td>
                                <td><input type="radio" name='choose' value="<?php echo $stock['S_id'] ?>"></td>
                            </tr>
                        <?php }
                        mysqli_free_result($avail);
                        ?>
                    </tbody>
                </table>
                <input type="submit" value="BOOK NOW" class="submit">
        </form>
    </div>
    </div>
    <?php if ($success == 1) { ?>
        <div class="success">
            <h3>SUCCESSFULLY BOOKED SLOT</h3>
            <a href="user_portal.php?P_id=<?php echo $P_id ?>">
                <button>CONTINUE</button>
            </a>
        </div>
    <?php } ?>
</body>

</html>