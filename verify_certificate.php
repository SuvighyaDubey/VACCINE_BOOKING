<?php
require_once('db.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idno = test_input($_POST['idno']);
    $sqlp = "SELECT * FROM patient where idno = ' " . $idno . "';";
    $result1 = mysqli_query($conn, $sqlp);
    $present = mysqli_fetch_assoc($result1);
    mysqli_free_result($result1);
    if ($present == NULL) {
        $noUserErr = "Sorry,Candidate with given ID no. does not exists";
    } else {
        $p = 1;
        $sql = "SELECT * FROM patient, vaccinated where patient.P_id = vaccinated.P_id and patient.idno=' " . $idno . " ';";
        $result = mysqli_query($conn, $sql);
        $d1 = mysqli_fetch_assoc($result);
        $d2 = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/login.css">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&amp;display=swap" rel="stylesheet">
    <title>VERIFY VACCINE CERTIFICATE</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="login">
            <h2 class="pgHeading"><i class="fas fa-file-certificate"></i>&nbsp;VERIFY VACCINATION STATUS</h2>
            <h3 class="err"><?php echo $noUserErr; ?></h3>
            <form action="" method="post">
                <label for="idno">Enter Candidates Govt. Idno</label>
                <input type="text" name="idno" required>
                <input type="submit" value="CHECK VACCINATION STATUS" class="submit">
            </form>
        </div>


        <?php if ($p == 1) { ?>
            <div class="tablediv">
                <br>
                <h3>Name <i class="fas fa-arrow-right"></i> <?php echo $d1['name'] ?></h3>
                <h3>Govt. ID No. <i class="fas fa-arrow-right"></i> <?php echo $d1['idno'] ?></h3>

                <?php if ($d1['idno'] == $idno) { ?>
                    <table>
                        <thead>
                            <td>DOSE</td>
                            <td>TYPE</td>
                            <td>Date of Vaccination</td>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $d1['dose'] ?></td>
                                <td><?php echo $d1['type'] ?></td>
                                <td><?php if ($d1['date']) echo $d1['date'];
                                    else echo "Slot Booked"; ?></td>
                            </tr>
                            <?php if ($d2['idno'] == $idno) { ?>
                                <tr>
                                    <td><?php echo $d2['dose'] ?></td>
                                    <td><?php echo $d2['type'] ?></td>
                                    <td><?php if ($d2['date']) echo $d2['date'];
                                        else echo "Slot Booked"; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
    <?php } else {
                    echo "<h2 clas='err'>NO VACCINNATION RECORD EXISTS</h2>";
                }
            } ?>

</body>

</html>