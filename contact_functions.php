<?php

function contactPageHandler()
{
    echo render('wrapper.php', [
        'content' => render('contact-page.php', [
            'info' => $_GET['info'] ?? NULL
        ]),
        'isAuthorized' => isLoggedIn(),
        'isAdmin' => isAdmin(),
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound(),
        'title' => 'Kapcsolat',
        'activeLink' => '/kapcsolat'
    ]);
}

function submitMailHandler()
{
    if (empty($_POST['name']) OR empty($_POST['email']) OR empty($_POST['content'])) {
        urlRedirect('kapcsolat', [
            'info' => 'emptyValue'
        ]);

    }

    //értesítő email
    $pdo = getConnection();
    $statement = insertMailSql();

    $body = render('email-template.php', [
        'name' =>  $_POST['name'] ?? NULL,
        'email' =>  $_POST['email'] ?? NULL,
        'content' =>  $_POST['content'],
    ]);

    $statement->execute([
        $_SERVER['RECIPIENT_EMAIL'],
        'Új üzenet érkezett',
        $body,
        'notSent',
        0,
        time()
    ]);

    //megerősítő email
    $statement = insertMailSql();

    $body = render('confirmation-email-template.php', [
        'name' =>  $_POST['name'] ?? NULL,
        'email' =>  $_POST['email'] ?? NULL,
        'content' =>  $_POST['content'],
    ]);

    $statement->execute([
        $_POST['email'],
        'Üzenet elküldésének megerősítése',
        $body,
        'notSent',
        0,
        time()
    ]);

    urlRedirect('kapcsolat', [
        'info' => 'kuldesSikeres#contactForm'
    ]);

    sendMailsHandler();
}
?>