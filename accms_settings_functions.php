<?php

function editAccmHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT p.*, at.name type, u.name modified_by_user_name
        FROM accms p
        LEFT JOIN accm_types at ON at.type_code = p.accm_type
        LEFT JOIN users u ON u.id = p.last_modified_by_user_id
        WHERE p.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);
    $address = json_decode($accm['address'], true);
    $languages = json_decode($accm['languages'], true);
    $facilities = json_decode($accm['facilities'], true);
    
    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('edit-accm-page.php', [
                'info' => $_GET['info'] ?? NULL,
                'accm' => $accm,
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
        'image',
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
        imageUpload() ?? $accm['image'],
        $_POST["contactName"] ?? NULL,
        $_POST["contactEmail"] ?? NULL,
        $_POST["contactPhone"] ?? NULL,
        $_POST["webpage"] ?? NULL,
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $urlParams['accmId'] ?? NULL
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
        'SELECT a.id, a.name, a.slug, a.accm_type, a.wellness_offered, a.wellness_details, a.last_modified, a.last_modified_by_user_id, am.*, at.name type, u.name modified_by_user_name
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN users u ON u.id = a.last_modified_by_user_id
        LEFT JOIN accm_meals am on am.accm_id = a.id
        WHERE a.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);
    $wellnessDetails = json_decode($accm['wellness_details'], true);

    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render("edit-services-page.php", [
                'info' => $_GET['info'] ?? NULL,
                'accm' => $accm,
                'meals' => getServicesByCategory("meal"),
                'mealsStatus' => getServicesStatusByCategory("meal"),
                'wellnessDetails' => $wellnessDetails,
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
        $_POST['wellnessFacilities'] = NULL;
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
        'SELECT p.*, at.name type, u.name modified_by_user_name
        FROM accms p
        LEFT JOIN accm_types at ON at.type_code = p.accm_type
        LEFT JOIN users u ON u.id = p.last_modified_by_user_id
        WHERE p.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);
    $discounts = json_decode($accm['discounts'], true);

    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render('edit-discounts-page.php', [
                'accm' => $accm,
                'discounts' => $discounts,
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
        $_POST['childrenDiscountPercent'] = "";
        $_POST['childrenDiscountFor'] = [];
    }
    if(!isset($_POST['groupDiscount'])){
        $_POST['groupDiscountPercent'] = "";
        $_POST['groupPersonNumber'] = "";
    }
    if(!isset($_POST['earlyBookingDiscount'])){
        $_POST['earlyBookingDiscountPercent'] = "";
        $_POST['earlyBookingDays'] = "";
    }
    if(!isset($_POST['lastMinuteDiscount'])){
        $_POST['lastMinuteDiscountPercent'] = "";
        $_POST['lastMinuteDays'] = "";
    }

    if((isset($_POST['childrenDiscount']) AND (empty($_POST['childrenDiscountPercent']) OR empty($_POST['childrenDiscountFor'])))
        OR (isset($_POST['groupDiscount']) AND (empty($_POST['groupDiscountPercent']) OR empty($_POST['groupPersonNumber'])))
        OR (isset($_POST['earlyBookingDiscount']) AND (empty($_POST['earlyBookingDiscountPercent']) OR empty($_POST['earlyBookingDays'])))
        OR (isset($_POST['lastMinuteDiscount']) AND (empty($_POST['lastMinuteDiscountPercent']) OR empty($_POST['lastMinuteDays'])))){
            return urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/kedvezmenyek', [
                        'info' => 'emptyValue'
                    ]);
        }

    $discounts = json_encode($_POST, true);

    $table = "accms";
    $columns = [
        'discounts',
        'last_modified',
        'last_modified_by_user_id',
    ];
    $conditions = ['id = '];
    $execute = [
        $discounts,
        time() ?? NULL,
        $_SESSION['userId'] ?? NULL,
        $urlParams['accmId'],
    ];
    generateUpdateSql($table, $columns, $conditions, $execute);

    urlRedirect('szallasok/' . $accm['slug'] . '/beallitasok/kedvezmenyek', [
        'info' => 'updated'
    ]);
}

function editRoomsHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT p.*, at.name type, u.name modified_by_user_name
        FROM accms p
        LEFT JOIN accm_types at ON at.type_code = p.accm_type
        LEFT JOIN users u ON u.id = p.last_modified_by_user_id
        WHERE p.slug = ?'
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    echo render("wrapper.php", [
        'content' => render('accm-settings-page.php', [
            'settingsContent' => render("coming-soon-page.php"),
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

?>