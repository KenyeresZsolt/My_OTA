<?php

require './router.php';
require './slugifier.php';
require './functions_db.php';

$method = $_SERVER['REQUEST_METHOD'];
$parsed = parse_url($_SERVER['REQUEST_URI']);
$path = $parsed['path'];

$routes = [
    ['GET', '/bejelentkezes' , 'subsFormHandler'],
    ['GET', '/' , 'homeHandler'],
    ['GET', '/szallasok' , 'accmListHandler'],
    ['GET', '/uj-szallas' , 'newAccmHandler'],
    ['GET', '/szallasok/{accmSlug}' , 'accmPageHandler'],
    ['GET', '/szallasok/{accmSlug}/beallitasok/adatok' , 'editAccmHandler'],
    ['GET', '/szallasok/{accmSlug}/beallitasok/szolgaltatasok' , 'editServicesHandler'],
    ['GET', '/szallasok/{accmSlug}/beallitasok/kedvezmenyek' , 'editDiscountsHandler'],
    ['GET', '/szallasok/{accmSlug}/beallitasok/szobak' , 'unitListHandler'],
    ['GET', '/szallasok/{accmSlug}/beallitasok/szobak/uj-szoba' , 'newUnitHandler'],
    ['GET', '/szallasok/{accmSlug}/beallitasok/szobak/szoba-szerkesztese/{unitId}' , 'editUnitHandler'],
    ['GET', '/foglalasok', 'reservationListHandler'],
    ['GET', '/foglalasok/{resId}', 'reservationPageHandler'],
    ['GET', '/chat' , 'chatPageHandler'],
    ['GET', '/profil' , 'profilHandler'],
    ['GET', '/felhasznalok' , 'userListHandler'],
    ['GET', '/kapcsolat' , 'contactPageHandler'],
    ['POST', '/registration' , 'registrationHandler'],
    ['POST', '/login' , 'loginHandler'],
    ['POST', '/bejelentkezes' , 'subsFormHandler'],
    ['POST', '/kijelentkezes' , 'logoutHandler'],
    ['POST', '/filter-accms' , 'accmFilterHandler'],
    ['POST', '/add-accm' , 'createAccmHandler'],
    ['POST', '/delete-accm/{accmId}' , 'deleteAccmHandler'],
    ['POST', '/update-accm/{accmId}' , 'updateAccmHandler'],
    ['POST', '/update-meals/{accmId}' , 'updateMealsHandler'],
    ['POST', '/update-wellness/{accmId}' , 'updateWellnessHandler'],
    ['POST', '/update-discounts/{accmId}' , 'updateDiscountsHandler'],
    ['POST', '/add-unit/{accmId}' , 'createUnitHandler'],
    ['POST', '/update-unit/{unitId}' , 'updateUnitHandler'],
    ['POST', '/delete-unit/{unitId}' , 'deleteUnitHandler'],
    ['POST', '/best-offer/{accmId}', 'calculateBestOfferHandler'],
    ['POST', '/calculate-price/{accmId}' , 'calculatePriceHandler'],
    ['POST', '/reserve-accm/{accmId}' , 'reserveAccmHandler'],
    ['POST', '/update-reservation' , 'updateReservationHandler'],
    ['POST', '/cancel-reservation' , 'cancelReservationHandler'],
    ['POST', '/delete-reservation/{resId}' , 'deleteReservationHandler'],
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
    ['POST', '/send-mails' , 'sendMailsHandler'],
];

$dispatch = registerRoutes($routes);
$matchedRoute = $dispatch($method, $path);
$handlerFunction = $matchedRoute['handler'];
$handlerFunction($matchedRoute['vars']);

/*R??gi ??tvonalv??laszt??
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
Megnevez??sek:
- adatb??zisban: oszlop_nev; tabla_nev
- f??jlrendszerben: fuggvenyes_fajl_nev.php; view-fajl-nev.php 
- v??ltoz??k, f??ggv??nyek: $valtozoNev; fuggvenyNev()
*/

/*

K??rd??sek:

- updateProfilHandler() - hogyha nem akarom a jelsz??t megv??ltoztatni (teh??t ??resen hagyom a mez??t), akkor fel??l??rja a jelsz??t az ??res mez??vel. J??l oldottam meg, hogy ne ??rja fel??l?
- pck-lis.php-ban strpos() f??ggv??ny haszn??lata a checkboxokn??l. ??gy biztos nem j??, hogy lehetne egyszer??bben?
- deleteConversationHandler() - lehetne-e mindent egyszerre t??r??lni? - adatb??zisban kapcsoljam ??ssze a t??bl??kat

*/
?>