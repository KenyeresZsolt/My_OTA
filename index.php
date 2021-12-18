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
    ['GET', '/hero' , 'heroListHandler'],
    ['GET', '/csomagok' , 'packageListHandler'],
    ['GET', '/csomagok/{pckSlug}' , 'packagePageHandler'],
    ['GET', '/foglalasok' , 'reservationListHandler'],
    ['GET', '/sakktabla' , 'chessHandler'],
    ['GET', '/chat' , 'chatPageHandler'],
    ['GET', '/profil' , 'profilHandler'],
    ['GET', '/felhasznalok' , 'userListHandler'],
    ['GET', '/kapcsolat' , 'contactPageHandler'],
    ['POST', '/registration' , 'registrationHandler'],
    ['POST', '/login' , 'loginHandler'],
    ['POST', '/bejelentkezes' , 'subsFormHandler'],
    ['POST', '/kijelentkezes' , 'logoutHandler'],
    ['POST', '/hero' , 'createHeroHandler'],
    ['POST', '/delete-hero' , 'deleteHeroHandler'],
    ['POST', '/update-hero' , 'updateHeroHandler'],
    ['POST', '/csomagok' , 'createpackageHandler'],
    ['POST', '/delete-package/{pckId}' , 'deletePackageHandler'],
    ['POST', '/update-package/{pckId}' , 'updatePackageHandler'],
    ['POST', '/reserve-package/{pckId}' , 'reservePackageHandler'],
    ['POST', '/upload-pck-image/{pckId}' , 'uploadPckImageHandler'],
    ['POST', '/update-reservation' , 'updateReservationHandler'],
    ['POST', '/cancel-reservation' , 'cancelReservationHandler'],
    ['POST', '/delete-reservation' , 'deleteReservationHandler'],
    ['POST', '/profil' , 'profilHandler'],
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
?>