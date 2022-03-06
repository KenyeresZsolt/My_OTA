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
    if (empty($_POST['name']) OR empty($_POST['email']) OR empty($_POST['password'])) {
        urlRedirect('bejelentkezes', [
            'isRegistration' => 1,
            'info' => 'emptyValue'
        ]);
    }

    //ellenőrzés, hogy regisztrálva van-e már
    if(emailUsed()){
        urlRedirect('bejelentkezes', [
            'info' => 'emailUsed'
        ]);
    }

    $table = 'users';
    $columns = [
        'name',
        'email', 
        'password', 
        'is_admin',
        'registered',
        'last_modified'
    ];
    $execute = [
        $_POST['name'],
        $_POST['email'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        '0',
        time(),
        '0'
    ];

    generateInsertSql($table, $columns, $execute);

    // insertUser($data);
    //sendRegistrationMail($userID);


    //email
    $statement = insertMailSql();

    $body = render('registration-email-template.php', [
        'name' =>  $_POST['name'] ?? NULL,
        'email' =>  $_POST['email'] ?? NULL
    ]);

    $statement->execute([
        $_POST['email'],
        'Sikeres regisztráció!',
        $body,
        'notSent',
        0,
        time()
    ]);

    header('Location: /bejelentkezes?info=registrationSuccessfull');
    /*urlRedirect('bejelentkezes', [
        'info' => 'registrationSuccessfull'
    ]);*/ //ezzel nem küldi ki az emaileket

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
        urlRedirect('bejelentkezes', [
            'info' => 'invalidCredentials'
        ]);
    }
    
    $isVerified = password_verify($_POST['password'], $user['password']);

    if(!$isVerified) {
        urlRedirect('bejelentkezes', [
            'info' => 'invalidCredentials'
        ]);
    }

    session_start();
    $_SESSION['userId'] = $user['id'];
    urlRedirect('');

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
    urlRedirect('bejelentkezes',[
        'info' => 'notLoggedIn'
    ]);
}

function isAdmin()
{
    if(!isset($_SESSION)){
        session_start();
    }

    $userId = $_SESSION['userId'] ?? '';

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT u.id, u.is_admin
        FROM users u
        WHERE u.id = ?');
    $statement->execute([$userId]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user['is_admin'] ?? '';
        
}

function logoutHandler()
{
    session_start();

    $params = session_get_cookie_params();
    setcookie(session_name(), NULL, 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));

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
        urlRedirect('');
    }

    echo render('wrapper.php',[
        'content' => render('subscriptionForm.php',[
            'info' => $_GET['info'] ?? NULL,
            'isRegistration' => isset($_GET['isRegistration'])
        ]),
        'isAuthorized' => false,
        'title' => 'Bejelentkezés',
        'activeLink' => '/bejelentkezes',
        'playChatSound' => false
    ]);
}

function profilHandler()
{
    redirectToLoginIfNotLoggedIn();
    
    echo render('wrapper.php', [
        'content' => render('profile-page.php', [
            'user' => getUserById(),
            'isAdmin' => isAdmin(),
            'info' => $_GET['info'] ?? ''
        ]),
        'activeLink' => '/profil',
        'isAuthorized' => true,
        'isAdmin' => isAdmin(),
        'title' => 'Profil',
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);    
}

function updateProfilHandler()
{
    redirectToLoginIfNotLoggedIn();

    if(emailUsed()){
        urlRedirect('profil', [
            'info' => 'emailUsed#updtProfile'
        ]);
    }
    
    $user = getUserById();

    if(!empty($_POST['oldPassword']) OR !empty($_POST['newPassword']) OR !empty($_POST['newPassword2'])){
        $isVerified = password_verify($_POST['oldPassword'], $user['password']);
        if(!$isVerified) {
            urlRedirect('profil', [
                'info' => 'invalidPassword#updtProfile'
            ]);
        }

        if($_POST['newPassword'] !== $_POST['newPassword2']){
            urlRedirect('profil', [
                'info' => 'notIdenticalPassword#updtProfile'
            ]);
        }
    }

    $table = 'users';
    $columns = [
        'name',
        'phone',
        'email',
        'password',
        'last_modified',
    ];
    $conditions = ['id ='];
    $execute = [
        $_POST['name'],
        $_POST['phone'],
        $_POST['email'],
        empty($_POST['newPassword']) ? $user['password'] : password_hash($_POST['newPassword'], PASSWORD_DEFAULT),
        time(),
        $_SESSION['userId']
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);
  
    urlRedirect('profil', [
        'info' => 'updateSuccessfull#updtProfile'
    ]);

}

?>