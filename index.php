<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOK MY VACCINE</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/index_style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&amp;display=swap" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="header">
            <h1>COVID-19 VACCINE &nbsp;<i class="fas fa-syringe">&nbsp;</i> BOOKING PORTAL </h1>
        </div>
        <div class="option">
            <div class="split left">
                <button class="button">
                    <a href="user_login.php">
                        <b> CONTINUE AS USER TO GET VACCINATED</b>
                    </a>
                </button>
            </div>
            <div class="split right">
                <button class="button">
                    <a href="hospital_login.php">
                        <b>CONTINUE AS HOSPITAL STAFF</b>
                    </a>
                </button>
            </div>
        </div>
        <div class="bar">
            <div class="section a">
                <button class="button verify">
                    <a href="verify_certificate.php">
                        <b>VERIFY VACCINE CERTIFICATE AS THIRD PARTY</b>
                    </a>
                </button>
            </div>
            <div class="section b">
                <h3><i class="fas fa-phone-alt"></i>&nbsp; Support for COVID-19 :</h3>

            </div>
            <div class="section c">
                <h4>Health Ministry</h4>
                <p><a href="tel:+911123978046 ">+91-11-23978046</a>&nbsp;or&nbsp;<a href="tel:1075 ">1075</a></p>
            </div>
            <div class="section d">
                <h4>Support E-mail : </h4>
                <p><a href="mailto:"></a>support@bookmyvaccine.com</a></p>
            </div>

        </div>
    </div>

    <script>
        const left = document.querySelector('.left');
        const right = document.querySelector('.right');
        const container = document.querySelector('.container');

        left.addEventListener('mouseenter', () => {
            container.classList.add('hover-left');
        });

        left.addEventListener('mouseleave', () => {
            container.classList.remove('hover-left');
        });

        right.addEventListener('mouseenter', () => {
            container.classList.add('hover-right');
        });

        right.addEventListener('mouseleave', () => {
            container.classList.remove('hover-right');
        });
    </script>
</body>


</html>