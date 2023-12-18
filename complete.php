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

header("location: success.php");

?>
<body>
tmp
</body>
</html>