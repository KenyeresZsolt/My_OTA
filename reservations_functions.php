<?php

function dateDifference($checkout, $checkin)
{
    $diff = strtotime($checkout) - strtotime($checkin);
    return ceil(abs($diff/86400));
}

function getCapacity($input, $accmId)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?');
    $statement->execute([$accmId]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    $capacity = 0;
    foreach($units as $unit){
        $capacity += $unit['capacity_per_unit']*$input[$unit['id']];
    }
    return $capacity;
}

function calculatePrice($input, $accmId)
{   
    $roomPrice = 0;
    $mealPrice = 0;
    $wellnessPrice = 0;

    $daysTillCheckin = dateDifference($input['checkin'], date('Y-m-d'));
    $nights = dateDifference($input['checkout'], $input['checkin']);
    $guests = $input['adults']+$input['children'];
    
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?');
    $statement->execute([$accmId]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_discounts ad
        WHERE ad.accm_id = ?');
    $statement->execute([$accmId]);
    $discounts = $statement->fetch(PDO::FETCH_ASSOC);

    foreach($units as $unit){
        $roomPrice += $unit['price']*$input['rooms'][$unit['id']]*$nights;
    }

    $priceDetails = [
        'originalRoomPrice' => 0,
        'childrenRoomDiscountValue' => 0,
        'groupDiscountValue' => 0,
        'earlyBookingDiscountValue' => 0,
        'lastMinuteDiscountValue' => 0,
        'finalRoomPrice' => 0,
        'originalMealPrice' => 0,
        'childrenMealDiscountValue'=> 0,
        'finalMealPrice' => 0,
        'originalWellnessPrice' => 0,
        'childrenWellnessDiscountValue' => 0,
        'finalWellnessPrice' => 0,
        'totalOriginalPrice' => 0,
        'totalFinalPrice' => 0,
    ];

    $originalRoomPrice = $roomPrice;
    $priceDetails['originalRoomPrice'] = $originalRoomPrice;

    if($discounts['children_discount'] === 'YES' AND $discounts['children_discount_for_accm'] === 'YES'){
        $adultRoomPrice = $roomPrice/$guests*$input['adults'];
        $childrenRoomPrice = $roomPrice/$guests*$input['children'];
        $childrenRoomPrice = $childrenRoomPrice*(100-$discounts['children_discount_percent'])/100;
        $original = $roomPrice;
        $roomPrice = $adultRoomPrice+$childrenRoomPrice;
        $childrenDiscount = $original-$roomPrice;
        $priceDetails['childrenRoomDiscountValue'] = round($childrenDiscount, 2);
    }

    if($discounts['group_discount'] === 'YES' AND $guests >= $discounts['group_person_number']){
        $original = $roomPrice;
        $roomPrice = $roomPrice*(100-$discounts['group_discount_percent'])/100;
        $groupDiscount = $original-$roomPrice;
        $priceDetails['groupDiscountValue'] = $groupDiscount;
    }

    if($discounts['early_booking_discount'] === 'YES' AND $daysTillCheckin >= $discounts['early_booking_days']){
        $original = $roomPrice;
        $roomPrice = $roomPrice*(100-$discounts['early_booking_discount_percent'])/100;
        $earlyBookingDiscount = $original-$roomPrice;
        $priceDetails['earlyBookingDiscountValue'] = $earlyBookingDiscount;
    }

    if($discounts['last_minute_discount'] === 'YES' AND $daysTillCheckin <= $discounts['last_minute_days']){
        $original = $roomPrice;
        $roomPrice = $roomPrice*(100-$discounts['last_minute_discount_percent'])/100;
        $lastMinuteDiscount = $original-$roomPrice;
        $priceDetails['lastMinuteDiscountValue'] = $lastMinuteDiscount;
    }

    $priceDetails['finalRoomPrice'] = round($roomPrice, 2);

    if(isset($input['meals'])){
        $statement = $pdo->prepare(
            'SELECT *
            FROM accm_meals am
            WHERE am.accm_id = ?'
        );
        $statement->execute([$accmId]);
        $meals = $statement->fetch(PDO::FETCH_ASSOC);

        foreach($input['meals'] as $meal){
            $mealPrice += $meals[$meal . '_price']*$guests*$nights;
        }

        $originalMealPrice = $mealPrice;
        $priceDetails['originalMealPrice'] = $originalMealPrice;

        if($discounts['children_discount'] === 'YES' AND $discounts['children_discount_for_meals'] === 'YES'){
            $adultMealPrice = $mealPrice/$guests*$input['adults'];
            $childrenMealPrice = $mealPrice/$guests*$input['children'];
            $childrenMealPrice = $childrenMealPrice*(100-$discounts['children_discount_percent'])/100;
            $mealPrice = $adultMealPrice+$childrenMealPrice;
            $mealDiscount = $originalMealPrice-$mealPrice;
            $priceDetails['childrenMealDiscountValue'] = $mealDiscount;
        }
        $priceDetails['finalMealPrice'] = $mealPrice;
    }

    if(isset($input['wellness'])){
        $statement = $pdo->prepare(
            'SELECT *
            FROM accm_wellness aw
            WHERE aw.accm_id = ?'
        );
        $statement->execute([$accmId]);
        $wellness = $statement->fetch(PDO::FETCH_ASSOC);
        
        $wellnessPrice = $wellness['wellness_price']*$guests*$nights;

        $originalWellnessPrice = $wellnessPrice;
        $priceDetails['originalWellnessPrice'] = $originalWellnessPrice;

        if($discounts['children_discount'] === 'YES' AND $discounts['children_discount_for_wellness'] === 'YES'){
            $adultWellnessPrice = $wellnessPrice/$guests*$input['adults'];
            $childrenWellnessPrice = $wellnessPrice/$guests*$input['children'];
    
            $childrenWellnessPrice = $childrenWellnessPrice*(100-$discounts['children_discount_percent'])/100;
            $wellnessPrice = $adultWellnessPrice+$childrenWellnessPrice;
            $wellnessDiscount = $originalWellnessPrice-$wellnessPrice;
            $priceDetails['childrenWellnessDiscountValue'] = $wellnessDiscount;
        }
        $priceDetails['finalWellnessPrice'] = $wellnessPrice;
    }

    $totalOriginalPrice = $originalRoomPrice+($originalMealPrice ?? 0)+($originalWellnessPrice ?? 0);
    $totalFinalPrice = $roomPrice+$mealPrice+$wellnessPrice;

    $priceDetails['totalOriginalPrice'] = $totalOriginalPrice;
    $priceDetails['totalFinalPrice'] = $totalFinalPrice;

    return $priceDetails;    
}

function reservedRoomsDescription($accmId, $resRooms, $nights)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?'
    );
    $statement->execute([$accmId]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    $reservedUnitsDescription = [];
    foreach($units as $unit){
        if($resRooms[$unit['id']] > 0){
            $reservedUnitsDescription[] = $resRooms[$unit['id']] . ' x ' .  $unit['name'] . " x $nights ??j = " . $resRooms[$unit['id']]*$unit['price']*$nights . ' lej';
        }
    }

    return $reservedUnitsDescription;
}

