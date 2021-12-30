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
    $statement = insertMailSql();

    $body = render("res-confirm-email-template.php", [
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

    $heroListTemplate = render("res-list.php", [
        "reservations" => $reservations,
        "packages" => $packages,
        "updateReservationId" => $_GET["edit"] ?? "",
        "info" => $_GET['info'] ?? "",
    ]);
    echo render('wrapper.php', [
        'content' => $heroListTemplate,
        'activeLink' => '/foglalasok',
        'isAuthorized' => true,
        'isAdmin' => isAdmin(),
        'title' => "Foglalások",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function updateReservationHandler()
{
    redirectToLoginIfNotLoggedIn();

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
        $_GET['id']
    ]);

    header("Location: /foglalasok?info=updated");

}

function cancelReservationHandler()
{
    redirectToLoginIfNotLoggedIn();
    
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE reservations
        SET status = "CANCELED"
        WHERE id= ?'
    );
    $statement->execute([$_GET['id']]);

    header("Location: /foglalasok?info=canceled");
}

function deleteReservationHandler()
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM reservations
        WHERE id = ?'
    );
    $statement->execute([$_GET['id']]);

    header("Location: /foglalasok?info=deleted");
}

?>