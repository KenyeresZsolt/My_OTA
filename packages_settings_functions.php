<?php

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
        'content' => render('pck-settings-page.php', [
            'settingsContent' => render('edit-package-page.php', [
                'info' => $_GET['info'] ?? "",
                'package' => $package,
                'address' => $address,
                'languages' => $languages,
                'facilities' => $facilities,
                'accmTypes' => getAccmTypes(),
                'accmLangs' => getAccmLangs(),
                'accmFacilities' => getAccmFacilities(),
            ]),
            'package' => $package,
            'activeTab' => 'edit',
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
        'SELECT *
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['pckId']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);
    
    $statement = $pdo->prepare(
        'UPDATE packages
        SET name = :name, location = :location, slug = :slug, address = :address, accm_type = :accm_type, price = :price, capacity = :capacity, rooms = :rooms, bathrooms = :bathrooms, facilities = :facilities, description = :description, languages = :languages, image = :image, contact_name = :contact_name, email = :email, phone = :phone, webpage = :webpage, last_modified = :last_modified, last_modified_by_user_id = :last_modified_by_user_id
        WHERE id = :id'
    );
    $statement->execute([
        'name' => $_POST["name"] ?? "", 
        'location' => $_POST["location"] ?? "", 
        'slug' => strtolower(slugify($_POST["name"] . "-" . $_POST["location"])) ?? "",
        'address' => createAddressJson() ?? "",
        'accm_type' => $_POST["type"] ?? "",
        'price' => $_POST["price"] ?? "",
        'capacity' => $_POST["capacity"] ?? "",
        'rooms' => $_POST["rooms"] ?? "",
        'bathrooms' => $_POST["bathrooms"] ?? "",
        'facilities' => json_encode($_POST['facilities'], true) ?? "",
        'description' => $_POST['description'] ?? "",
        'languages' => json_encode($_POST['languages'], true) ?? "",
        'image' => imageUpload() ?? $package['image'],
        'contact_name' => $_POST["contactName"] ?? "",
        'email' => $_POST["contactEmail"] ?? "",
        'phone' => $_POST["contactPhone"] ?? "",
        'webpage' => $_POST["webpage"] ?? "",
        'last_modified' => time() ?? "",
        'last_modified_by_user_id' => $_SESSION['userId'] ?? "",
        'id' => $urlParams['pckId'] ?? ""
    ]);
   
    header("Location: /csomagok/" . $package['slug'] . "/beallitasok/adatok?info=updated");
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
        'SELECT p.*, at.name type, u.name modified_by_user_name
        FROM packages p
        LEFT JOIN accm_types at ON at.type_code = p.accm_type
        LEFT JOIN users u ON u.id = p.last_modified_by_user_id
        WHERE p.slug = ?'
    );
    $statement->execute([$urlParams['pckSlug']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);
    $mealDetails = json_decode($package['meal_details'], true);
    $wellnessDetails = json_decode($package['wellness_details'], true);

    echo render("wrapper.php", [
        'content' => render('pck-settings-page.php', [
            'settingsContent' => render("edit-services-page.php", [
                'info' => $_GET['info'] ?? "",
                'package' => $package,
                'mealDetails' => $mealDetails,
                'meals' => getServicesByCategory("meal"),
                'mealsStatus' => getServicesStatusByCategory("meal"),
                'wellnessDetails' => $wellnessDetails,
                'wellnessFacilities' => getServicesByCategory("wellness"),
                'wellnessStatus' => getServicesStatusByCategory("wellness"),
            ]),
            'package' => $package,
            'activeTab' => 'services',
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
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
        'SELECT *
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['pckId']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);

    if($_POST['mealOffered'] === "NO"){
        $_POST['breakfast'] = "NOTPROVIDED";
        $_POST['lunch'] = "NOTPROVIDED";
        $_POST['dinner'] = "NOTPROVIDED";
    }

    if(($_POST['breakfast'] === "PAYABLE" AND  empty($_POST['breakfastPrice'])) OR ($_POST['lunch'] === "PAYABLE" AND  empty($_POST['lunchPrice'])) OR ($_POST['dinner'] === "PAYABLE" AND  empty($_POST['dinnerPrice']))){
        return header('Location: /csomagok/' . $package['slug'] . '/beallitasok/szolgaltatasok?info=mealsEmptyPrice#editMealsMessage'); 
    }

    if($_POST['mealOffered'] === "YES" AND $_POST['breakfast'] === "NOTPROVIDED" AND $_POST['lunch'] === "NOTPROVIDED" AND $_POST['dinner'] === "NOTPROVIDED"){
        return header('Location: /csomagok/' . $package['slug'] . '/beallitasok/szolgaltatasok?info=mealsNotSpecified#editMealsMessage'); 
    }

    if($_POST['breakfast'] !== "PAYABLE"){
        $_POST['breakfastPrice'] ="";
    }
    if($_POST['lunch'] !== "PAYABLE"){
        $_POST['lunchPrice'] ="";
    }
    if($_POST['dinner'] !== "PAYABLE"){
        $_POST['dinnerPrice'] ="";
    }

    $mealDetails = json_encode($_POST, true);

    $statement = $pdo->prepare(
        'UPDATE packages
        SET meal_offered = ?, meal_details= ?, breakfast= ?, breakfast_price = ?, lunch = ?, lunch_price = ?, dinner = ?, dinner_price= ?, last_modified = ?, last_modified_by_user_id = ?
        WHERE id = ?');
    $statement->execute([
        $_POST['mealOffered'],
        $mealDetails,
        $_POST['breakfast'],
        $_POST['breakfastPrice'],
        $_POST['lunch'],
        $_POST['lunchPrice'],
        $_POST['dinner'],
        $_POST['dinnerPrice'],
        time() ?? "",
        $_SESSION['userId'] ?? "",
        $urlParams['pckId'],
    ]);

    header('Location: /csomagok/' . $package['slug'] . '/beallitasok/szolgaltatasok?info=mealsUpdated#editMealsMessage');

}

function updateWellnessHandler($urlParams)
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['pckId']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);

    if($_POST['wellnessOffered'] === "NO"){
        $_POST['wellnessFacilities'] = "";
        $_POST['wellnessStatus'] = "NOTPROVIDED";
        $_POST['wellnessPrice'] = "0";
    }

    if($_POST['wellnessStatus'] === "PAYABLE" AND empty($_POST['wellnessPrice'])){
        return header('Location: /csomagok/' . $package['slug'] . '/beallitasok/szolgaltatasok?info=wellnessEmptyPrice#editWellnessMessage'); 
    }

    if($_POST['wellnessOffered'] === "YES" AND (!isset($_POST['wellnessFacilities']) OR empty($_POST['wellnessFacilities']) OR !isset($_POST['wellnessStatus']) OR empty($_POST['wellnessStatus']))){
        return header('Location: /csomagok/' . $package['slug'] . '/beallitasok/szolgaltatasok?info=wellnessFacilitiesNotSpecified#editWellnessMessage'); 
    }

    $wellnessDetails = json_encode($_POST, true);

    $statement = $pdo->prepare(
        'UPDATE packages
        SET wellness_offered = ?, wellness_details= ?, last_modified = ?, last_modified_by_user_id = ?
        WHERE id = ?');
    $statement->execute([
        $_POST['wellnessOffered'],
        $wellnessDetails,
        time() ?? "",
        $_SESSION['userId'] ?? "",
        $urlParams['pckId'],
    ]);

    header('Location: /csomagok/' . $package['slug'] . '/beallitasok/szolgaltatasok?info=wellnessUpdated#editWellnessMessage');
}

function editDiscountsHandler($urlParams)
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
    $discounts = json_decode($package['discounts'], true);

    echo render("wrapper.php", [
        'content' => render('pck-settings-page.php', [
            'settingsContent' => render('edit-discounts-page.php', [
                'package' => $package,
                'discounts' => $discounts,
            ]),
            'package' => $package,
            'activeTab' => 'discounts',
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
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
        FROM packages p
        WHERE p.id = ?'
    );
    $statement->execute([$urlParams['pckId']]);
    $package = $statement->fetch(PDO::FETCH_ASSOC);

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
            return header('Location: /csomagok/' . $package['slug'] . '/beallitasok/kedvezmenyek?info=emptyValue');
        }

    $discounts = json_encode($_POST, true);

    $statement = $pdo->prepare(
        'UPDATE packages
        SET discounts = ?, last_modified = ?, last_modified_by_user_id = ?
        WHERE id = ?'
    );
    $statement->execute([
        $discounts,
        time() ?? "",
        $_SESSION['userId'] ?? "",
        $urlParams['pckId'],
    ]);

    header('Location: /csomagok/' . $package['slug'] . '/beallitasok/kedvezmenyek?info=updated');
}

function editRoomsHandler($urlParams)
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

    echo render("wrapper.php", [
        'content' => render('pck-settings-page.php', [
            'settingsContent' => render("coming-soon-page.php"),
            'package' => $package,
            'activeTab' => 'rooms',
        ]),
        'activeLink' => '/csomagok',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Szobák",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

?>