//lek??rem a sz??ll??s ??ltal biztos??tott ??tkez??seket. A foglal??s l??trehoz??sakor kell, mert megn??zi, hogy biztos??t-e ??tkez??st, valamint az adatok feldolgoz??s??hoz.
function getAccmMeals($accmId)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_meals am
        WHERE am.accm_id = ?'
    );
    $statement->execute([$accmId]);
    $accmMeals = $statement->fetch(PDO::FETCH_ASSOC);
    return $accmMeals;
}

// egy array-be ??sszegy??jti, hogy melyik ??tkez??snek mi a st??tusa. Ezt mentem le adatb??zisba, valamint a foglal??si aigazol??sban megjelen?? sz??veghez kell.
function reservedMeals($accmId, $resMeals, $nights, $totalGuests)
{    
    $accmMeals = getAccmMeals($accmId);
    $meals = getServicesByCategory('meal');
    $mealsStatuses = getServicesStatusByCategory('meal');

    $reservedMeals = [];
    foreach($meals as $meal){
        if($accmMeals[$meal['value']] !== 'PAYABLE'){
            $reservedMeals[$meal['value']] = $accmMeals[$meal['value']];
        }
        elseif($accmMeals[$meal['value']] === 'PAYABLE' AND in_array($meal['value'], $resMeals)){
            $reservedMeals[$meal['value']] = $accmMeals[$meal['value'] . '_price']*$nights*$totalGuests;
        }
    }
    return $reservedMeals;
}

