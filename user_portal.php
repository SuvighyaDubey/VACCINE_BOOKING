<?php
require_once('db.php');
if (!isset($_GET['P_id'])) {
    header("Location: hospital_login.php");
}
$P_id = $_GET['P_id'];

$sql = "SELECT * FROM patient WHERE P_id='" . $P_id . "' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
mysqli_free_result($result);

$sqld1 = "SELECT * FROM vaccinated WHERE P_id='" . $P_id . "' AND dose=1 ;";
$result1 = mysqli_query($conn, $sqld1);
$dose1 = mysqli_fetch_assoc($result1);
mysqli_free_result($result1);

$sqld2 = "SELECT * FROM vaccinated WHERE P_id='" . $P_id . "' AND dose=2 ;";
$result2 = mysqli_query($conn, $sqld2);
$dose2 = mysqli_fetch_assoc($result2);
mysqli_free_result($result2);

if ($dose1 == NULL && $dose2 == NULL) {
    $v = 0;
    $status = "NOT AT ALL VACCINATED";
} else if ($dose1 != NULL && $dose2 == NULL) {
    if ($dose1['date'] == NULL) {
        $v = 1;
        $status = "<i class='fas fa-thermometer-empty'></i>&nbsp;NOT AT ALL VACCINATED";
    } else {
        $v = 2;
        $status = "<i class='fas fa-thermometer-half'></i>&nbsp;Partially Vaccinated";

        $diff = (time() - strtotime($dose1['date']));
        $interval = floor($diff / (60 * 60 * 24));

        switch ($dose1['type']) {
            case 'Covishield':
                $days_left = 90 - $interval;
                break;
            case 'Covaxin':
                $days_left = 28 - $interval;
                break;
            case 'Pfizer':
                $days_left = 21 - $interval;
                break;
            case 'SPUTNIK':
                $days_left = 21 - $interval;
                break;
        }
    }
} else if ($dose1 != NULL && $dose2 != NULL) {
    if ($dose2['date'] == NULL) {
        $v = 3;
        $status = "<i class='fas fa-thermometer-half'></i>&nbsp;Partially Vaccinated";
    } else {
        $v = 4;
        $status = "<i class='fas fa-thermometer-full'></i>&nbsp;Fully Vaccinated";
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
</head>

<body>

    <div class="container">
        <div class="header">
            <h1 class="username">COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="welcomeBar">
            <span>
                <h1><i class="fas fa-user"></i>&nbsp;Welcome <b><?php echo $user['name']; ?></b></h1>
            </span>
            <h2>&nbsp;Vaccination Status <i class="fas fa-arrow-right"></i> <?php echo $status; ?> </h2>

        </div>
        <div class="tablediv">
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
        <div class="status">
            <?php if ($v == 0) {
                echo "<a href='book_dose.php?P_id=";
                echo $P_id;
                echo "&dose=1'>";
                echo "<button>Continue to Book DOSE 1</button></a>";
            } else if ($v == 1) {
                echo "<h2>Your Slot for DOSE 1 is Booked</h2>";
                echo "<a target='_blank' href='slot_book_pdf.php?P_id=";
                echo $P_id;
                echo "&dose=1'>";
                echo "<button>Print Dose 1 Slot Booking Details</button></a>";
            } else if ($v == 2) {
                if ($days_left <= 0) {
                    echo "<a href='book_dose.php?P_id=";
                    echo $P_id;
                    echo "&dose=2'>";
                    echo "<button>Continue to Book DOSE 2</button></a>";
                } else {
                    echo "<h2>Days Left for Dose 2 = ";
                    echo $days_left;
                    echo "</h2>";
                }
                echo "<a target='_blank' href='vaccine_pdf.php?P_id=";
                echo $P_id;
                echo "&dose=1'>";
                echo "<button>Print DOSE 1 Vaccination Certificate</button></a>";
            } else if ($v == 3) {
                echo "<a target='_blank' href='vaccine_pdf.php?P_id=";
                echo $P_id;
                echo "&dose=1'>";
                echo "<button>Print DOSE 1 Vaccination Certificate</button></a>";
                echo "<h2>Your Slot for DOSE 2 is Booked</h2>";
                echo "<a target='_blank' href='slot_book_pdf.php?P_id=";
                echo $P_id;
                echo "&dose=2'>";
                echo "<button>Print Dose 2 Slot Booking Details</button></a>";
            } else if ($v == 4) {
                echo "<a target='_blank' href='vaccine_pdf.php?P_id=";
                echo $P_id;
                echo "&dose=2'>";
                echo "<button>Print Vaccination Certificate</button></a>";
            }
            ?>
        </div>
    </div>
</body>

</html>