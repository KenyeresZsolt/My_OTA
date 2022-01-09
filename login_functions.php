<?php

function emailUsed():bool
{
    $userId = $_SESSION['userId'] ?? null;
    if ($userId) {
        $pdo = getConnection();
        $statement = $pdo->prepare(
            'SELECT u.email
            FROM users u
            WHERE u.id <> ?'
        );
        $statement->execute([$userId]);
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($users as $user){
            if($user['email'] === $_POST['email']){
                return true;
            }
        }
    }
    return false;
}

function registrationHandler()
{
    if (empty($postedData["name"]) OR empty($postedData["email"]) OR empty($postedData["password"])) {
        url_redirect('bejelentkezes', [
            'isRegistration' => 1,
            'info' => 'emptyValue'
        ]);
    }

    //ellenőrzés, hogy regisztrálva van-e már
    if(emailUsed()){
        url_redirect('bejelentkezes', [
            'info' => 'emailUsed'
        ]);
    }
    //ellenőrzés vége

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO users (name, email, password, registered)
        VALUES (?, ?, ?, ?)'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        password_hash($_POST["password"], PASSWORD_DEFAULT),
        time()
    ]);


    // insertUser($data);
    //sendRegistrationMail($userID);


    //email
    $statement = insertMailSql();

    $body = render("registration-email-template.php", [
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

    header('Location: /bejelentkezes?info=registrationSuccessfull');

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
        header('Location: /bejelentkezes?info=invalidCredentials');
        return;
    }
    
    $isVerified = password_verify($_POST['password'], $user['password']);

    if(!$isVerified) {
        header('Location: /bejelentkezes?info=invalidCredentials');
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
        'SELECT u.id, u.is_admin
        FROM users u
        WHERE u.id = ?');
    $statement->execute([$userId]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user['is_admin'] ?? "";
        
}

function logoutHandler()
{
    session_start();

    $params = session_get_cookie_params();
    setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));

    session_destroy();
    header('Location: ' . getPath($_SERVER['HTTP_REFERER']));
}

function getUserById()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM users u 
        WHERE u.id = ?'
    );
    $statement->execute([$_SESSION['userId']]);
    return $user = $statement->fetch(PDO::FETCH_ASSOC);
}

function subsFormHandler()
{
    if(isLoggedIn()){
        header('Location: /');
        return;
    }

    echo render("wrapper.php",[
        'content' => render('subscriptionForm.php',[
            'info' => $_GET['info'] ?? '',
            'isRegistration' => isset($_GET['isRegistration'])
        ]),
        'isAuthorized' => false,
        'title' => "Bejelentkezés",
        'activeLink' => '/bejelentkezes',
        'playChatSound' => false
    ]);
}

function profilHandler()
{
    redirectToLoginIfNotLoggedIn();
    
    echo render('wrapper.php', [
        'content' => render("profile-page.php", [
            "user" => getUserById(),
            'isAdmin' => isAdmin(),
            'info' => $_GET['info'] ?? ""
        ]),
        'activeLink' => '/profil',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Profil",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);    
}

function updateProfilHandler()
{
    redirectToLoginIfNotLoggedIn();

    if(emailUsed()){
        header('Location: /profil?info=emailUsed#updtProfile');
        return;
        }
    
    $user = getUserById();

    if(!empty($_POST['oldPassword']) OR !empty($_POST['newPassword']) OR !empty($_POST['newPassword2'])){
        $isVerified = password_verify($_POST['oldPassword'], $user['password']);
        if(!$isVerified) {
            header('Location: /profil?info=invalidPassword#updtProfile');
            return;
        }

        if($_POST['newPassword'] !== $_POST['newPassword2']){
            header('Location: /profil?info=notIdenticalPassword#updtProfile');
            return;
        }
    }

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE users
        SET name = ?, phone = ?, email = ?, password = ?, last_modified = ?
        WHERE id = ?'
    );
    $statement->execute([
        $_POST['name'],
        $_POST['phone'],
        $_POST['email'],
        empty($_POST['newPassword']) ? $user['password'] : password_hash($_POST["newPassword"], PASSWORD_DEFAULT),
        time(),
        $_SESSION['userId']
    ]);
    header('Location: /profil?info=updateSuccessfull#updtProfile');

}

?>