//foglal??si igazol??sban megjelen?? sz??veget gener??lja le
function reservedMealsDescription($accmId, $resMeals, $nights, $totalGuests)
{
    $meals = getServicesByCategory('meal');
    $reservedMealsDescription = [];
    foreach($resMeals as $reservedMeal => $status){
        foreach($meals as $meal){
            if($status === 'INPRICE'){
                if($meal['value'] === $reservedMeal){
                    $reservedMealsDescription[] = $meal['name'] . " x $totalGuests f?? x $nights alkalom: Benne van az ??rban.";
                }
            }
            elseif(is_numeric($status)){
                if($meal['value'] === $reservedMeal){
                    $reservedMealsDescription[] = $meal['name'] . " x $totalGuests f?? x $nights alkalom = " . $status . ' lej';
                }
            }
        }
    }
    return $reservedMealsDescription;    
}

function getAccmWellness($accmId)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_wellness aw
        WHERE aw.accm_id = ?'
    );
    $statement->execute([$accmId]);
    $accmWellness = $statement->fetch(PDO::FETCH_ASSOC);
    return $accmWellness;
}

function reservedWellness($accmId, $resWellness, $nights, $totalGuests)
{
    $accmWellness = getAccmWellness($accmId);
    $wellnessStatuses = getServicesStatusByCategory('wellness');

    $reservedWellness = NULL;

    if($accmWellness['wellness_status'] === 'INPRICE'){
        $reservedWellness = 'INPRICE';
    }
    elseif($accmWellness['wellness_status'] === 'PAYABLE' AND $resWellness === 'YES'){
        $reservedWellness = $accmWellness['wellness_price']*$nights*$totalGuests;
    }
    return $reservedWellness;

}

function reservedWellnessDescription($accmId, $resWellness, $nights, $totalGuests)

{
    $reservedWellnessDescription = NULL;
    if($resWellness === 'INPRICE'){
        $reservedWellnessDescription = 'Wellness: Benne van az ??rban.';
    }
    elseif(!is_null($resWellness)){
        $reservedWellnessDescription = "Wellness x $totalGuests f?? x $nights ??j = " . $resWellness . ' lej';
    }
    return $reservedWellnessDescription;
}

function generateReservationDetails($input, $accmId)
{
    $totalRooms = array_sum($input['rooms']);
    $totalGuests = $input['adults'] + $input['children'];
    $capacity = getCapacity($input['rooms'], $accmId);
           
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accms a
        WHERE a.id = ?'
    );
    $statement->execute([$accmId]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    if(empty($input['checkin'])
        OR empty($input['checkout'])
        OR empty($input['adults'])
        OR $input['adults'] < 1) {
        urlRedirect('szallasok/' . $accm['slug'], [
            'info' => 'emptyData',
            'values' => base64_encode(json_encode($input)),
            'href' => '#infoMessage'
        ]);
    }

    if($capacity<$totalGuests){
        urlRedirect('szallasok/' . $accm['slug'], [
            'info' => 'lowCapacity',
            'values' => base64_encode(json_encode($input)),
            'href' => '#infoMessage'
        ]);
    }
    
    if($totalRooms === 0){
        urlRedirect('szallasok/' . $accm['slug'], [
            'info' => 'emptyRooms',
            'values' => base64_encode(json_encode($input)),
            'href' => '#infoMessage'
        ]);
    }

    if($totalRooms>$totalGuests){
        urlRedirect('szallasok/' . $accm['slug'], [
            'info' => 'tooMuchRooms',
            'values' => base64_encode(json_encode($input)),
            'href' => '#infoMessage'
        ]);
    }

    $nights = dateDifference($input['checkout'], $input['checkin']);
    $priceDetails = calculatePrice($input, $accmId);
    $totalPrice = $priceDetails['totalFinalPrice'];

    $reservedUnitsDescription = reservedRoomsDescription($accmId, $input['rooms'], $nights);
    
    $accmMeals = getAccmMeals($accmId);
    if($accmMeals['meal_offered'] === 'YES'){
        $reservedMeals = reservedMeals($accmId, $input['meals'] ?? NULL, $nights, $totalGuests);
        $reservedMealsDescription = reservedMealsDescription($accmId, $reservedMeals, $nights, $totalGuests);
    }

    $accmWellness = getAccmWellness($accmId);
    if($accmWellness['wellness_offered'] === 'YES'){
        $reservedWellness = reservedWellness($accmId, $input['wellness'] ?? NULL, $nights, $totalGuests);
        $reservedWellnessDescription = reservedWellnessDescription($accmId, $reservedWellness, $nights, $totalGuests);
    }

    $resDetails = [
        'nights' => $nights,
        'accm' => $accm,
        'meals' => $reservedMeals ?? NULL,
        'wellness' => $reservedWellness ?? NULL,
        'priceDetails' => $priceDetails,
        'unitsDescription' => $reservedUnitsDescription ?? NULL,
        'mealsDescription' => $reservedMealsDescription ?? NULL,
        'wellnessDescription' => $reservedWellnessDescription ?? NULL,
        'totalPrice' => $totalPrice,
    ];

    return $resDetails;
}

