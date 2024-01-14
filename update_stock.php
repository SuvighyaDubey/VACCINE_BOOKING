<?php
require_once('db.php');

if (!isset($_GET['H_id'])) {
    header("Location: hospital_login.php");
}
$H_id = $_GET['H_id'];
$sql = "SELECT * FROM hospital WHERE H_id='" . $H_id . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
$hospital = mysqli_fetch_assoc($result);
mysqli_free_result($result);

$sqlall = "SELECT * FROM stock WHERE H_id=" . $H_id;
$result1 = mysqli_query($conn, $sqlall);
$all_stock = mysqli_fetch_assoc($result1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = $_POST['count'];
    $type = $_POST['type'];

    $sqlcheck = "SELECT * FROM stock WHERE (H_id='" . $H_id . "') AND (type='" . $type . "');";
    $result2 = mysqli_query($conn, $sqlcheck);
    $saved_hospital = mysqli_fetch_assoc($result2);
    mysqli_free_result($result2);

    if ($saved_hospital != NULL) {
        $sqlupdate = "UPDATE stock SET count='" . $count + $saved_hospital['count'] . "' WHERE (H_id='" . $H_id . "') AND (type='" . $type . "');";
        if (mysqli_query($conn, $sqlupdate)) {
            $success = 1;
        }
    } else {
        $sqlnew = "INSERT into stock(H_id,count,type) values ('";
        $sqlnew .= $H_id . "','" . $count . "','" . $type . "');";
        if (mysqli_query($conn, $sqlnew)) {
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
    <title><?php echo $hospital['name']; ?></title>
    <style>
        form {
            padding: 1rem;
            display: flex;
            justify-content: space-evenly;
        }

        span {
            flex: 1;
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
                <h1><i class="fas fa-hospital-user"></i>&nbsp;Welcome <b><?php echo $hospital['name']; ?></b></h1>
            </span>
            <span><a href="hospital_portal.php?H_id=<?php echo $H_id; ?>"><button><i class="fas fa-backward"></i>&nbsp; Return Back To Portal</button></a></span>
        </div>
        <hr>
        <h3><i class="fas fa-box-open"></i>&nbsp;ADD NEW STOCK</h3>
        <div class="update">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?H_id=" . $H_id); ?>" method="post">
                <span><label for="count">ENTER NO. OF VACCINES TO BE ADDED</label>
                    <input type="number" name="count" placeholder="0"></span>
                <span><label for="type">SELECT TYPE OF VACCINE</label>
                    <select name="type">
                        <option value="Covishield">Covishield</option>
                        <option value="Covaxin">Covaxin</option>
                        <option value="Pfizer">Pfizer</option>
                        <option value="SPUTNIK">SPUTNIK</option>
                    </select></span>
                <span><input type="submit" value="UPDATE STOCK" class="submit"></span>
            </form>
        </div>
        <hr>
        <?php if ($all_stock != NULL) { ?>
            <h3><i class="fas fa-box-open"></i>&nbsp;CURRENT STOCK</h3>
            <div class="tablediv">
                <table>
                    <thead>
                        <td>Vaccine Type</td>
                        <td></td>
                        <td>Shots Left</td>
                    </thead>
                    <tbody>
                        <?php do { ?>
                            <tr>
                                <td><?php echo $all_stock['type'] ?></td>
                                <td><i class="fas fa-arrow-right"></i></td>
                                <td><?php echo $all_stock['count'] ?></td>
                            </tr>
                        <?php } while ($all_stock = mysqli_fetch_assoc($result1)); ?>
                    </tbody>
                </table>
            </div>
        <?php mysqli_free_result($result1);
        } else {
            echo "<h2 class='err'>Nothing in Stock</h2>";
        } ?>
    </div>
    <?php if ($success == 1) { ?>
        <div class="success">
            <h2>SUCCESSFULLY UPDATED VACCINE STOCK</h2>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?H_id=" . $H_id); ?>">
                <button>CONTINUE</button>
            </a>
        </div>
    <?php } ?>



</body>

</html>