<?php

function editAccmHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);
    $address = json_decode($accm['address'], true);
    $languages = json_decode($accm['languages'], true);
    $facilities = json_decode($accm['facilities'], true);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_images ai
        WHERE ai.accm_id = ?'
    );
    $statement->execute([$accm['id']]);
    $images = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('edit-accm-page.php', [
                'info' => $_GET['info'] ?? NULL,
                'accm' => $accm,
                'images' => $images ?? NULL,
                'address' => $address,
                'languages' => $languages,
                'facilities' => $facilities,
                'accmTypes' => getAccmTypes(),
                'accmLangs' => getAccmLangs(),
                'accmFacilities' => getAccmFacilities(),
            ]),
            'accm' => $accm,
            'activeTab' => 'edit',
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Szerkesztés",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function updateAccmHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accms p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['accmId']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $slug = strtolower(slugify($_POST["name"] . "-" . $_POST["location"]));
    
    $table = "accms";
    $columns = [
        'name',
        'location',
        'slug',
        'address',
        'accm_type',
        'price',
        'capacity',
        'rooms',
        'bathrooms',
        'facilities',
        'description',
        'languages',
        'contact_name',
        'email',
        'phone',
        'webpage',
        'last_modified',
        'last_modified_by_user_id',
    ];
    $conditions = ['id = '];
    $execute = [
        $_POST["name"] ?? NULL, 
        $_POST["location"] ?? NULL, 
        $slug ?? NULL,
        createAddressJson() ?? NULL,
        $_POST["type"] ?? NULL,
        $_POST["price"] ?? NULL,
        $_POST["capacity"] ?? NULL,
        $_POST["rooms"] ?? NULL,
        $_POST["bathrooms"] ?? NULL,
        json_encode($_POST['facilities'] ?? NULL , true) ?? NULL,
        $_POST['description'] ?? NULL,
        json_encode($_POST['languages'] ?? NULL, true) ?? NULL,
        $_POST["contactName"] ?? NULL,
        $_POST["contactEmail"] ?? NULL,
        $_POST["contactPhone"] ?? NULL,
        $_POST["webpage"] ?? NULL,
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $urlParams['accmId'] ?? NULL
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);
    imageUploadHandler($urlParams['accmId']);

    $primaryImageId = $_POST['isPrimary'];
    $table = 'accm_images';
    $columns = [
        'is_primary',
    ];
    $conditions = ['id ='];
    $execute = [
        "YES",
        $primaryImageId,
    ];
    generateUpdateSql($table, $columns, $conditions, $execute);

    $table = 'accm_images';
    $columns = [
        'is_primary',
    ];
    $conditions = [
        'id <>',
        'accm_id ='
    ];
    $execute = [
        NULL,
        $primaryImageId,
        $urlParams['accmId']
    ];
    generateUpdateSql($table, $columns, $conditions, $execute);



    urlRedirect('szallasok/' . $slug . "/beallitasok/adatok", [
        'info'=> 'updated'
    ]);
}