function calculatePriceHandler($urlParams, $bestOffer = [])
{
    $accmId = $urlParams['accmId'];

    if(empty($bestOffer)){
        $resDetails = generateReservationDetails($_POST, $accmId);
        $info = 'calculatePrice';
        $href = '#calcPrice';
        $input = $_POST;
    }
    else{
        $resDetails = generateReservationDetails($bestOffer, $accmId);
        $info = 'bestOffer';
        $href = '#infoMessage';
        $input = $bestOffer;
    }

    $accm = $resDetails['accm'];

    

    urlRedirect('szallasok/' . $accm['slug'], [
        'info' => $info,
        'values' => base64_encode(json_encode($input)),
        'details' => base64_encode(json_encode($resDetails)),
        'href' => $href,
    ]);
}

// PHP program to find out all
// combinations of positive
// numbers that add upto given number
 
/* arr - array to store the combination
    index - next location in array
    num - given number
    reducedNum - reduced number */
function findCombinationsUtil($arr, $index,
    $num, $reducedNum, &$solutions)
{
    // Base condition
    if ($reducedNum < 0)
        return;

    // If combination is
    // found, print it
    if ($reducedNum == 0)
    {
        for ($i = 0; $i < $index; $i++){
            $solution[] = $arr[$i];
        }
        $solutions[] = $solution;
        return;
    }

    // Find the previous number
    // stored in arr[] It helps
    // in maintaining increasing order
    $prev = ($index == 0) ? 1 : $arr[$index - 1];

    // note loop starts from previous
    // number i.e. at array location
    // index - 1
    for ($k = $prev; $k <= $num ; $k++)
    {
        // next element of array is k
        $arr[$index] = $k;

        // call recursively with
        // reduced number
        findCombinationsUtil($arr, $index + 1,
        $num, $reducedNum - $k, $solutions);
    }
}

/* Function to find out all
combinations of positive numbers
that add upto given number.
It uses findCombinationsUtil() */
function findCombinations($n)
{
    // array to store the combinations
    // It can contain max n elements
    $arr = $solutions = array();

    //find all combinations
    findCombinationsUtil($arr, 0, $n, $n, $solutions);
    return $solutions;
}

