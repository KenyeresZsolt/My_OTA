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

function packageListHandler()
{
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

    $packagesListTemplate = compileTemplate("pck-list.php", [
        "packages" => $packages,
        "accmTypes" => getAccmTypes(),
        'typeFilter' => $typeFilter,
        'minPriceFilter' => $minPriceFilter,
        'maxPriceFilter' => $maxPriceFilter,
        'discountFilter' => $discountFilter,
        "info" => $_GET['info'] ?? "",
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
    ]);
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => $packagesListTemplate,
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Csomagok",
        'unreadMessages' => countUnreadMessages()
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
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => compileTemplate('new-package-page.php', [
            "accmTypes" => getAccmTypes(),
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Új csomag",
        'unreadMessages' => countUnreadMessages()
    ]);
}

function createPackageHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO packages (name, location, slug, accm_type, price, discount, disc_price, description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $statement->execute([
        $_POST["name"], 
        $_POST["location"], 
        strtolower(slugify($_POST["name"] . "-" . $_POST["location"])),
        $_POST["type"],
        $_POST["price"],
        $_POST["discount"],
        empty($_POST["discount"]) ? "" : ($_POST["price"]-(($_POST["price"]*$_POST["discount"])/100)),
        $_POST['description'],
    ]);
    
    header("Location: /csomagok?info=added");
}

function updatePackageHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE packages
        SET name = ?, location = ?, slug = ?, accm_type = ?, price = ?, discount = ?, disc_price = ?, description = ?
        WHERE id = ?'
    );
    $statement->execute([
        $_POST['name'],
        $_POST['location'],
        strtolower(slugify($_POST["name"] . "-" . $_POST["location"])),
        $_POST['type'],
        $_POST['price'],
        $_POST['discount'],
        empty($_POST["discount"]) ? "" : ($_POST["price"]-(($_POST["price"]*$_POST["discount"])/100)),
        $_POST['description'],
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

    $header= "Location: /csomagok/" . $package['slug'] . "?info=updated";

    header($header);

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
        LEFT JOIN accm_types at ON at.typeCode = p.accm_type
        WHERE p.slug = ?'
    );
    $statement->execute([$slug['pckSlug']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);

    echo compileTemplate("wrapper.php", [
        "innerTemplate" => compileTemplate("pck-page.php", [
            "package" => $package,
            "accmTypes" => getAccmTypes(),
            "updatePackageId" => isset($_GET["edit"]),
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
        'unreadMessages' => countUnreadMessages()
    ]);

}

?>