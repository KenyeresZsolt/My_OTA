<?php

require './login_functions.php';
require './heroes_functions.php';
require './packages_functions.php';
require './reservations_functions.php';
require './users_functions.php';
require './chat_functions.php';
require './contact_functions.php';
require './Mailer.php';

function getConnection()
{
    return new PDO(
        'mysql:host='. $_SERVER['DB_HOST'] .';dbname=' . $_SERVER['DB_NAME'], 
        $_SERVER['DB_USER'], 
        $_SERVER['DB_PASSWORD']
    );
}

function compileTemplate($filePath, $params = []): string
{
    ob_start();
    require __DIR__ . "/views/" . $filePath;
    return ob_get_clean();
}

function getPath($url)
{
    $parsed = parse_url($url);
    if(!isset($parsed['query'])){
        return $url;
    }

    return $parsed['path'];
}

function countUnreadMessages()
{
    if(!isLoggedin()){
        return;
    }
    
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'SELECT COUNT(cm.id) unread_messages
        FROM `chat_messages` cm
        LEFT JOIN conversation_users cu on cm.conversationId = cu.conversationID
        WHERE cm.seen = "0" AND cu.member_userID = ? and cm.fromUserId <> ?'
        );
    $stmt->execute([
        $_SESSION["userId"],
        $_SESSION["userId"]
    ]);
    $unreadMessages = $stmt->fetch(PDO::FETCH_ASSOC);

    return $unreadMessages['unread_messages'];
}

function homeHandler()
{
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => compileTemplate('home.php'),
        'activeLink' => '/',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Főoldal",
        'unreadMessages' => countUnreadMessages()
    ]);
}

//Sakktábla
function chessHandler()
{
    redirectToLoginIfNotLoggedIn();

    $chessTemplate = compileTemplate('sakktabla.php');
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => $chessTemplate,
        'activeLink' => '/sakktabla',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Sakktábla",
        'unreadMessages' => countUnreadMessages()
    ]);
}

function notFoundHandler()
{
    echo "Oldal nem található";
}

function sendMailsHandler()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        "SELECT * FROM email_messages 
        WHERE 
        status = 'notSent' AND 
        numberOfAttempts < 10 
        ORDER BY createdAt ASC"
    );

    $statement->execute();
    $messages = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $message) {
        $pdo = getConnection();
        $statement = $pdo->prepare(
            "UPDATE `email_messages` SET 
                status = 'sending', 
                numberOfAttempts = ? 
            WHERE id = ?;"
        );

        $statement->execute([
            (int)$message['numberOfAttempts'] + 1,
            $message['id']
        ]);

        $isSent = sendMail(
            $message['email'],
            $message['subject'],
            $message['body']
        );

        if ($isSent) {
            $statement = $pdo->prepare(
                "UPDATE `email_messages` SET status = 'sent', sentAt = ? WHERE id = ?;"
            );
            $statement->execute([
                time(),
                $message['id'],
            ]);
        } else {
            $statement = $pdo->prepare("UPDATE `email_messages` SET status = 'notSent' WHERE id = ?;");
            $statement->execute([
                $message['id']
            ]);
        }
    }
}
?>