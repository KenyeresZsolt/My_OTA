<?php

function getAccmTypes()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_types'
    );
    $statement->execute();
    return $accmTypes = $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAccmLangs()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_languages'
    );
    $statement->execute();
    return $accmLangs = $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAccmFacilities()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM accm_facilities'
    );
    $statement->execute();
    return $accmFacilities = $statement->fetchAll(PDO::FETCH_ASSOC);
}

function packageListHandler()
{
    //szűrő forrása: https://phpdelusions.net/pdo_examples/dynamical_where

    $typeFilter = $_GET['t'] ?? "";
    $minPriceFilter = $_GET['minPrice'] ?? "";
    $maxPriceFilter = $_GET['maxPrice'] ?? "";
    $facilityFilter = $_GET['f'] ?? "";
    $langFilter = $_GET['l'] ?? "";

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

    $sql = "SELECT * from packages p";

    if($cond)
    {
        $sql .= " WHERE " . implode(" AND ", $cond);
    }

    $pdo = getConnection();
    $statement = $pdo->prepare($sql);
    $statement->execute($param);
    $packages = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo render('wrapper.php', [
        'content' => render("pck-list.php", [
            'packages' => $packages,
            'accmTypes' => getAccmTypes(),
            'accmFacilities' => getAccmFacilities(),
            'accmLangs' => getAccmLangs(),
            'typeFilter' => $typeFilter,
            'minPriceFilter' => $minPriceFilter,
            'maxPriceFilter' => $maxPriceFilter,
            'facilityFilter' => $facilityFilter,
            'langFilter' => $langFilter,
            "info" => $_GET['info'] ?? "",
            'isAuthorized' => isLoggedIn(),
            'isAdmin' => isAdmin() ?? "",
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Csomagok",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

function packageFilterHandler()
{
    $types = $_POST['type'] ?? "";

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

    $facilities = $_POST['facility'] ?? "";

    if(!empty($facilities)){
    $facilitiesCount = count($facilities);
    $facilityUrl = "f=";

    for($i=0; $i < $facilitiesCount; $i++){
        $facilityUrl = $facilityUrl . $facilities[$i] . "+";
    }
    $facilityUrl = substr_replace($facilityUrl,"",-1) . "&";
    }

    $langs = $_POST['lang'] ?? "";

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

    header('Location: /csomagok?' . $finalUrl);
}

function newPackageHandler()
{
    redirectToLoginIfNotLoggedIn();
    echo render('wrapper.php', [
        'content' => render('new-package-page.php', [
            'accmTypes' => getAccmTypes(),
            'accmLangs' => getAccmLangs(),
            'accmFacilities' => getAccmFacilities(),
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Új csomag",
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

function createPackageHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO packages (name, location, slug, address, accm_type, price, discount, capacity, rooms, bathrooms, facilities, description, languages, image, contact_name, email, phone, webpage)
        VALUES (:name, :location, :slug, :address, :accm_type, :price, :discount, :capacity, :rooms, :bathrooms, :facilities, :description, :languages, :image, :contact_name, :email, :phone, :webpage)'
    );
    $statement->execute([
        'name' => $_POST["name"] ?? "", 
        'location' => $_POST["location"] ?? "", 
        'slug' => strtolower(slugify($_POST["name"] . "-" . $_POST["location"])) ?? "",
        'address' => createAddressJson() ?? "",
        'accm_type' => $_POST["type"] ?? "",
        'price' => $_POST["price"] ?? "",
        'discount' => $_POST["discount"] ?? "",
        'capacity' => $_POST["capacity"] ?? "",
        'rooms' => $_POST["rooms"] ?? "",
        'bathrooms' => $_POST["bathrooms"] ?? "",
        'facilities' => json_encode($_POST['facilities'], true) ?? "",
        'description' => $_POST['description'] ?? "",
        'languages' => json_encode($_POST['languages'], true) ?? "",
        'image' => imageUpload() ?? "",
        'contact_name' => $_POST["contactName"] ?? "",
        'email' => $_POST["contactEmail"] ?? "",
        'phone' => $_POST["contactPhone"] ?? "",
        'webpage' => $_POST["webpage"] ?? "",
    ]);
    
    header("Location: /csomagok?info=added");
}

function deletePackageHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM packages
        WHERE id = ?');
    $statement->execute([$urlParams['pckId']]);

    header("Location: /csomagok?info=deleted");
}

function packagePageHandler($slug)
{   
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT p.*, at.name type
        FROM packages p
        LEFT JOIN accm_types at ON at.type_code = p.accm_type
        WHERE p.slug = ?'
    );
    $statement->execute([$slug['pckSlug']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);

    echo render("wrapper.php", [
        "content" => render("pck-page.php", [
            "package" => $package,
            "address" => json_decode($package['address'], true),
            "languages" => json_decode($package['languages'], true),
            "facilities" => json_decode($package['facilities'], true),
            "accmLangs" => getAccmLangs(),
            "accmTypes" => getAccmTypes(),
            "accmFacilities" => getAccmFacilities(),
            "resPackageId" => isset($_GET["res"]),
            "addImgToPckId" => isset($_GET["addimage"]),
            'isAuthorized' => isLoggedIn(),
            'isAdmin' => isAdmin() ?? "",
            'info' => $_GET['info'] ?? "",
            'values' => json_decode(base64_decode($_GET['values'] ?? ''), true)
        ]),
        "isAuthorized" => isLoggedIn(),
        "isAdmin" => isAdmin(),
        'activeLink' => '/csomagok',
        'title' => $package['name'] . " " . $package['location'],
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

?>