function getServicesByCategory($category)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM services s
        where s.category = ?'
    );
    $statement->execute([$category]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getServicesStatusByCategory($category)
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM services_status ss
        where ss.category = ?'
    );
    $statement->execute([$category]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function editServicesHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.id, a.name, a.slug, a.accm_type, a.last_modified, a.last_modified_by_user_id, am.*, aw.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        LEFT JOIN accm_meals am on am.accm_id = a.id
        LEFT JOIN accm_wellness aw on aw.accm_id = a.id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render("edit-services-page.php", [
                'info' => $_GET['info'] ?? NULL,
                'accm' => $accm,
                'meals' => getServicesByCategory("meal"),
                'mealsStatus' => getServicesStatusByCategory("meal"),
                'wellnessFacilities' => getServicesByCategory("wellness"),
                'wellnessStatus' => getServicesStatusByCategory("wellness"),
            ]),
            'accm' => $accm,
            'activeTab' => 'services',
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Szolgáltatások",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function updateMealsHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.slug, am.*
        FROM accms a
        LEFT JOIN accm_meals am ON a.id = am.accm_id
        WHERE a.id = ?'
    );
    $statement->execute([$urlParams['accmId']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    if($_POST['mealOffered'] === "NO"){
        $_POST['breakfast'] = "NOTPROVIDED";
        $_POST['lunch'] = "NOTPROVIDED";
        $_POST['dinner'] = "NOTPROVIDED";
    }

    if(($_POST['breakfast'] === "PAYABLE" AND  empty($_POST['breakfastPrice'])) OR ($_POST['lunch'] === "PAYABLE" AND  empty($_POST['lunchPrice'])) OR ($_POST['dinner'] === "PAYABLE" AND  empty($_POST['dinnerPrice']))){
        return urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szolgaltatasok', [
                    'info' => 'mealsEmptyPrice#editMealsMessage'
                ]);
    }

    if($_POST['mealOffered'] === "YES" AND $_POST['breakfast'] === "NOTPROVIDED" AND $_POST['lunch'] === "NOTPROVIDED" AND $_POST['dinner'] === "NOTPROVIDED"){
        return urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szolgaltatasok', [
                    'info' => 'mealsNotSpecified#editMealsMessage'
                ]);
    }

    if($_POST['breakfast'] !== "PAYABLE"){
        $_POST['breakfastPrice'] = NULL;
    }
    if($_POST['lunch'] !== "PAYABLE"){
        $_POST['lunchPrice'] = NULL;
    }
    if($_POST['dinner'] !== "PAYABLE"){
        $_POST['dinnerPrice'] = NULL;
    }

    $table = "accm_meals";
    $columns = [
        'meal_offered',
        'breakfast',
        'breakfast_price',
        'lunch',
        'lunch_price',
        'dinner',
        'dinner_price',
    ];
    $conditions = ['accm_id ='];
    $execute = [
        $_POST['mealOffered'],
        $_POST['breakfast'],
        $_POST['breakfastPrice'],
        $_POST['lunch'],
        $_POST['lunchPrice'],
        $_POST['dinner'],
        $_POST['dinnerPrice'],
        $urlParams['accmId'],        
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    $table ="accms";
    $columns = [
        'last_modified',
        'last_modified_by_user_id',
    ];
    $conditions = ['id ='];
    $execute = [
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $urlParams['accmId'],
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szolgaltatasok', [
        'info' => 'mealsUpdated#editMealsMessage'
    ]);

}

function updateWellnessHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accms p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['accmId']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    if($_POST['wellnessOffered'] === "NO"){
        $_POST['pool'] = NULL;
        $_POST['sauna'] = NULL;
        $_POST['jacuzzi'] = NULL;
        $_POST['tub'] = NULL;
        $_POST['fitness'] = NULL;
        $_POST['wellnessStatus'] = "NOTPROVIDED";
        $_POST['wellnessPrice'] = NULL;
    }

    if($_POST['wellnessStatus'] === "INPRICE"){
        $_POST['wellnessPrice'] = NULL;
    }

    if($_POST['wellnessStatus'] === "PAYABLE" AND empty($_POST['wellnessPrice'])){
        return urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szolgaltatasok', [
                    'info' => 'wellnessEmptyPrice#editWellnessMessage'
                ]);
    }

    $facilities = getServicesByCategory('wellness');
    foreach($facilities as $facility){
        $facilityValues[] = $facility['value'];
    }

    $submitFacilities = "";
    for($i = 0; $i<count($facilityValues); $i++){
        $submitFacilities .= $_POST[$facilityValues[$i]] ?? NULL;
    }

    if($_POST['wellnessOffered'] === "YES" AND ((strlen($submitFacilities) === 0) OR !isset($_POST['wellnessStatus']))){
        return urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szolgaltatasok', [
                    'info' => 'wellnessFacilitiesNotSpecified#editWellnessMessage'
                ]);
    }

    $table = "accm_wellness";
    $columns = [
        'wellness_offered',
        'pool',
        'sauna',
        'jacuzzi',
        'tub',
        'fitness',
        'wellness_status',
        'wellness_price',
    ];
    $conditions = ['accm_id = '];
    $execute = [
        $_POST['wellnessOffered'],
        $_POST['pool'],
        $_POST['sauna'],
        $_POST['jacuzzi'],
        $_POST['tub'],
        $_POST['fitness'],
        $_POST['wellnessStatus'],
        $_POST['wellnessPrice'],
        $urlParams['accmId'],
    ];
    generateUpdateSql($table, $columns, $conditions, $execute);

    $table ="accms";
    $columns = [
        'last_modified',
        'last_modified_by_user_id',
    ];
    $conditions = ['id ='];
    $execute = [
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $urlParams['accmId'],
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szolgaltatasok', [
        'info' => 'wellnessUpdated#editWellnessMessage'
    ]);
}

function editDiscountsHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.id, a.name, a.slug, a.accm_type, a.last_modified, a.last_modified_by_user_id, am.meal_offered, aw.wellness_offered, ad.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        LEFT JOIN accm_meals am on a.id = am.accm_id
        LEFT JOIN accm_wellness aw on a.id = aw.accm_id
        LEFT JOIN accm_discounts ad on a.id = ad.accm_id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('edit-discounts-page.php', [
                'accm' => $accm,
                'info' => $_GET['info'] ?? NULL,
            ]),
            'accm' => $accm,
            'activeTab' => 'discounts',
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Kedvezmények",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function updateDiscountsHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accms p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['accmId']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);
    
    if(!isset($_POST['childrenDiscount'])){
        $_POST['childrenDiscountPercent'] = NULL;
        $_POST['childrenDiscountForAccm'] = NULL;
        $_POST['childrenDiscountForMeals'] = NULL;
        $_POST['childrenDiscountForWellness'] = NULL;
    }
    if(!isset($_POST['groupDiscount'])){
        $_POST['groupDiscountPercent'] = NULL;
        $_POST['groupPersonNumber'] = NULL;
    }
    if(!isset($_POST['earlyBookingDiscount'])){
        $_POST['earlyBookingDiscountPercent'] = NULL;
        $_POST['earlyBookingDays'] = NULL;
    }
    if(!isset($_POST['lastMinuteDiscount'])){
        $_POST['lastMinuteDiscountPercent'] = NULL;
        $_POST['lastMinuteDays'] = NULL;
    }

    $chDiscFor = ($_POST['childrenDiscountForAccm'] ?? NULL) . ($_POST['childrenDiscountForMeals'] ?? NULL) . ($_POST['childrenDiscountForWellness'] ?? NULL);

    if((isset($_POST['childrenDiscount']) AND (empty($_POST['childrenDiscountPercent']) OR strlen($chDiscFor) === 0))
        OR (isset($_POST['groupDiscount']) AND (empty($_POST['groupDiscountPercent']) OR empty($_POST['groupPersonNumber'])))
        OR (isset($_POST['earlyBookingDiscount']) AND (empty($_POST['earlyBookingDiscountPercent']) OR empty($_POST['earlyBookingDays'])))
        OR (isset($_POST['lastMinuteDiscount']) AND (empty($_POST['lastMinuteDiscountPercent']) OR empty($_POST['lastMinuteDays'])))){
            return urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/kedvezmenyek', [
                        'info' => 'emptyValue'
                    ]);
        }

    $table = "accm_discounts";
    $columns = [
        'children_discount',
        'children_discount_percent',
        'children_discount_for_accm',
        'children_discount_for_meals',
        'children_discount_for_wellness',
        'group_discount',
        'group_discount_percent',
        'group_person_number',
        'early_booking_discount',
        'early_booking_discount_percent',
        'early_booking_days',
        'last_minute_discount',
        'last_minute_discount_percent',
        'last_minute_days',
    ];
    $conditions = ['accm_id = '];
    $execute = [
        $_POST['childrenDiscount'] ?? NULL,
        $_POST['childrenDiscountPercent'] ?? NULL,
        $_POST['childrenDiscountForAccm'] ?? NULL,
        $_POST['childrenDiscountForMeals'] ?? NULL,
        $_POST['childrenDiscountForWellness'] ?? NULL,
        $_POST['groupDiscount'] ?? NULL,
        $_POST['groupDiscountPercent'] ?? NULL,
        $_POST['groupPersonNumber'] ?? NULL,
        $_POST['earlyBookingDiscount'] ?? NULL,
        $_POST['earlyBookingDiscountPercent'] ?? NULL,
        $_POST['earlyBookingDays'] ?? NULL,
        $_POST['lastMinuteDiscount'] ?? NULL,
        $_POST['lastMinuteDiscountPercent'] ?? NULL,
        $_POST['lastMinuteDays'] ?? NULL,
        $urlParams['accmId'],
    ];
    generateUpdateSql($table, $columns, $conditions, $execute);

    $table ="accms";
    $columns = [
        'last_modified',
        'last_modified_by_user_id',
    ];
    $conditions = ['id ='];
    $execute = [
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $urlParams['accmId'],
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/kedvezmenyek', [
        'info' => 'updated'
    ]);
}

function unitListHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.accm_id = ?'
    );
    $statement->execute([$accm['id']]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('accm-units-list.php', [
                'accm' => $accm,
                'units' => $units,
                'info' => $_GET['info'] ?? NULL,
            ]),
            'accm' => $accm,
            'activeTab' => 'rooms',
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Szobák",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function newUnitHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM bed_types'
    );
    $statement->execute();
    $bed_types = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo render('wrapper.php', [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('new-unit-page.php', [
                'accm' => $accm,
                'type' => $_GET['type'] ?? NULL,
                'bedTypes' => $bed_types,
            ]),
            'accm' => $accm,
            'activeTab' => 'rooms',
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Új szoba",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function createUnitHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        WHERE a.id = ?'
    );
    $statement->execute([$urlParams['accmId']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM bed_types'
    );
    $statement->execute();
    $bed_types = $statement->fetchAll(PDO::FETCH_ASSOC);

    $bedNumber = 0;
    foreach($_POST['bedTypes'] as $bedType){
        $bedNumber += $bedType;
    }

    if(($_GET['type'] === "room" AND (empty($_POST['name']) OR $bedNumber === 0 OR !isset($_POST['bathroomType']) OR empty($_POST['price']) OR empty($_POST['count'])))
        OR ($_GET['type'] === "apartment" AND (empty($_POST['name']) OR empty($_POST['roomsCount']) OR $bedNumber === 0 OR !isset($_POST['bathroomType']) OR empty($_POST['bathroomsCount']) OR empty($_POST['price']) OR empty($_POST['count'])))
        OR ($_GET['type'] === "complete" AND (empty($_POST['roomsCount']) OR empty($_POST['bathroomsCount']) OR $bedNumber === 0 OR empty($_POST['price'])))){
            urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szobak/uj-szoba', [
                'type' => $_GET['type'],
                'info' => 'emptyValue'
            ]);
    };

    if($_GET['type'] === 'complete'){
        $_POST['name'] = "Teljes " . $accm['type'];
        $_POST['count'] = "1";
    }

    $capacity = 0;
    foreach($bed_types as $bedType){
        $capacity += $_POST['bedTypes'][$bedType['value']] * $bedType['places'];
    }
    $totalCapacity = $capacity*($_POST['count'] ?? 1);

    /*echo "<pre>";
    echo $bedNumber . "<br>";
    echo $capacity . "<br>";
    echo $totalCapacity . "<br>";
    var_dump($_POST);
    exit;*/

    $table = "accm_units";
    $columns = [
        'accm_id',
        'name',
        'unit_type',
        'rooms_count',        
        'bed_types',
        'bathroom_type',
        'bathrooms_count',
        'price',
        'count',
        'capacity_per_unit',
        'total_capacity',
    ];
    $execute = [
        $accm['id'],
        $_POST['name'],
        $_GET['type'],
        $_POST['roomsCount'] ?? NULL,
        json_encode($_POST['bedTypes'], true),
        $_POST['bathroomType'],
        $_POST['bathroomsCount'] ?? NULL,
        $_POST['price'],
        $_POST['count'],
        $capacity,
        $totalCapacity,
    ];

    generateInsertSql($table, $columns, $execute);

    urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szobak', [
        'info' => 'added'
    ]);
}

function editUnitHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT a.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.id = ?'
    );
    $statement->execute([$urlParams['unitId']]);
    $unit = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM bed_types'
    );
    $statement->execute();
    $bed_types = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo render('wrapper.php', [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('edit-unit-page.php', [
                'accm' => $accm,
                'unit' => $unit,
                'unitBedTypes' => json_decode($unit['bed_types'], true),
                'bedTypes' => $bed_types,
                'info' => $_GET['info'] ?? NULL,
            ]),
            'accm' => $accm,
            'activeTab' => 'rooms',
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Szoba szerkesztése",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

function updateUnitHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units au
        WHERE au.id = ?'
    );
    $statement->execute([$urlParams['unitId']]);
    $unit = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT a.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        WHERE a.id = ?'
    );
    $statement->execute([$unit['accm_id']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM bed_types'
    );
    $statement->execute();
    $bed_types = $statement->fetchAll(PDO::FETCH_ASSOC);

    $bedNumber = 0;
    foreach($_POST['bedTypes'] as $bedType){
        $bedNumber += $bedType;
    }

    if(($unit['unit_type'] === "room" AND (empty($_POST['name']) OR $bedNumber === 0 OR !isset($_POST['bathroomType']) OR empty($_POST['price']) OR empty($_POST['count'])))
        OR ($unit['unit_type'] === "apartment" AND (empty($_POST['name']) OR empty($_POST['roomsCount']) OR $bedNumber === 0 OR !isset($_POST['bathroomType']) OR empty($_POST['bathroomsCount']) OR empty($_POST['price']) OR empty($_POST['count'])))
        OR ($unit['unit_type'] === "complete" AND (empty($_POST['roomsCount']) OR empty($_POST['bathroomsCount']) OR $bedNumber === 0 OR empty($_POST['price'])))){
            urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szobak/szoba-szerkesztese/' . $urlParams['unitId'], [
                'info' => 'emptyValue'
            ]);
    };

    if($unit['unit_type'] === 'complete'){
        $_POST['name'] = "Teljes " . $accm['type'];
        $_POST['count'] = "1";
    }

    $capacity = 0;
    foreach($bed_types as $bedType){
        $capacity += $_POST['bedTypes'][$bedType['value']] * $bedType['places'];
    }
    $totalCapacity = $capacity*($_POST['count'] ?? 1);

    /*echo "<pre>";
    var_dump($_POST);
    exit;*/

    $table = "accm_units";
    $columns = [
        'name',
        'rooms_count',        
        'bed_types',
        'bathroom_type',
        'bathrooms_count',
        'price',
        'count',
        'capacity_per_unit',
        'total_capacity',
    ];
    $conditions = ['id ='];
    $execute = [
        $_POST['name'],
        $_POST['roomsCount'] ?? NULL,
        json_encode($_POST['bedTypes'], true),
        $_POST['bathroomType'],
        $_POST['bathroomsCount'] ?? NULL,
        $_POST['price'],
        $_POST['count'],
        $capacity,
        $totalCapacity,
        $urlParams['unitId'],
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    $table ="accms";
    $columns = [
        'last_modified',
        'last_modified_by_user_id',
    ];
    $conditions = ['id ='];
    $execute = [
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $unit['accm_id'],
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/szobak/szoba-szerkesztese/' . $urlParams['unitId'], [
        'info' => 'updated'
    ]);
}

function deleteUnitHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT au.*, a.slug
        FROM accm_units au
        LEFT JOIN accms a ON au.accm_id = a.id
        WHERE au.id = ?'
    );
    $statement->execute([$urlParams['unitId']]);
    $unit = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'DELETE FROM accm_units
        WHERE id = ?');
    $statement->execute([$urlParams['unitId']]);

    urlRedirect('szallasok/' . $unit['slug'] . "/beallitasok/szobak", [
        'info' => 'deleted'
    ]);

}

?>