<?php

function contactPageHandler()
{
    echo render("wrapper.php", [
        'content' => render("contact-page.php", [
            'info' => $_GET['info'] ?? ''
        ]),
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin(),
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound(),
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
    $statement = insertMailSql();

    $body = render("email-template.php", [
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
    $statement = insertMailSql();

    $body = render("confirmation-email-template.php", [
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

    header('Location: /kapcsolat?info=kuldesSikeres#contactForm');

    sendMailsHandler();
}
?>