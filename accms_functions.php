<?php

function getAccmTypes()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_types'
    );
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAccmLangs()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM languages'
    );
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAccmFacilities()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM facilities'
    );
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function accmListHandler()
{
    //szűrő forrása: https://phpdelusions.net/pdo_examples/dynamical_where

    $typeFilter = $_GET['t'] ?? NULL;
    $minPriceFilter = $_GET['minPrice'] ?? NULL;
    $maxPriceFilter = $_GET['maxPrice'] ?? NULL;
    $facilityFilter = $_GET['f'] ?? NULL;
    $langFilter = $_GET['l'] ?? NULL;

    $types = explode(" ", $typeFilter);
    $cntTypes = count($types);

    $facilities = explode(" ", $facilityFilter);
    $cntFacilities = count($facilities);

    $langs = explode(" ", $langFilter);
    $cntLangs = count($langs);

    $cond = [];
    $param = [];

    if(!empty($typeFilter)){
        for($i=0; $i<$cntTypes; $i++){
            $tcond[] = 'p.accm_type = ?';
            $param[] = $types[$i];
        }
        $cond[] = implode(" OR ", $tcond);
    }

    if(!empty($minPriceFilter)){
        $cond[] = 'p.price > ?';
        $param[] = $minPriceFilter;
    }

    if(!empty($maxPriceFilter)){
        $cond[] = 'p.price < ?';
        $param[] = $maxPriceFilter;
    }

    if(!empty($facilityFilter)){
        for($i=0; $i<$cntFacilities; $i++){
            $fcond[] = 'p.facilities LIKE ?';
            $param[] = "%" . $facilities[$i] . "%";
        }
        $cond[] = "(" . implode(" OR ", $fcond) . ")";
    }

    if(!empty($langFilter)){
        for($i=0; $i<$cntLangs; $i++){
            $lcond[] = 'p.languages LIKE ?';
            $param[] = "%" . $langs[$i] . "%";
        }
        $cond[] = "(" . implode(" OR ", $lcond) . ")";
    }

    $sql = "SELECT * from accms p";

    if($cond)
    {
        $sql .= " WHERE " . implode(" AND ", $cond);
    }

    $pdo = getConnection();
    $statement = $pdo->prepare($sql);
    $statement->execute($param);
    $accms = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo render('wrapper.php', [
        'content' => render("accm-list.php", [
            'accms' => $accms,
            'accmTypes' => getAccmTypes(),
            'accmFacilities' => getAccmFacilities(),
            'accmLangs' => getAccmLangs(),
            'typeFilter' => $typeFilter,
            'minPriceFilter' => $minPriceFilter,
            'maxPriceFilter' => $maxPriceFilter,
            'facilityFilter' => $facilityFilter,
            'langFilter' => $langFilter,
            "info" => $_GET['info'] ?? NULL,
            'isAuthorized' => isLoggedIn(),
            'isAdmin' => isAdmin() ?? NULL,
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Szállások",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

function accmFilterHandler()
{
    $types = $_POST['type'] ?? NULL;

    if(!empty($types)){
    $typesCount = count($types);
    $typeUrl = "t=";

    for($i=0; $i < $typesCount; $i++){
        $typeUrl = $typeUrl . $types[$i] . "+";
    }
    $typeUrl = substr_replace($typeUrl,"",-1) . "&";
    }
    
    if(!empty($_POST['minPrice'])){
        $minPirceUrl = "minPrice=" . $_POST['minPrice'] . "&";
    }

    if(!empty($_POST['maxPrice'])){
        $maxPirceUrl = "maxPrice=" . $_POST['maxPrice'] . "&";
    }

    $facilities = $_POST['facility'] ?? NULL;

    if(!empty($facilities)){
    $facilitiesCount = count($facilities);
    $facilityUrl = "f=";

    for($i=0; $i < $facilitiesCount; $i++){
        $facilityUrl = $facilityUrl . $facilities[$i] . "+";
    }
    $facilityUrl = substr_replace($facilityUrl,"",-1) . "&";
    }

    $langs = $_POST['lang'] ?? NULL;

    if(!empty($langs)){
    $langsCount = count($langs);
    $langUrl = "l=";

    for($i=0; $i < $langsCount; $i++){
        $langUrl = $langUrl . $langs[$i] . "+";
    }
    $langUrl = substr_replace($langUrl,"",-1) . "&";
    }


    $finalUrl = ($typeUrl ?? "") . ($minPirceUrl ?? "") . ($maxPirceUrl ?? "") . ($facilityUrl ?? "") . ($langUrl ?? "");
    $finalUrl = substr_replace($finalUrl,"",-1);

    header('Location: /szallasok?' . $finalUrl);
}

function newAccmHandler()
{
    redirectToLoginIfNotLoggedIn();
    echo render('wrapper.php', [
        'content' => render('new-accm-page.php', [
            'accmTypes' => getAccmTypes(),
            'accmLangs' => getAccmLangs(),
            'accmFacilities' => getAccmFacilities(),
        ]),
        'activeLink' => '/szallasok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? NULL,
        'title' => "Új szállás",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function createAddressJson()
{
    return $address = json_encode(array(
        'postalCode' => $_POST['postalCode'],
        'street' => $_POST['street'],
        'number' => $_POST['number'],
        'building' => $_POST['building'],
        'floor' => $_POST['floor'],
        'door' => $_POST['door'],
    ), true);
}

function imageUpload()
{
    if(!empty($_FILES["fileToUpload"]["name"])){
        $targetDir = "public/uploads/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$targetFile);
        return $targetFile;
    }
}

function createAccmHandler()
{
    redirectToLoginIfNotLoggedIn();

    if(empty($_POST['name'])){
        urlRedirect("uj-szallas", [
            'info' => 'emptyName'
        ]);
    }

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
        //'image', 
        'contact_name', 
        'email', 
        'phone', 
        'webpage'
    ];
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
        json_encode($_POST['facilities'], true) ?? NULL,
        $_POST['description'] ?? NULL,
        json_encode($_POST['languages'], true) ?? NULL,
        //imageUpload() ?? NULL,
        $_POST["contactName"] ?? NULL,
        $_POST["contactEmail"] ?? NULL,
        $_POST["contactPhone"] ?? NULL,
        $_POST["webpage"] ?? NULL,
    ];

    $id = generateInsertSql($table, $columns, $execute);

    if(!empty($_FILES["fileToUpload"]["name"])){
        $table = "accm_images";
        $columns = [
            'accm_id',
            'path',
            'uploaded'
        ];
        $execute = [
            $id,
            imageUpload(),
            time(),
        ];
        generateInsertSql($table, $columns, $execute);
    }

    $table = "accm_meals";
    $columns = [
        'accm_id'
    ];
    $execute = [
        $id
    ];
    generateInsertSql($table, $columns, $execute);

    $table = "accm_wellness";
    $columns = [
        'accm_id'
    ];
    $execute = [
        $id
    ];
    generateInsertSql($table, $columns, $execute);

    $table = "accm_discounts";
    $columns = [
        'accm_id'
    ];
    $execute = [
        $id
    ];
    generateInsertSql($table, $columns, $execute);
    
    urlRedirect("szallasok/$slug", [
        'info' => 'added'
    ]);
}

function deleteAccmHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM accms
        WHERE id = ?');
    $statement->execute([$urlParams['accmId']]);

    urlRedirect('szallasok', [
        'info' => 'deleted'
    ]);
}

function accmPageHandler($urlParams)
{   
    $pdo = getConnection();
    $statement = $pdo->prepare(
        "SELECT a.*, ad.*, am.*, aw.*, at.name type, (SELECT ss.name FROM services_status ss WHERE ss.value = am.breakfast AND ss.category = 'meal') breakfast_hu_status, (SELECT ss.name FROM services_status ss WHERE ss.value = am.lunch AND ss.category = 'meal') lunch_hu_status, (SELECT ss.name FROM services_status ss WHERE ss.value = am.dinner AND ss.category = 'meal') dinner_hu_status
        FROM accms a
        LEFT JOIN accm_types at ON at.type_code = a.accm_type
        LEFT JOIN accm_discounts ad ON ad.accm_id = a.id
        LEFT JOIN accm_meals am ON am.accm_id = a.id
        LEFT JOIN accm_wellness aw ON aw.accm_id = a.id
        WHERE a.slug = ?"
    );
    $statement->execute([$urlParams['accmSlug']]);
    $accm = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_units
        WHERE accm_id = ?'
    );
    $statement->execute([$accm['id']]);
    $units = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_discounts ad
        WHERE ad.accm_id = ?'
    );
    $statement->execute([$accm['id']]);
    $discounts = $statement->fetch(PDO::FETCH_ASSOC);

    $wellnessFacilities = getServicesByCategory("wellness");
    $wellnessFacilityNames=[];
    foreach($wellnessFacilities as $wellnessFacility){
        if($accm[$wellnessFacility['value']] === "YES"){
            $wellnessFacilityNames[] = $wellnessFacility['name'];
        }
    }

    echo render("wrapper.php", [
        "content" => render("accm-page.php", [
            "accm" => $accm,
            "units" => $units,
            "address" => json_decode($accm['address'], true),
            "languages" => json_decode($accm['languages'], true),
            "facilities" => json_decode($accm['facilities'], true),
            "meals" => getServicesByCategory("meal"),
            "wellnessFacilityNames" => $wellnessFacilityNames,
            "discounts" => $discounts,
            "accmLangs" => getAccmLangs(),
            "accmTypes" => getAccmTypes(),
            "accmFacilities" => getAccmFacilities(),
            "resAccmId" => isset($_GET["res"]),
            "addImgToAccmId" => isset($_GET["addimage"]),
            'isAuthorized' => isLoggedIn(),
            'isAdmin' => isAdmin() ?? NULL,
            'info' => $_GET['info'] ?? NULL,
            'values' => json_decode(base64_decode($_GET['values'] ?? NULL), true)
        ]),
        "isAuthorized" => isLoggedIn(),
        "isAdmin" => isAdmin(),
        'activeLink' => '/szallasok',
        'title' => $accm['name'] . " " . $accm['location'],
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

?>