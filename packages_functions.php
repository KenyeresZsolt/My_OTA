<?php

function packageListHandler()
{

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        from packages');
    $statement->execute();
    $packages = $statement->fetchAll(PDO::FETCH_ASSOC);

    $newPackage = isset($_GET["add"]);
    $isAdded = isset($_GET["added"]);
    $isUpdated = isset($_GET["updated"]);
    $isDeleted = isset($_GET["deleted"]);
    $isReserved = isset($_GET["reserved"]);

    $packagesListTemplate = compileTemplate("pck-list.php", [
        "packages" => $packages,
        "isAdded" => $isAdded,
        "isUpdated" => $isUpdated,
        "isDeleted" => $isDeleted,
        "isReserved" => $isReserved,
        "newPackage" => $newPackage,
        "updatePackageId" => $_GET["edit"] ?? "",
        "resPackageId" => $_GET["res"] ?? "",
        "addImgToPckId" => $_GET["addimage"] ?? "",
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

function createPackageHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO packages (name, location, slug, price)
        VALUES (?, ?, ?, ?)'
    );
    $statement->execute([
        $_POST["name"], 
        $_POST["location"], 
        strtolower(slugify($_POST["name"] . "-" . $_POST["location"])),
        $_POST["price"]
    ]);
    
    header("Location: /csomagok?added=1");
}

function updatePackageHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE packages
        SET name = ?, location = ?, slug = ?, price = ?, discount = ?, disc_price = ?, description = ?
        WHERE id = ?'
    );
    $statement->execute([
        $_POST['name'],
        $_POST['location'],
        strtolower(slugify($_POST["name"] . "-" . $_POST["location"])),
        $_POST['price'],
        $_POST['discount'],
        empty($_POST["discount"]) ? "" : ($_POST["price"]-(($_POST["price"]*$_POST["discount"])/100)),
        $_POST['description'],
        $urlParams['pckId']
    ]);
    
    header("Location: /csomagok?updated=1");
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

    $header= "Location: /csomagok?updated=1&href=#" . $_GET['id'];

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

    header("Location: /csomagok?deleted=1");
}

function packagePageHandler($slug)
{   
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM packages p
        WHERE p.slug = ?'
    );
    $statement->execute([$slug['pckSlug']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);
    
    echo compileTemplate("wrapper.php", [
        "innerTemplate" => compileTemplate("pck-page.php", [
            "package" => $package,
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