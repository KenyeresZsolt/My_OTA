<?php

require './login_functions.php';
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

function render($filePath, $params = []): string
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

function homeHandler()
{
    echo render('wrapper.php', [
        'content' => render('home.php'),
        'activeLink' => '/',
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin() ?? "",
        'title' => "Főoldal",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function notFoundHandler()
{
    echo render('wrapper.php', [
        'content' => render('not-found-page.php'),
        'activeLink' => '/oldal-nem-talalhato',
        "isAuthorized" => isLoggedIn(),
        'isAdmin' => isAdmin(),
        'title' => "Oldal nem található",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);
}

function insertMailSql()
{
    $pdo = getConnection();
    return $statement = $pdo->prepare("INSERT INTO `email_messages` 
    (`email`, `subject`, `body`, `status`, `number_of_attempts`, `created_at`) 
    VALUES 
    (?, ?, ?, ?, ?, ?);");
}

function sendMailsHandler()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        "SELECT * FROM email_messages 
        WHERE 
        status = 'notSent' AND 
        number_of_attempts < 10 
        ORDER BY created_at ASC"
    );

    $statement->execute();
    $messages = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $message) {
        $pdo = getConnection();
        $statement = $pdo->prepare(
            "UPDATE `email_messages` SET 
                status = 'sending', 
                number_of_attempts = ? 
            WHERE id = ?;"
        );

        $statement->execute([
            (int)$message['number_of_attempts'] + 1,
            $message['id']
        ]);

        $isSent = sendMail(
            $message['email'],
            $message['subject'],
            $message['body']
        );

        if ($isSent) {
            $statement = $pdo->prepare(
                "UPDATE `email_messages` SET status = 'sent', sent_at = ? WHERE id = ?;"
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