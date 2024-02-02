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
    header("location: login.php");
}

$servername = "localhost";
$username = "";
$password = "";
$database = "ball_main";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    session_destroy();
    header("location: fail.php?error-code=$connection->connect_error");
}

$query_common = "SELECT EntryID, TableNum, SeatNum, Reserved FROM reservations";
$result_common_unparsed = $connection->query($query_common);

if (isset($_POST["check"])) {
    if ($_POST["table1"] == $_POST["table2"]) {
        session_destroy();
        header("location: fail.php?error-code=ERR_DOUBLE_RESERVATION_ATTEMPTED");
        die();
    }

    if ($_POST["table1"] == "false") {
        session_destroy();
        header("location: fail.php?error-code=ERR_INVALID_SELECTION");
        die();
    }

    $arr1 = explode("-", $_POST["table1"]);
    if (isset($_POST["table2"])) {
        $arr2 = explode("-", $_POST["table2"]);
    }

    $query_check1 = "SELECT Reserved FROM reservations WHERE TableNum='$arr1[0]' AND SeatNum='$arr1[1]';";
    $check1 = $connection->query($query_check1);
    if (isset($_POST["table2"])) {
        $query_check2 = "SELECT Reserved FROM reservations WHERE TableNum='$arr2[0]' AND SeatNum='$arr2[1]';";
        $check2 = $connection->query($query_check2);
    }

    if ($check1->fetch_assoc()["Reserved"] == 1) {
        session_destroy();
        header("location: fail.php?error-code=ERR_BOOKED_DURING_WAIT");
        die();
    }
    if (isset($_POST["table2"])) {
        if ($check2->fetch_assoc()["Reserved"] == 1) {
            session_destroy();
            header("location: fail.php?error-code=ERR_BOOKED_DURING_WAIT");
            die();
        }
    }

    $connection->autocommit(0);
    $connection->begin_transaction();

    $query1 = "UPDATE reservations SET Reserved=1, UserID=$_SESSION[UserID] WHERE TableNum='$arr1[0]' AND SeatNum='$arr1[1]';";
    $connection->query($query1);

    if (isset($_POST["table2"])) {
        $query2 = "UPDATE reservations SET Reserved=1, UserID=$_SESSION[UserID] WHERE TableNum='$arr2[0]' AND SeatNum='$arr2[1]';";
        $connection->query($query2);
    }

    if (!$connection->commit()) {
        $connection->rollback();
        session_destroy();
        header("location: fail.php?error-code=ERR_COMMIT_ERROR");
    } else {
        session_destroy();
        header("location: success.php");
    }
    die();
}

$connection->close();
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
            $i = 6;
            $result_common_unparsed->data_seek(0);
            while (($row = $result_common_unparsed->fetch_assoc()) != false) {
                if ($i == 6) {
                    $i = 0;
                    echo "<optgroup label='--------------------------'></optgroup>";
                }
                if ($row["Reserved"] == 0) {
                    echo "<option value='$row[TableNum]-$row[SeatNum]'>Table $row[TableNum] - Seat $row[SeatNum]</option>";
                }
                $i++;
            }
            ?>
        </select>
        <select name="table2" id="table2" class="form-select form-select-lg mb-3" aria-label="class-selector">
            <option value="" selected>None</option>
            <?php
            $i = 6;
            $result_common_unparsed->data_seek(0);
            while (($row = $result_common_unparsed->fetch_assoc()) != false) {
                if ($i == 6) {
                    $i = 0;
                    echo "<optgroup label='--------------------------'></optgroup>";
                }
                if ($row["Reserved"] == 0) {
                    echo "<option value='$row[TableNum]-$row[SeatNum]'>Table $row[TableNum] - Seat $row[SeatNum]</option>";
                }
                $i++;
            }
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
