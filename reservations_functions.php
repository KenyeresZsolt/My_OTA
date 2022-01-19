<?php

function dateDifference($checkout, $checkin)
{
    $diff = strtotime($checkout) - strtotime($checkin);
    return ceil(abs($diff/86400));
}

function calculatePrice($input, $accmId)
{   
    $roomPrice = 0;
    $mealPrice = 0;
    $wellnessPrice = 0;

    $nights = dateDifference($input['checkout'], $input['checkin']);
    $guests = $input['adults']+$input['children'];
    
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?');
    $statement->execute([$accmId]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach($units as $unit){
        $roomPrice += $unit['price']*$input['rooms'][$unit['id']];
    }

    if(isset($input['meals'])){
        $statement = $pdo->prepare(
            'SELECT *
            FROM accm_meals am
            WHERE am.accm_id = ?'
        );
        $statement->execute([$accmId]);
        $meals = $statement->fetch(PDO::FETCH_ASSOC);

        foreach($input['meals'] as $meal){
            $mealPrice += $meals[$meal . "_price"]*$guests;
        }
    }

    if(isset($input['wellness'])){
        $statement = $pdo->prepare(
            'SELECT *
            FROM accm_wellness aw
            WHERE aw.accm_id = ?'
        );
        $statement->execute([$accmId]);
        $wellness = $statement->fetch(PDO::FETCH_ASSOC);
        
        $wellnessPrice = $guests*$wellness['wellness_price'];
    }

    $totalPricePerNight = $roomPrice+$mealPrice+$wellnessPrice;
    $totalPrice = $totalPricePerNight*$nights;
       
    echo "<pre>";
    echo "Szoba ára: " . $roomPrice . "<br>";
    echo "Étkezés ára: " . $mealPrice . "<br>";
    echo "Wellness ára: " . $wellnessPrice . "<br>";
    echo "Teljes ár egy éjszakára: " . $totalPricePerNight . "<br>";
    echo "Teljes ár: " . $totalPrice . "<br>";
    var_dump($_POST);
    
}

function reserveAccmHandler($urlParams)
{
    $reservedAccmId = $urlParams['accmId'];

    $totalRooms = array_sum($_POST['rooms']);
    $nights = dateDifference($_POST["checkout"], $_POST["checkin"]);
       
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accms a
        WHERE a.id = ?'
    );
    $statement->execute([$reservedAccmId]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    if (empty($_POST["checkin"])
        OR empty($_POST["checkout"])
        OR empty($_POST["adults"])
        OR $_POST["adults"] < 1) {
        urlRedirect('szallasok/' . $accm['slug'], [
            'res' => "1",
            'info' => "emptyData",
            'values' => base64_encode(json_encode($_POST)),
            'href' => '#infoMessage'
        ]);
    }
    
    if ($totalRooms === 0){
        urlRedirect('szallasok/' . $accm['slug'], [
            'res' => "1",
            'info' => "emptyRooms",
            'values' => base64_encode(json_encode($_POST)),
            'href' => '#infoMessage'
        ]);
    }
    
    if (empty($_POST["name"]) 
        OR empty($_POST["email"]) 
        OR empty($_POST["phone"])) {
        urlRedirect('szallasok/' . $accm['slug'], [
            'res' => "1",
            'info' => "emptyContact",
            'values' => base64_encode(json_encode($_POST)),
            'href' => '#infoMessage'
        ]);
    }

    calculatePrice($_POST, $urlParams['accmId']);
    exit;

    $statement = $pdo->prepare(
        'INSERT INTO reservations (name, email, phone, status, reserved, guests, checkin, checkout, nights, total_price, reserved_accm_id)
        VALUES (:name, :email, :phone, :status, :reserved, :guests, :checkin, :checkout, :nights, :total_price, :reserved_accm_id)'
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
        'total_price' => $totalPrice,
        'reserved_accm_id' => $reservedAccmId
    ]);

    //email
    $statement = insertMailSql();

    $body = render("res-confirm-email-template.php", [
        'name' =>  $_POST['name'] ?? NULL,
        'email' =>  $_POST['email'] ?? NULL,
        'guests' => $_POST['guests'],
        'checkin' => $_POST['checkin'],
        'checkout' => $_POST['checkout'],
        'nights' => $nights,
        'total_price' => $totalPrice,
        'accm' => $accm
    ]);

    $statement->execute([
        $_POST['email'],
        "Foglalási igazolás - " . $accm['name'] . ", " . $accm['location'],
        $body,
        'notSent',
        0,
        time()
    ]);

    header('Location: /szallasok/' . $accm['slug'] . '?info=reserved');

    sendMailsHandler();

    /*urlRedirect('szallasok/' . $accm['slug'], [
        'info' => 'reserved'
    ]);*/   //ezzel nem küldi ki az emaileket
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
        FROM accms'
    );
    $statement->execute();
    $accms = $statement->fetchAll(PDO::FETCH_ASSOC);

    $heroListTemplate = render("res-list.php", [
        "reservations" => $reservations,
        "accms" => $accms,
        "updateReservationId" => $_GET["edit"] ?? NULL,
        "info" => $_GET['info'] ?? NULL,
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
        SET name = ?, email = ?, phone = ?, guests = ?, checkin = ?, checkout = ?, nights = ?, total_price = ?
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

    urlRedirect('foglalasok', [
        'info' => 'updated'
    ]);
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

    urlRedirect('foglalasok', [
        'info' => 'canceled'
    ]);
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

    urlRedirect('foglalasok', [
        'info' => 'deleted'
    ]);
}

?>