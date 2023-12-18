<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="bootstrap/bootstrap.bundle.js" type="text/javascript"></script>

    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <link href="css/fonts/pieces-of-eight.css" rel="stylesheet" type="text/css" />

    <link rel="icon" type="image/png" href="assets/favicon/favicon.png" />

    <title>Maturanten Sitzplatzreservierung</title>
</head>
<?php
if (!isset($_SESSION["allowed"])) {
    header("location: index.php");
}

$servername = "localhost";
$username = "Database-1";
$password = "Database-1#root";

$connection = new mysqli($servername, $username, $password);

if ($connection->connect_error) {
    unset($_POST["class"]);
    unset($_POST["email"]);
    unset($_POST["sirname"]);
    unset($_POST["name"]);
    unset($_POST["verify"]);
    header("location: fail.php?error-code=$connection->connect_error");
}



$connection->close();

if (isset($_POST["check"])) {
}

?>
<body data-bs-theme="dark" style="background-color: #000000">
<div style="width: 100% !important; height: 10% !important;">
    <h1 style="text-align: center">Wählen Sie bitte zwei Sitzplätze aus.</h1>
    <h4 style="text-align: center">Sie müssen mindestens einen Sitzplatz wählen.</h4>
    <h5 style="text-align: center">Die Tische 1 bis 31 sind für Ehrengäste reserviert.</h5>
</div>
<div style="height: 10% !important; align-content: center !important; justify-content: center !important;" class="m-5 mb-4">
    <form method="post" action="#" class="needs-validation" novalidate>
        <select name="table1" id="table1" class="form-select form-select-lg mb-3" aria-label="class-selector" required>
            <option value="" selected>None</option>
            <?php

            ?>
        </select>
        <select name="table2" id="table2" class="form-select form-select-lg mb-3" aria-label="class-selector">
            <option value="" selected>None</option>
            <?php

            ?>
        </select>
        <input name="check" id="check" class="input-group btn btn-outline-primary mb-3" type="submit" value="Überprüfen">
    </form>
</div>
<div class="mb-1">
    <h3 style="text-align: center">Die Tischnummern sind von 1 bis 6 von oben links nach oben rechts nach mitte links nach mitte rechts nach unten links nach unten rechts angeordnet.</h3>
</div>
<div>
    <img src="assets/tables/table-reservations.png" alt="Tischanordnung" width="75%" style="position: absolute; left: 12% !important;">
</div>
</body>
</html>