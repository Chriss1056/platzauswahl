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
<body data-bs-theme="dark" style="background-color: #000000">
<div id="done" class="card" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)">
    <div class="card-header">
        <h3 class="card-title">Sitzplatzreservierung erfolgreich.</h3>
    </div>
    <div class="card-body">
        <h4 class="card-text">Ihre ausgewählten Sitzplätze wurden erfolgreich reserviert.</h4>
    </div>
    <div class="card-footer">
        <button class="btn btn-outline-primary" name="back" id="leave">Weiter</button>
    </div>
</div>
</body>
<script>
    document.getElementById("leave").addEventListener("click", back);

    function back() {
        window.location.replace(window.location.href="https://ball.htl-braunau.at/buy-ticket/buy-ticket.php");
    }
</script>
</html>