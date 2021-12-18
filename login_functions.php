<?php

function registrationHandler()
{
    if (empty($_POST["name"]) OR empty($_POST["email"]) OR empty($_POST["password"])) {
        header('Location: /bejelentkezes?isRegistration=1&info=emptyValue');

        return ;
    }

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO users (name, email, password, createdAt)
        VALUES (?, ?, ?, ?)'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        password_hash($_POST["password"], PASSWORD_DEFAULT),
        time()
    ]);

    //email
    $statement = $pdo->prepare("INSERT INTO `email_messages` 
    (`email`, `subject`, `body`, `status`, `numberOfAttempts`, `createdAt`) 
    VALUES 
    (?, ?, ?, ?, ?, ?);");

    $body = compileTemplate("registration-email-template.php", [
        'name' =>  $_POST['name'] ?? '',
        'email' =>  $_POST['email'] ?? ''
    ]);

    $statement->execute([
        $_POST['email'],
        "Sikeres regisztráció!",
        $body,
        'notSent',
        0,
        time()
    ]);

    header('Location: ' . getPath($_SERVER['HTTP_REFERER']) . '?info=registrationSuccessfull');

    sendMailsHandler();
}

function loginHandler()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM users u
        WHERE u.email = ?'
    );
    $statement->execute([
        $_POST['email']
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
        header('Location: ' . getPath($_SERVER['HTTP_REFERER']) . '?info=invalidCredentials');
        return;
    }
    
    $isVerified = password_verify($_POST['password'], $user['password']);

    if(!$isVerified) {
        header('Location: ' . getPath($_SERVER['HTTP_REFERER']) . '?info=invalidCredentials');
        return;
    }

    session_start();
    $_SESSION['userId'] = $user['id'];
    header('Location: /');

}

function isLoggedIn(): bool
{
    if(!isset($_COOKIE[session_name()])){
        return false;
    }
    
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['userId'])){
            return false;
    }
    
    return true;
}

function redirectToLoginIfNotLoggedIn()
{
    if(isLoggedIn()) {
        return;
    }
    header('Location: /bejelentkezes');
    exit;
}

function isAdmin()
{
    if(!isset($_SESSION)){
        session_start();
    }

    $userId = $_SESSION["userId"] ?? "";

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT u.id, u.isAdmin
        FROM users u
        WHERE u.id = ?');
    $statement->execute([$userId]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user['isAdmin'] ?? "";
        
}

function logoutHandler()
{
    session_start();

    $params = session_get_cookie_params();
    setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));

    session_destroy();
    header('Location: ' . getPath($_SERVER['HTTP_REFERER']));
}

function subsFormHandler()
{
    echo compileTemplate("wrapper.php",[
        'innerTemplate' => compileTemplate('subscriptionForm.php',[
            'info' => $_GET['info'] ?? '',
            'isRegistration' => isset($_GET['isRegistration'])
        ]),
        'isAuthorized' => false,
        'title' => "Bejelentkezés"
    ]);
}

function profilHandler()
{
    redirectToLoginIfNotLoggedIn();
    
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM users u 
        WHERE u.id = ?'
    );
    $statement->execute([$_SESSION['userId']]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $profilTemplate = compileTemplate("profile-page.php", [
        "user" => $user,
        'isAdmin' => isAdmin()
    ]);

    echo compileTemplate('wrapper.php', [
        'innerTemplate' => $profilTemplate,
        'activeLink' => '/profil',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Profil",
        'unreadMessages' => countUnreadMessages()
    ]);
    
}

?>