function calculateBestOffer($accmId, $input)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?'
    );
    $statement->execute([$accmId]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    $totalGuests = $input['adults']+$input['children'];
    $unitsReserved = [];

    foreach($units as $unit){
        $unitsReserved[$unit['id']]['selected'] = 0;
        $unitsReserved[$unit['id']]['available'] = $unit['count'];
        $unitsReserved[$unit['id']]['capacity'] = $unit['capacity_per_unit'];
        $unitsReserved[$unit['id']]['price'] = $unit['price'];
    }

    $combs = findCombinations($totalGuests);
    $possibilities = count($combs); //megsz??molom, hogy h??ny lehets??ges v??ltozat van
    $i = 0;

    for($i; $i<$possibilities; $i++){ 
        $roomCount = count($combs[$i]); //megsz??molom, hogy h??ny szoba kell
        $r = 0;
        $units = $unitsReserved; //azz??rt mentettem le k??l??n v??ltoz??ba, hogy minden al??bbi iter??ci?? ut??n ??jra az eredeti ??llapotot hozza vissza
        for($r; $r < $roomCount; $r++){
            foreach($units as $id => $unit){
                if($unit['available']>0 AND $unit['capacity']>=$combs[$i][$r]){
                    $prices[$id] = $unit['price'];
                    // lementem azoknak a szob??knak az ??rait, amelyekb??l van m??g el??rhet?? ??s be is f??r annyi szem??ly
                }              
            }
            if(!empty($prices)){
                $min = array_search(min($prices), $prices); // megkeresem a minimum ??rat
                $dists[$i][$r]['persons'] = $combs[$i][$r]; // lementem az adott szem??lyek sz??m??t
                $dists[$i][$r]['roomId'] = $min; // lementem a hossz??juk tartoz?? minimum ??ras szoba ID-j??t
                $dists[$i][$r]['price'] = $units[$min]['price']; // lementem a minimum ??ru szoba ??r??t
                $units[$min]['available'] = $units[$min]['available']-1; // egyel cs??kkentem az adott szoba el??rhet?? darabsz??m??t, az??rt, hogy ne foglaljon le t??bbet, mint amennyi van
                $prices = []; // ki??r??tem az ??rakat tartalmaz?? array-t az??rt, hogy a k??vetkez?? iterr??ci??ban ??resen kezdjen
            }
        }
    }

    // ??sszegy??jt??m minden lehets??ges eloszt??snak az ??ssz ??r??t + a szem??lyek sz??m??t, amire az ??r vonatkozik
    // az??rt kellett ??gy, mert a fentebbi iterr??ci?? ha nem tal??lt olyan szob??t, amibe belef??rne x ember, akkor azt m??r nem tette bele
    // pl. 10 szem??ly eset??n, az 1+9-es kombin??ci??n??l csak az egy f??s szoba marad, ha nincs 9szem??lyes szoba
    foreach($dists as $k => $dist){
        $count = count($dist);
        $i = 0;
        $totalPricesWithPersons[$k]['price'] = 0;
        $totalPricesWithPersons[$k]['pers'] = 0;
        for($i; $i<$count; $i++){
            $totalPricesWithPersons[$k]['price'] += $dist[$i]['price'];
            $totalPricesWithPersons[$k]['pers'] += $dist[$i]['persons'];
        }
    }

    // itt n??zem meg, hogy t??nyleg csak azon esetek k??z??l keresse meg a minimumot, ahol annyi szem??ly van, amennyi bek??ld??d??tt
    foreach($totalPricesWithPersons as $k => $details){
        if($details['pers'] === $totalGuests){
            $totalPrices[$k] = $details['price'];
        }
    }

    //legjobb eloszt??s
    $bestDist = $dists[array_search(min($totalPrices), $totalPrices)];

    foreach($bestDist as $room){
        $unitsReserved[$room['roomId']]['selected'] += 1;
        $unitsReserved[$room['roomId']]['available'] -= 1;
    }

    foreach($unitsReserved as $k => $unitReserved){
        $input['rooms'][$k] = $unitReserved['selected'];
    }

    return $input;
}

function calculateBestOfferHandler($urlParams)
{
    $accmId = $urlParams['accmId'];
        
    $input = calculateBestOffer($accmId, $_POST);

    calculatePriceHandler($urlParams, $input);
}

function accmListPricesCalculation($accmId, $input)
{
    $days = dateDifference($input['checkout'], $input['checkin']);
    $totalGuests = $input['adults']+$input['children'];
    $accmCapacity = 0;
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?'
    );
    $statement->execute([$accmId]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    $input['rooms'] = NULL;
    foreach($units as $unit){
        $input['rooms'][$unit['id']] = 0;
        $accmCapacity += $unit['total_capacity'];
        $unitPrices[$unit['id']] = $unit['price'];
    }

    if($accmCapacity>=$totalGuests){
        $input = calculateBestOffer($accmId, $input);
    }

    $totalPrice = 0;
    if(array_sum($input['rooms'])>0){
        foreach($input['rooms'] as $id => $count){
            $totalPrice += $unitPrices[$id]*$count*$days;
        }
    }

    return $totalPrice;
}

