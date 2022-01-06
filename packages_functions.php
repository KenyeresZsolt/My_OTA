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
    $discountFilter = $_GET['disc'] ?? "";

    $types = explode(" ", $typeFilter);
    $cntTypes = count($types); 

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

    if(!empty($discountFilter)){
        $cond[] = 'p.discount > ?';
        $param[] = "0";
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
            "packages" => $packages,
            "accmTypes" => getAccmTypes(),
            'typeFilter' => $typeFilter,
            'minPriceFilter' => $minPriceFilter,
            'maxPriceFilter' => $maxPriceFilter,
            'discountFilter' => $discountFilter,
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

    if(!empty($_POST['discount'])){
        $discountUrl = "disc=" . $_POST['discount'] . "&";
    }

    $finalUrl = ($typeUrl ?? "") . ($minPirceUrl ?? "") . ($maxPirceUrl ?? "") . ($discountUrl ?? "");
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

function createPackageHandler()
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO packages (name, location, slug, address, accm_type, price, breakfast_price, discount, capacity, rooms, facilities, description, languages, contact_name, email, phone, webpage)
        VALUES (:name, :location, :slug, :address, :accm_type, :price, :breakfast_price, :discount, :capacity, :rooms, :facilities, :description, :languages, :contact_name, :email, :phone, :webpage)'
    );
    $statement->execute([
        'name' => $_POST["name"] ?? "", 
        'location' => $_POST["location"] ?? "", 
        'slug' => strtolower(slugify($_POST["name"] . "-" . $_POST["location"])) ?? "",
        'address' => createAddressJson() ?? "",
        'accm_type' => $_POST["type"] ?? "",
        'price' => $_POST["price"] ?? "",
        'breakfast_price' => $_POST["breakfastPrice"] ?? "",
        'discount' => $_POST["discount"] ?? "",
        'capacity' => $_POST["capacity"] ?? "",
        'rooms' => $_POST["rooms"] ?? "",
        'facilities' => json_encode($_POST['facilities'], true) ?? "",
        'description' => $_POST['description'] ?? "",
        'languages' => json_encode($_POST['languages'], true) ?? "",
        'contact_name' => $_POST["contactName"] ?? "",
        'email' => $_POST["contactEmail"] ?? "",
        'phone' => $_POST["contactPhone"] ?? "",
        'webpage' => $_POST["webpage"] ?? "",
    ]);
    
    header("Location: /csomagok?info=added");
}

function editPackageHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT p.*, at.name type, u.name modified_by_user_name
        FROM packages p
        LEFT JOIN accm_types at ON at.type_code = p.accm_type
        LEFT JOIN users u ON u.id = p.last_modified_by_user_id
        WHERE p.slug = ?'
    );
    $statement->execute([$urlParams['pckSlug']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);
    $address = json_decode($package['address'], true);
    $languages = json_decode($package['languages'], true);
    $facilities = json_decode($package['facilities'], true);
    
    echo render("wrapper.php", [
        'content' => render('edit-package-page.php', [
            'package' => $package,
            'address' => $address,
            'languages' => $languages,
            'facilities' => $facilities,
            'accmTypes' => getAccmTypes(),
            'accmLangs' => getAccmLangs(),
            'accmFacilities' => getAccmFacilities(),
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Szerkesztés",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

function updatePackageHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE packages
        SET name = :name, location = :location, slug = :slug, address = :address, accm_type = :accm_type, price = :price, breakfast_price = :breakfast_price, discount = :discount, capacity = :capacity, rooms = :rooms, facilities = :facilities, description = :description, languages = :languages, contact_name = :contact_name, email = :email, phone = :phone, webpage = :webpage, last_modified = :last_modified, last_modified_by_user_id = :last_modified_by_user_id
        WHERE id = :id'
    );
    $statement->execute([
        'name' => $_POST["name"] ?? "", 
        'location' => $_POST["location"] ?? "", 
        'slug' => strtolower(slugify($_POST["name"] . "-" . $_POST["location"])) ?? "",
        'address' => createAddressJson() ?? "",
        'accm_type' => $_POST["type"] ?? "",
        'price' => $_POST["price"] ?? "",
        'breakfast_price' => $_POST["breakfastPrice"] ?? "",
        'discount' => $_POST["discount"] ?? "",
        'capacity' => $_POST["capacity"] ?? "",
        'rooms' => $_POST["rooms"] ?? "",
        'facilities' => json_encode($_POST['facilities'], true) ?? "",
        'description' => $_POST['description'] ?? "",
        'languages' => json_encode($_POST['languages'], true) ?? "",
        'contact_name' => $_POST["contactName"] ?? "",
        'email' => $_POST["contactEmail"] ?? "",
        'phone' => $_POST["contactPhone"] ?? "",
        'webpage' => $_POST["webpage"] ?? "",
        'last_modified' => time() ?? "",
        'last_modified_by_user_id' => $_SESSION['userId'] ?? "",
        'id' => $urlParams['pckId'] ?? ""
    ]);

    $statement = $pdo->prepare(
        'SELECT *
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['pckId']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);
    
    header("Location: /csomagok/" . $package['slug'] . "?info=updated");
}

function uploadPckImageHandler($urlParams)

{
    redirectToLoginIfNotLoggedIn();
    $targetDir = "public/uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$targetFile);

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE packages
        SET image = ?
        WHERE id = ?'
    );
    $statement->execute([
        $targetFile,
        $urlParams['pckId']
    ]);

    $statement = $pdo->prepare(
        'SELECT *
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['pckId']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);

    header("Location: /csomagok/" . $package['slug'] . "?info=updated");

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