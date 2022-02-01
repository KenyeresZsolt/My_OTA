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

    $destFilter = $_GET['destination'] ?? NULL;
    $checkinFilter = $_GET['ci'] ?? NULL;
    $checkoutFilter = $_GET['co'] ?? NULL;
    $adultsFilter = $_GET['adults'] ?? NULL;
    $childrenFilter = $_GET['children'] ?? NULL;
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

    if(!empty($destFilter)){
        $dcond[] = 'a.name LIKE ?';
        $dcond[] = 'a.location LIKE ?';
        $param[] = "%" . $destFilter . "%";
        $param[] = "%" . $destFilter . "%";

        $cond[] = "(" . implode(" OR ", $dcond) . ")";
    }

    if(!empty($typeFilter)){
        for($i=0; $i<$cntTypes; $i++){
            $tcond[] = 'a.accm_type = ?';
            $param[] = $types[$i];
        }
        $cond[] = "(" . implode(" OR ", $tcond) . ")";
    }

    if(!empty($minPriceFilter)){
        $cond[] = 'a.price > ?';
        $param[] = $minPriceFilter;
    }

    if(!empty($maxPriceFilter)){
        $cond[] = 'a.price < ?';
        $param[] = $maxPriceFilter;
    }

    if(!empty($facilityFilter)){
        for($i=0; $i<$cntFacilities; $i++){
            $fcond[] = 'a.facilities LIKE ?';
            $param[] = "%" . $facilities[$i] . "%";
        }
        $cond[] = "(" . implode(" OR ", $fcond) . ")";
    }

    if(!empty($langFilter)){
        for($i=0; $i<$cntLangs; $i++){
            $lcond[] = 'a.languages LIKE ?';
            $param[] = "%" . $langs[$i] . "%";
        }
        $cond[] = "(" . implode(" OR ", $lcond) . ")";
    }

    $sql = "SELECT * from accms a";

    if($cond)
    {
        $sql .= " WHERE " . implode(" AND ", $cond);
    }

    /*echo "<pre>";
    echo $sql . "<br>";
    var_dump($param);
    exit;*/


    $pdo = getConnection();
    $statement = $pdo->prepare($sql);
    $statement->execute($param);
    $accms = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        "SELECT *
        FROM accm_images ai
        WHERE ai.is_primary = 'YES'"
    );
    $statement->execute();
    $images = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo render('wrapper.php', [
        'content' => render("accm-list.php", [
            'accms' => $accms,
            'images' => $images,
            'accmTypes' => getAccmTypes(),
            'accmFacilities' => getAccmFacilities(),
            'accmLangs' => getAccmLangs(),
            'destFilter' => $destFilter,
            'checkinFilter' => $checkinFilter,
            'checkoutFilter' => $checkoutFilter,
            'adultsFilter'=> $adultsFilter,
            'childrenFilter' => $childrenFilter,
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
    $destination = $_POST['destination'] ?? NULL;

    if(!empty($destination)){
        $destUrl = "destination=" . $_POST['destination'] . "&";
    }

    $checkin = $_POST['checkin'] ?? NULL;

    if(!empty($checkin)){
        $checkinUrl = "ci=" . $_POST['checkin'] . "&";
    }

    $checkout = $_POST['checkout'] ?? NULL;

    if(!empty($checkout)){
        $checkoutUrl = "co=" . $_POST['checkout'] . "&";
    }

    $adults = $_POST['adults'] ?? NULL;

    if(!empty($adults)){
        $adultsUrl = "adults=" . $_POST['adults'] . "&";
    }

    $children = $_POST['children'] ?? NULL;

    if(!empty($children)){
        $childrenUrl = "children=" . $_POST['children'] . "&";
    }
    
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


    $finalUrl = ($destUrl ?? "") . ($checkinUrl ?? "") . ($checkoutUrl ?? "") . ($adultsUrl ?? "") . ($childrenUrl ?? "") . ($typeUrl ?? "") . ($minPirceUrl ?? "") . ($maxPirceUrl ?? "") . ($facilityUrl ?? "") . ($langUrl ?? "");
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

function transformToSingleImages($rawFiles)
{
    $ret = [];
    for($i = 0; $i < count($rawFiles['name']); $i++){
        $ret[] = [
            'name' => $rawFiles['name'][$i],
            'type' => $rawFiles['type'][$i],
            'tmp_name' => $rawFiles['tmp_name'][$i],
            'size' => $rawFiles['size'][$i],
            'error' => $rawFiles['error'][$i],
        ];
    }

    return $ret;
}

function saveImage($image)
{
    $whitelist = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];
    if(!in_array(exif_imagetype($image['tmp_name']), $whitelist)){
        return false;
    }

    $targetDir = "public/uploads/";
    $targetFile = $targetDir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    
    move_uploaded_file($image["tmp_name"],$targetFile);
    return $targetFile;

}

function imageUploadHandler($accmId)
{
    if(!empty($_FILES["image"]["name"]['0'])){
        $images = transformToSingleImages($_FILES["image"]);
        $targetFiles = [];
        foreach($images as $image){
            $targetFiles[] = saveImage($image);
        }

        foreach($targetFiles as $targetFile){
            $table = "accm_images";
            $columns = [
                'accm_id',
                'path',
                'uploaded',
            ];
            $execute = [
                $accmId,
                $targetFile,
                time(),
            ];
            generateInsertSql($table, $columns, $execute);
        }
    }    
}

/*function imageUpload()
{
    if(!empty($_FILES["fileToUpload"]["name"])){
        $targetDir = "public/uploads/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$targetFile);
        return $targetFile;
    }
}*/ //régi

function createAccmHandler()
{
    redirectToLoginIfNotLoggedIn();

    if(empty($_POST['name'])){
        urlRedirect("uj-szallas", [
            'info' => 'emptyName'
        ]);
    }

    /*echo "<pre>";
    var_dump($_FILES["image"]);
    exit;*/

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
        $_POST["contactName"] ?? NULL,
        $_POST["contactEmail"] ?? NULL,
        $_POST["contactPhone"] ?? NULL,
        $_POST["webpage"] ?? NULL,
    ];

    $id = generateInsertSql($table, $columns, $execute);

    if(!empty($_FILES["image"]["name"]['0'])){
        $table = "accm_images";
        $columns = [
            'accm_id',
            'path',
            'uploaded'
        ];
        $execute = [
            $id,
            imageUploadHandler($id),
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
        FROM accm_images ai
        WHERE ai.accm_id = ?'
    );
    $statement->execute([$accm['id']]);
    $images = $statement->fetchAll(PDO::FETCH_ASSOC);

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
            "images" =>$images,
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
            'values' => json_decode(base64_decode($_GET['values'] ?? NULL), true),
            'resDetails' => json_decode(base64_decode($_GET['details'] ?? NULL), true)
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