<?php
require "functions.php";
require "classService.php";
if (empty($_SESSION['userid'])) {
    header("Location: verification.php");
}

$allServices = [];

$data = $conn->query("SELECT * FROM services")->fetch_all(MYSQLI_ASSOC);
foreach ($data as $index => $service) {
    $allServices[$index] = new Service($service['category'], $service['name'], $service['quantity'], $service['fullMediaPrice'], $service['fullLaborFee'], $service['discountMediaPrice'], $service['discountLaborFee']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/page_style.css">
    <link rel="stylesheet" href="css/all_styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>

<body>
    <header><img src="images/logo.jpg" alt="Marketing Professzorok"><label>Szolgáltatás Kalkulátor</label><div id="nav-bar"></div></header>
    <div id="services_container" class="content">
        <?php
        ?>
    </div>
    <footer></footer>
</body>

</html>
<script>

</script>