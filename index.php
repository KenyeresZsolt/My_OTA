<?php

require './router.php';
require './slugifier.php';
require './functions_db.php';

$method = $_SERVER["REQUEST_METHOD"];
$parsed = parse_url($_SERVER['REQUEST_URI']);
$path = $parsed['path'];

$routes = [
    ['GET', '/bejelentkezes' , 'subsFormHandler'],
    ['GET', '/' , 'homeHandler'],
    ['GET', '/csomagok' , 'packageListHandler'],
    ['GET', '/uj-csomag' , 'newPackageHandler'],
    ['GET', '/csomagok/{pckSlug}' , 'packagePageHandler'],
    ['GET', '/{pckSlug}/beallitasok/adatok' , 'editPackageHandler'],
    ['GET', '/{pckSlug}/beallitasok/szolgaltatasok' , 'editServicesHandler'],
    ['GET', '/{pckSlug}/beallitasok/kedvezmenyek' , 'editDiscountsHandler'],
    ['GET', '/{pckSlug}/beallitasok/szobak' , 'editRoomsHandler'],
    ['GET', '/foglalasok' , 'reservationListHandler'],
    ['GET', '/chat' , 'chatPageHandler'],
    ['GET', '/profil' , 'profilHandler'],
    ['GET', '/felhasznalok' , 'userListHandler'],
    ['GET', '/kapcsolat' , 'contactPageHandler'],
    ['POST', '/registration' , 'registrationHandler'],
    ['POST', '/login' , 'loginHandler'],
    ['POST', '/bejelentkezes' , 'subsFormHandler'],
    ['POST', '/kijelentkezes' , 'logoutHandler'],
    ['POST', '/csomagok' , 'packageFilterHandler'],
    ['POST', '/add-package' , 'createpackageHandler'],
    ['POST', '/delete-package/{pckId}' , 'deletePackageHandler'],
    ['POST', '/update-package/{pckId}' , 'updatePackageHandler'],
    ['POST', '/reserve-package/{pckId}' , 'reservePackageHandler'],
    ['POST', '/update-reservation' , 'updateReservationHandler'],
    ['POST', '/cancel-reservation' , 'cancelReservationHandler'],
    ['POST', '/delete-reservation' , 'deleteReservationHandler'],
    ['POST', '/update-profil' , 'updateProfilHandler'],
    ['POST', '/add-user' , 'createUserHandler'],
    ['POST', '/update-user' , 'updateUserHandler'],
    ['POST', '/delete-user' , 'deleteUserHandler'],
    ['POST', '/new-conversation' , 'newConversationHandler'],
    ['POST', '/delete-conversation' , 'deleteConversationHandler'],
    ['POST', '/send-message' , 'sendMessageHandler'],
    ['POST', '/add-member' , 'addMemberHandler'],
    ['POST', '/delete-member' , 'deleteMemberHandler'],
    ['POST', '/submit-mail' , 'submitMailHandler'],
];

$dispatch = registerRoutes($routes);
$matchedRoute = $dispatch($method, $path);
$handlerFunction = $matchedRoute['handler'];
$handlerFunction($matchedRoute['vars']);

/*Régi útvonalválasztó
$routes = [
    "GET" => [
        "/bejelentkezes" =>'subsFormHandler',
        "/" => "homeHandler",
        "/hero" => "heroListHandler",
        "/csomagok" => "packageListHandler",
        "/foglalasok" => "reservationListHandler",
        "/sakktabla" => "chessHandler",
        "/chat" => "chatPageHandler",
        "/profil" => "profilHandler",
        "/felhasznalok" => "userListHandler"
    ],
    "POST" => [
        "/registration" => 'registrationHandler',
        "/login" => 'loginHandler',
        "/bejelentkezes" =>'subsFormHandler',
        "/kijelentkezes" => 'logoutHandler',
        "/hero" => "createHeroHandler",
        "/delete-hero" => "deleteHeroHandler",
        "/update-hero" =>"updateHeroHandler",
        "/csomagok" => "createpackageHandler",
        "/delete-package" => "deletePackageHandler",
        "/update-package" => "updatePackageHandler",
        "/reserve-package" => "reservePackageHandler",
        "/upload-pck-image" => "uploadPckImageHandler",
        "/update-reservation" => "updateReservationHandler",
        "/delete-reservation" => "deleteReservationHandler",
        "/profil" => "profilHandler",
        "/add-user" => "createUserHandler",
        "/update-user" => "updateUserHandler",
        "/delete-user" => "deleteUserHandler",
        "/new-conversation" => "newConversationHandler",
        "/delete-conversation" => "deleteConversationHandler",
        "/send-message" => "sendMessageHandler",
        "/add-member" => "addMemberHandler",
        "/delete-member" => "deleteMemberHandler"
    ]
];

require "./functions_db.php";

$handlerFunction = $routes[$method][$path] ?? "notFoundHandler";

$safeHandlerFunction = function_exists($handlerFunction) ? $handlerFunction : "notFoundHandler";

$safeHandlerFunction();
*/

/*
Megnevezések:
- adatbázisban: oszlop_nev; tabla_nev
- fájlrendszerben: fuggvenyes_fajl_nev.php; view-fajl-nev.php 
- változók, függvények: $valtozoNev; fuggvenyNev()
*/

/*

Kérdések:

- http://localhost:1012/csomagok - itt az Új csomag gomb az egész sorban kattintható, míg a többi gomb nem. Ugyanolyan a formázásuk. Honnan jön a különbség?
- updateProfilHandler() - hogyha nem akarom a jelszót megváltoztatni (tehát üresen hagyom a mezőt), akkor felülírja a jelszót az üres mezővel. Jól oldottam meg, hogy ne írja felül?
- hogyan működik a router.php?
- pck-lis.php-ban strpos() függvény használata a checkboxoknál. Így biztos nem jó, hogy lehetne egyszerűbben?
- deleteConversationHandler() - lehetne-e mindent egyszerre törölni?
- SQL-ben aliasokat csak SELECT esetén lehet adni, pl DELETE-nél nem?

*/
?>