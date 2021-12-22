<?php

function contactPageHandler()
{
    echo compileTemplate("wrapper.php", [
        'innerTemplate' => compileTemplate("contact-page.php", [
            'isSuccess' => isset($_GET['kuldesSikeres']),
            'info' => $_GET['info'] ?? ''
        ]),
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin(),
        'unreadMessages' => countUnreadMessages(),
        'title' => "Kapcsolat",
        'activeLink' => '/kapcsolat'
    ]);
}

function submitMailHandler()
{
    if (empty($_POST["name"]) OR empty($_POST["email"]) OR empty($_POST["content"])) {
        header('Location: /kapcsolat?info=emptyValue');

        return ;
    }

    //értesítő email
    $pdo = getConnection();
    $statement = $pdo->prepare("INSERT INTO `email_messages` 
    (`email`, `subject`, `body`, `status`, `numberOfAttempts`, `createdAt`) 
    VALUES 
    (?, ?, ?, ?, ?, ?);");

    $body = compileTemplate("email-template.php", [
        'name' =>  $_POST['name'] ?? '',
        'email' =>  $_POST['email'] ?? '',
        'content' =>  $_POST['content'],
    ]);

    $statement->execute([
        $_SERVER['RECIPIENT_EMAIL'],
        "Új üzenet érkezett",
        $body,
        'notSent',
        0,
        time()
    ]);

    //megerősítő email
    $statement = $pdo->prepare("INSERT INTO `email_messages` 
    (`email`, `subject`, `body`, `status`, `numberOfAttempts`, `createdAt`) 
    VALUES 
    (?, ?, ?, ?, ?, ?);");

    $body = compileTemplate("confirmation-email-template.php", [
        'name' =>  $_POST['name'] ?? '',
        'email' =>  $_POST['email'] ?? '',
        'content' =>  $_POST['content'],
    ]);

    $statement->execute([
        $_POST['email'],
        "Üzenet elküldésének megerősítése",
        $body,
        'notSent',
        0,
        time()
    ]);

    header('Location: /kapcsolat?kuldesSikeres=1#contactForm');

    sendMailsHandler();
}
?>