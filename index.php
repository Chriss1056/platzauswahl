<?php session_start(); session_unset(); ?>
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
if(isset($_POST["verify"])) {

    if($_POST["name"] === "" || $_POST["sirname"] === "" || $_POST["email"] === "" || $_POST["class"] === "") {
        goto RET;
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

    $query1 = "SELECT name, sirname, class FROM plaetze.users WHERE name='$_POST[name]' AND sirname='$_POST[sirname]';";
    $result_unparsed1 = $connection->query($query1);

    $query2 = "SELECT name, sirname, class FROM plaetze.reservations WHERE name='$_POST[name]' AND sirname='$_POST[sirname]';";
    $result_unparsed2 = $connection->query($query2);

    $connection->close();

    if ($result_unparsed1->num_rows > 0) {
        $result1 = $result_unparsed1->fetch_assoc();

        $email_db = strtolower($result1["name"]) . "." . strtolower($result1["sirname"]) . "@htl-braunau.at";

        if ($result1["name"] === $_POST["name"] && $result1["sirname"] === $_POST["sirname"] && $email_db === strtolower($_POST["email"]) && $result1["class"] === $_POST["class"]) {
            if ($result_unparsed2->num_rows !== false) {
                $_SESSION["allowed"] = 1;
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["sirname"] = $_POST["sirname"];
                $_SESSION["class"] = $_POST["class"];
                unset($_POST["class"]);
                unset($_POST["email"]);
                unset($_POST["sirname"]);
                unset($_POST["name"]);
                unset($_POST["verify"]);
                header("location: select.php");
            } else {
                unset($_POST["class"]);
                unset($_POST["email"]);
                unset($_POST["sirname"]);
                unset($_POST["name"]);
                unset($_POST["verify"]);
                session_destroy();
                header("location: fail.php?error-code=ERR_USER_CHOSE_ALREADY");
            }
        } else {
            unset($_POST["class"]);
            unset($_POST["email"]);
            unset($_POST["sirname"]);
            unset($_POST["name"]);
            unset($_POST["verify"]);
            session_destroy();
            header("location: fail.php?error-code=ERR_USER_E_MAIL_INVALID");
        }
    } else {
        unset($_POST["class"]);
        unset($_POST["email"]);
        unset($_POST["sirname"]);
        unset($_POST["name"]);
        unset($_POST["verify"]);
        session_destroy();
        header("location: fail.php?error-code=ERR_NO_USER_FOUND");
    }


    RET:
}
unset($_POST["class"]);
unset($_POST["email"]);
unset($_POST["sirname"]);
unset($_POST["name"]);
unset($_POST["verify"]);
?>
<body data-bs-theme="dark" style="background-color: #000000">
<div class="card col-11 col-md-11 col-lg-6 col-xl-4" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)">
    <div class="card-header">
        <h1>Identität Bestätigen</h1>
    </div>
    <form method="post" action="#" class="needs-validation" novalidate>
        <div class="card-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" required>
                <label for="name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sirname" id="sirname" placeholder="Vorname" autocomplete="off" required>
                <label for="sirname">Familienname</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Schul Email" autocomplete="off" required>
                <label for="email">Schul Email</label>
            </div>
            <select name="class" id="class" class="form-select form-select-lg" aria-label="class-selector" required>
                <option value="" selected>None</option>
                <option value="4AFELC">4AFELC</option>
                <option value="5AHME">5AHME</option>
                <option value="5BHELS">5BHELS</option>
                <option value="5BHME">5BHME</option>
                <option value="5CHELS">5CHELS</option>
                <option value="5AHELS">5AHELS</option>
                <option value="5AHET">5AHET</option>
                <option value="5AHITS">5AHITS</option>
            </select>
        </div>
        <div class="card-footer">
            <input name="verify" id="verify" class="input-group btn btn-outline-primary mb-3" type="submit" value="Verifizieren">
        </div>
    </form>
</div>
</body>
</html>