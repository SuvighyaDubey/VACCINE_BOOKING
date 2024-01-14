<?php
require_once('db.php');

if ($_GET['P_id'] && $_GET['dose']) {
    $P_id = $_GET['P_id'];
    $dose = $_GET['dose'];
} else {
    header("Location: user_login.php");
}

$sql = " SELECT p.*, v.type, v.dose,v.date, h.name as hname from patient p, vaccinated v, hospital h WHERE v.P_id = p.P_id and v.H_id = h.H_id and v.P_id=" . $P_id;
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$diff = (time() - strtotime($user['date']));
$interval = floor($diff / (60 * 60 * 24));

switch ($user['type']) {
    case 'Covishield':
        $days_left = 90 - $interval;
        $interval = 90;
        break;
    case 'Covaxin':
        $days_left = 28 - $interval;
        $interval = 28;
        break;
    case 'Pfizer':
        $days_left = 21 - $interval;
        $interval = 21;
        break;
    case 'SPUTNIK':
        $days_left = 21 - $interval;
        $interval = 21;
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&amp;display=swap" rel="stylesheet">
    <title>VACCINE CERTIFICATE</title>
</head>

<body onload="window.print();">
    <div class="container">
        <div class="header">
            <h1 class="username">COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="content">
            <h1>VACCINATION CERTIFICATE <i class="fas fa-file-certificate"></i></h1>
            <div class="tablediv">
                <h2>Beneficiary Details</h2>
                <table>
                    <tr>
                        <td>Full Name</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['name'] ?></td>
                    </tr>
                    <tr>
                        <td>DATE OF BIRTH [YYYY-MM-DD]</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['dob'] ?></td>
                    </tr>
                    <tr>
                        <td>Government idno</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['idno'] ?></td>
                    </tr>
                </table>
            </div>
            <h3>VACCINATION STATUS : <?php if ($dose == 1) {
                                            echo "<i class='fas fa-thermometer-half'></i>&nbsp;PARTIALLY VACCINATED";
                                        } else if ($dose == 2) {
                                            echo "<i class='fas fa-thermometer-full'></i>&nbsp;FULLY VACCINATED";
                                        } ?> </h3>

            <div class="tablediv">
                <table>
                    <h2>Dose 1 Details</h2>
                    <tr>
                        <td>Hospital Name</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['hname'] ?></td>
                    </tr>
                    <tr>
                        <td>Vaccine Type </td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['type'] ?></td>
                    </tr>
                    <tr>
                        <td>DOSE</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['dose'] ?></td>
                    </tr>
                    <tr>
                        <td>DATE OF VACCINATION [YYYY-MM-DD]</td>
                        <td><i class="fas fa-arrow-right"></i></td>
                        <td><?php echo $user['date'] ?></td>
                    </tr>
                </table>
            </div>
            <?php if ($dose == 2) {
                $user = mysqli_fetch_assoc($result); ?>
                <div class="tablediv">
                    <table>
                        <h2>Dose 2 Details</h2>
                        <tr>
                            <td>Hospital Name</td>
                            <td><i class="fas fa-arrow-right"></i></td>
                            <td><?php echo $user['hname'] ?></td>
                        </tr>
                        <tr>
                            <td>Vaccine Type </td>
                            <td><i class="fas fa-arrow-right"></i></td>
                            <td><?php echo $user['type'] ?></td>
                        </tr>
                        <tr>
                            <td>DOSE</td>
                            <td><i class="fas fa-arrow-right"></i></td>
                            <td><?php echo $user['dose'] ?></td>
                        </tr>
                        <tr>
                            <td>DATE OF VACCINATION [YYYY-MM-DD]</td>
                            <td><i class="fas fa-arrow-right"></i></td>
                            <td><?php echo $user['date'] ?></td>
                        </tr>
                    </table>
                </div>
            <?php mysqli_free_result($result);
            } else { ?>
                <h3>DAYS LEFT FOR DOSE 2 : <?php if ($days_left < 0) {
                                                echo "0";
                                            } else {
                                                echo $days_left;
                                            } ?> DAYS</h3>
                <h3>DOSE 2 CAN BE BOOKED AFETR : <?php echo date('Y-m-d', strtotime($user['date'] . ' + ' . $interval . ' days')); ?></h3>
            <?php } ?>
        </div>
    </div>
</body>

</html>