function reserveAccmHandler($urlParams)
{
    $reservedAccmId = $urlParams['accmId'];
    $resDetails = generateReservationDetails($_POST, $reservedAccmId);
    $accm = $resDetails['accm'];
    
    if(empty($_POST['name']) 
        OR empty($_POST['email']) 
        OR empty($_POST['phone'])) {
        urlRedirect('szallasok/' . $accm['slug'], [
            'info' => 'emptyContact',
            'values' => base64_encode(json_encode($_POST)),
            'href' => '#infoMessage'
        ]);
    }

    $fullConfig = [
        'rooms' => $_POST['rooms'],
        'meals' => $resDetails['meals'],
        'wellness' => $resDetails['wellness'],
        'priceDetails' => $resDetails['priceDetails'],
    ];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO reservations (name, email, phone, status, reserved, adults, children, checkin, checkout, nights, total_price, reserved_accm_id, full_config)
        VALUES (:name, :email, :phone, :status, :reserved, :adults, :children, :checkin, :checkout, :nights, :total_price, :reserved_accm_id, :full_config)'
    );
    $statement->execute([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'status' => 'RESERVED',
        'reserved' => time(),
        'adults' => $_POST['adults'],
        'children' => $_POST['children'],
        'checkin' => $_POST['checkin'],
        'checkout' => $_POST['checkout'],
        'nights' => $resDetails['nights'],
        'total_price' => $resDetails['totalPrice'],
        'reserved_accm_id' => $reservedAccmId,
        'full_config' => json_encode($fullConfig, true) ?? NULL,
    ]);

    //email
    $statement = insertMailSql();

    $body = render('res-confirm-email-template.php', [
        'name' =>  $_POST['name'] ?? NULL,
        'email' =>  $_POST['email'] ?? NULL,
        'adults' => $_POST['adults'],
        'children' => $_POST['children'],
        'checkin' => $_POST['checkin'],
        'checkout' => $_POST['checkout'],
        'nights' => $nights,
        'unitsDescription' => $resDetails['unitsDescription'],
        'mealsDescription' => $resDetails['mealsDescription'],
        'wellnessDescription' => $resDetails['wellnessDescription'],
        'total_price' => $resDetails['totalPrice'],
        'accm' => $accm
    ]);

    $statement->execute([
        $_POST['email'],
        'Foglal??si igazol??s - ' . $accm['name'] . ', ' . $accm['location'],
        $body,
        'notSent',
        0,
        time()
    ]);

    header('Location: /szallasok/' . $accm['slug'] . '?info=reserved');

    sendMailsHandler();

    /*urlRedirect('szallasok/' . $accm['slug'], [
        'info' => 'reserved'
    ]);*/   //ezzel nem k??ldi ki az emaileket
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

    $reservationListTemplate = render('res-list.php', [
        'reservations' => $reservations,
        'accms' => $accms,
        'updateReservationId' => $_GET['edit'] ?? NULL,
        'info' => $_GET['info'] ?? NULL,
    ]);
    echo render('wrapper.php', [
        'content' => $reservationListTemplate,
        'activeLink' => '/foglalasok',
        'isAuthorized' => true,
        'isAdmin' => isAdmin(),
        'title' => 'Foglal??sok',
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function reservationPageHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT r.*, a.name accm_name, a.location location, a.slug accm_slug, a.address, a.contact_name, a.email contact_email, a.phone contact_phone, a.webpage contact_webpage
        FROM reservations r
        LEFT JOIN accms a ON r.reserved_accm_id = a.id
        WHERE r.id = ?'
    );
    $statement->execute([$urlParams['resId']]);
    $reservation = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_images ai
        WHERE ai.accm_id = ? AND ai.is_primary = "YES"'
    );
    $statement->execute([$reservation['reserved_accm_id']]);
    $image = $statement->fetch(PDO::FETCH_ASSOC);

    $fullConfig = json_decode($reservation['full_config'], true);
    $totalGuests = $reservation['adults']+$reservation['children'];

    $reservedUnitsDescription = reservedRoomsDescription($reservation['reserved_accm_id'], $fullConfig['rooms'], $reservation['nights']);
    if(!is_null($fullConfig['meals'])){
    $reservedMealsDescription = reservedMealsDescription($reservation['reserved_accm_id'], $fullConfig['meals'], $reservation['nights'], $totalGuests);
    }
    if(!is_null($fullConfig['wellness'])){
        $reservedWellnessDescription = reservedWellnessDescription($reservation['reserved_accm_id'], $fullConfig['wellness'], $reservation['nights'], $totalGuests);
    }

    echo render('wrapper.php', [
        'content' => render('res-page.php', [
            'reservation' => $reservation,
            'unitsDescription' => $reservedUnitsDescription,
            'mealsDescription' => $reservedMealsDescription ?? NULL,
            'wellnessDescription' => $reservedWellnessDescription ?? NULL,
            'priceDetails' => $fullConfig['priceDetails'],
            'image' => $image,
            'address' => json_decode($reservation['address'], true) ?? NULL,
        ]),
        'activeLink' => '/foglalasok',
        'isAuthorized' => true,
        'isAdmin' => isAdmin(),
        'title' => 'Foglal??sok',
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
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['guests'],
        $_POST['checkin'],
        $_POST['checkout'],
        dateDifference($_POST['checkout'], $_POST['checkin']),
        $_POST['price'],
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

function deleteReservationHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM reservations
        WHERE id = ?'
    );
    $statement->execute([$urlParams['resId']]);

    urlRedirect('foglalasok', [
        'info' => 'deleted'
    ]);
}

?>