<?php
require_once('db.php');
require_once('functions.php');

if (!isset($_GET['H_id'])) {
    header("Location: hospital_login.php");
}
$H_id = $_GET['H_id'];


$sql = "SELECT * FROM hospital WHERE H_id='" . $H_id . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
$hospital = mysqli_fetch_assoc($result);
mysqli_free_result($result);

$sqlbooked = "SELECT * from vaccinated natural JOIN patient WHERE vaccinated.H_id='" . $H_id . "' AND vaccinated.date is NULL ;";
$scheduled = mysqli_query($conn, $sqlbooked);
$patient = mysqli_fetch_assoc($scheduled);

$sqlCount = "SELECT count(*) as tot from vaccinated natural JOIN patient WHERE vaccinated.H_id='" . $H_id . "' AND vaccinated.date is NULL ;";
$resultCount = mysqli_query($conn, $sqlCount);
$count = mysqli_fetch_assoc($resultCount);
mysqli_free_result($resultCount);

$sqldone = "SELECT * from vaccinated natural JOIN patient WHERE vaccinated.H_id='" . $H_id . "' AND vaccinated.date is not NULL ORDER BY date desc;";
$vaccinated = mysqli_query($conn, $sqldone);
$done = mysqli_fetch_assoc($vaccinated);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['search']) {
        $semail = $_POST['semail'];
        $sqlget = "SELECT * from vaccinated natural JOIN patient WHERE vaccinated.H_id='" . $H_id . "' AND patient.email='" . $semail . "' AND vaccinated.date is not NULL;";
        $result2 = mysqli_query($conn, $sqlget);
        $searched = mysqli_fetch_assoc($result2);
        if ($searched['email'] == $semail) {
            $thereis1 = 1;
        } else {
            $noPresentErr1 = "<h2 class='err'> Sorry, couldn't find any such candidate </h2>";
        }
    } else if ($_POST['find']) {
        $gemail = $_POST['gemail'];
        $sqlfind = "SELECT * from vaccinated natural JOIN patient WHERE vaccinated.H_id='" . $H_id . "' AND patient.email='" . $gemail . "' AND vaccinated.date is NULL limit 1;";
        $result3 = mysqli_query($conn, $sqlfind);
        $gotten = mysqli_fetch_assoc($result3);
        if ($gotten['email'] == $gemail) {
            $thereis2 = 1;
        } else {
            $noPresentErr2 = "<h2 class='err'> Sorry, couldn't find any such candidate </h2>";
        }
        mysqli_free_result($result3);
    } else {
        $V_id = $_POST['verified'];
        if (!isset($V_id)) {
            $verErr = "Please verify the candidates details before vaccinating";
        } else {
            $currdate = date("Y-m-d");
            $sqlStatus = "UPDATE vaccinated set date='" . $currdate . "' WHERE V_id='" . $V_id . "' ;";
            if (mysqli_query($conn, $sqlStatus)) {
                $success = "Successfully updated vaccination records";
                header("Location: hospital_portal.php?H_id=" . $H_id);
            }
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
            <a href="update_stock.php?H_id=<?php echo $H_id; ?>"><button><i class="fas fa-box-open"></i>&nbsp; Update Vaccine Stock</button></a>
            <h3 class="err">Total No. of Candidates Scheduled for vaccination = <?php echo $count['tot'] ?></h3>
        </div>
        <hr>
        <h2>CANDIDATES SCHEDULED FOR VACCINATION</h2>
        <div class="search">
            <div class="search-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?H_id=" . $H_id); ?>" method="post">
                    <label for="email">Search in the list by Candidates email</label>
                    <input type="email" name="gemail" placeholder="ENTER CANDIDATES EMAIL TO SEARCH" required>
                    <input type="submit" class="submit" value="SEARCH" name="find">
                </form>
            </div>
            <div class="search-result tablediv">
                <?php if ($thereis2 == 1) { ?>
                    <table border='solid'>
                        <thead>
                            <td>E-MAIL</td>
                            <td>PATIENT NAME</td>
                            <td>DOB</td>
                            <td>GOVT ID NO</td>
                            <td>TYPE VACCINE</td>
                            <td>DOSE</td>
                            <td>VERIFIED</td>
                            <td>STATUS</td>
                        </thead>
                        <tbody>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?H_id=" . $H_id); ?>" method="post">
                                <tr>
                                    <td><?php echo $gotten['email'] ?></td>
                                    <td><?php echo $gotten['name'] ?></td>
                                    <td><?php echo $gotten['dob'] ?></td>
                                    <td><?php echo $gotten['idno'] ?></td>
                                    <td><?php echo $gotten['type'] ?></td>
                                    <td><?php echo $gotten['dose'] ?></td>
                                    <td><input type="checkbox" name="verified" value="<?php echo $gotten['V_id'] ?>" id=""></td>
                                    <td><input type="submit" class="submit" name="VACCINATED"></td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                <?php } else {
                    echo $noPresentErr2;
                } ?>
            </div>
        </div>
        <h2 class="err"><?php echo $verErr ?></h2>
        <div class="tablediv">
            <?php if ($patient != NULL) { ?>
                <table border='solid'>
                    <thead>

                        <td>E-MAIL</td>
                        <td>PATIENT NAME</td>
                        <td>DOB</td>
                        <td>GOVT ID NO</td>
                        <td>TYPE VACCINE</td>
                        <td>DOSE</td>
                        <td>VERIFIED</td>
                        <td>STATUS</td>

                    </thead>
                    <tbody>
                        <?php do { ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?H_id=" . $H_id); ?>" method="post">
                                <tr>
                                    <td><?php echo $patient['email'] ?></td>
                                    <td><?php echo $patient['name'] ?></td>
                                    <td><?php echo $patient['dob'] ?></td>
                                    <td><?php echo $patient['idno'] ?></td>
                                    <td><?php echo $patient['type'] ?></td>
                                    <td><?php echo $patient['dose'] ?></td>
                                    <td><input type="checkbox" name="verified" value="<?php echo $patient['V_id'] ?>" id=""></td>
                                    <td><input type="submit" class="submit" name="VACCINATED"></td>
                                </tr>
                            </form>
                        <?php } while ($patient = mysqli_fetch_assoc($scheduled)); ?>
                    </tbody>
                </table>
            <?php } else {
                echo "<h2 class='err'> No Candidate Scheduled for Vaccination</h2>";;
            } ?>
        </div>
        <hr>
        <h2>RECORD OF SUCCESSFULLY VACCINATIONED CANDIDATES</h2>
        <div class="search">
            <div class="search-form">
                <form <?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?H_id=" . $H_id); ?> method="post">
                    <label for="email">Search in the list by candidates email</label>
                    <input type="email" name="semail" placeholder="ENTER CANDIDATES EMAIL TO SEARCH" required>
                    <input type="submit" class="submit" value="SEARCH" name="search">
                </form>
            </div>
            <div class="search-result tablediv">
                <?php if ($thereis1 == 1) {
                ?>
                    <table border='solid'>
                        <thead>
                            <td>E-MAIL</td>
                            <td>PATIENT NAME</td>
                            <td>DOB</td>
                            <td>GOVT ID NO</td>
                            <td>TYPE VACCINE</td>
                            <td>DOSE</td>
                            <td>DATE of VACCINATION</td>
                        </thead>
                        <tbody>
                            <?php do { ?>
                                <tr>
                                    <td><?php echo $searched['email'] ?></td>
                                    <td><?php echo $searched['name'] ?></td>
                                    <td><?php echo $searched['dob'] ?></td>
                                    <td><?php echo $searched['idno'] ?></td>
                                    <td><?php echo $searched['type'] ?></td>
                                    <td><?php echo $searched['dose'] ?></td>
                                    <td><?php echo $searched['date'] ?></td>
                                </tr>
                            <?php } while ($searched = mysqli_fetch_assoc($result2)); ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo $noPresentErr1;
                } ?>
            </div>
        </div>
        <div class="tablediv">
            <?php if ($done != NULL) { ?>
                <table border='solid'>
                    <thead>
                        <td>E-MAIL</td>
                        <td>PATIENT NAME</td>
                        <td>DOB</td>
                        <td>GOVT ID NO</td>
                        <td>TYPE VACCINE</td>
                        <td>DOSE</td>
                        <td>DATE of VACCINATION</td>
                    </thead>
                    <tbody>
                        <?php do { ?>
                            <tr>
                                <td><?php echo $done['email'] ?></td>
                                <td><?php echo $done['name'] ?></td>
                                <td><?php echo $done['dob'] ?></td>
                                <td><?php echo $done['idno'] ?></td>
                                <td><?php echo $done['type'] ?></td>
                                <td><?php echo $done['dose'] ?></td>
                                <td><?php echo $done['date'] ?></td>
                            </tr>
                        <?php } while ($done = mysqli_fetch_assoc($vaccinated)); ?>
                    </tbody>
                </table>
            <?php } else {
                echo "<h2 class='err'>NO CANDIDATES VACCINATED</h2>";
            }
            ?>
        </div>
    </div>
</body>

</html>