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
<div id="fail" class="card" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)">
    <div class="card-header">
        <h3 class="card-title">Bestellung fehlgeschlagen.</h3>
    </div>
    <div class="card-body">
        <h4 class="card-text">Es scheint etwas schiefgelaufen zu sein.<br>Versuchen Sie es doch später nocheinmal.</h4>
        <h5 class="card-text">Fehlercode: <?php if(isset($_GET["error-code"])) { echo $_GET["error-code"]; } else { echo "ERR_NO_ERR"; } ?></h5>
    </div>
    <div class="card-footer">
        <button class="btn btn-outline-secondary" name="back" id="back">Zurück</button>
        <button class="btn btn-outline-primary" name="leave" id="leave">Weiter</button>
    </div>
</div>
</body>
<script>
    document.getElementById("back").addEventListener("click", back);
    document.getElementById("leave").addEventListener("click", leave);

    function back() {
        window.history.back();
    }

    function leave() {
        window.location.replace(window.location.href="https://ball.htl-braunau.at/buy-ticket/buy-ticket.php");
    }
</script>
</html>