<?php

function dateDifference($checkout, $checkin)
{
    $diff = strtotime($checkout) - strtotime($checkin);
    return ceil(abs($diff/86400));
}

function reservePackageHandler($urlParams)
{
    $reservedPackageId = $urlParams['pckId'];

    $nights = dateDifference($_POST["checkout"], $_POST["checkin"]);
       
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$reservedPackageId]);

    $package = $statement->fetch(PDO::FETCH_ASSOC);

    $totalPrice = ($_POST["guests"]*$nights* ($package['disc_price'] === "0" ? $package['price'] : $package['disc_price']));

    if (empty($_POST["name"]) 
        OR empty($_POST["email"]) 
        OR empty($_POST["phone"]) 
        OR empty($_POST["guests"]) 
        OR empty($_POST["checkin"])
        OR empty($_POST["checkout"])
        OR empty($_POST["phone"])) {
        header('Location: /csomagok/' . $package['slug'] .'?res=1&info=emptyValue&values=' . base64_encode(json_encode($_POST)) . '&href=#infoMessage');

        return ;
    }

    $statement = $pdo->prepare(
        'INSERT INTO reservations (name, email, phone, status, reserved, guests, checkin, checkout, nights, totalPrice, reservedPackageId)
        VALUES (:name, :email, :phone, :status, :reserved, :guests, :checkin, :checkout, :nights, :totalPrice, :reservedPackageId)'
    );
    $statement->execute([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'status' => 'RESERVED',
        'reserved' => time(),
        'guests' => $_POST['guests'],
        'checkin' => $_POST['checkin'],
        'checkout' => $_POST['checkout'],
        'nights' => $nights,
        'totalPrice' => $totalPrice,
        'reservedPackageId' => $reservedPackageId
    ]);

    //email
    $statement = $pdo->prepare("INSERT INTO `email_messages` 
    (`email`, `subject`, `body`, `status`, `numberOfAttempts`, `createdAt`) 
    VALUES 
    (?, ?, ?, ?, ?, ?)");

    $body = compileTemplate("res-confirm-email-template.php", [
        'name' =>  $_POST['name'] ?? '',
        'email' =>  $_POST['email'] ?? '',
        'guests' => $_POST['guests'],
        'checkin' => $_POST['checkin'],
        'checkout' => $_POST['checkout'],
        'nights' => $nights,
        'totalPrice' => $totalPrice,
        'package' => $package
    ]);

    $statement->execute([
        $_POST['email'],
        "Foglalási igazolás - " . $package['name'] . ", " . $package['location'],
        $body,
        'notSent',
        0,
        time()
    ]);

    header("Location: /csomagok/" . $package['slug'] ."?info=reserved");

    sendMailsHandler();
}

function reservationListHandler()
{
    redirectToLoginIfNotLoggedIn();

    $isUpdated = isset($_GET["updated"]);
    $isDeleted = isset($_GET["deleted"]);

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM reservations'
    );
    $statement->execute();
    $reservations = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM packages'
    );
    $statement->execute();
    $packages = $statement->fetchAll(PDO::FETCH_ASSOC);

    $heroListTemplate = compileTemplate("res-list.php", [
        "reservations" => $reservations,
        "packages" => $packages,
        "updateReservationId" => $_GET["edit"] ?? "",
        "isUpdated" => $isUpdated,
        "isDeleted" => $isDeleted,
    ]);
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => $heroListTemplate,
        'activeLink' => '/foglalasok',
        'isAuthorized' => true,
        'isAdmin' => isAdmin(),
        'title' => "Foglalások",
        'unreadMessages' => countUnreadMessages()
    ]);
}

function updateReservationHandler()
{
    redirectToLoginIfNotLoggedIn();
    $updateReservationId = $_GET['id'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE reservations
        SET name = ?, email = ?, phone = ?, guests = ?, checkin = ?, checkout = ?, nights = ?, totalPrice = ?
        WHERE id = ?'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        $_POST["phone"],
        $_POST["guests"],
        $_POST["checkin"],
        $_POST["checkout"],
        dateDifference($_POST["checkout"], $_POST["checkin"]),
        $_POST["price"],
        $updateReservationId
    ]);

    header("Location: /foglalasok?updated=1");

}

function cancelReservationHandler()
{
    redirectToLoginIfNotLoggedIn();
    $canceledReservationId= $_GET['id'];
    
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE reservations
        SET status = "CANCELED"
        WHERE id= ?'
    );
    $statement->execute([
        $canceledReservationId
    ]);

    header("Location: /foglalasok?canceled=1");
}

function deleteReservationHandler()
{
    redirectToLoginIfNotLoggedIn();
    $deletedReservationId= $_GET['id'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM reservations
        WHERE id = ?'
    );
    $statement->execute([
        $deletedReservationId
    ]);

    header("Location: /foglalasok?deleted=1");
}

?>