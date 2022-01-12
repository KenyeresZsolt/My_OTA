<?php

function userListHandler()
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();

    $statement = $pdo->prepare(
        'SELECT *
        FROM users');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    $isAdded = isset($_GET["added"]);
    $isUpdated =isset($_GET["updated"]);
    $isDeleted = isset($_GET["deleted"]);

    $userListTemplate = render("user-list.php", [
        "users" => $users,
        "isAdded" => $isAdded,
        "isUpdated" => $isUpdated,
        "isDeleted" => $isDeleted,
        "editedUserId" => $_GET["edit"] ?? NULL
    ]);
    echo render('wrapper.php', [
        'content' => $userListTemplate,
        'activeLink' => '/user',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Felhasználók",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

function createUserHandler()
{
    redirectToLoginIfNotLoggedIn();

    $table = "users";
    $columns = [
        'name', 
        'email', 
        'password', 
        'registered'
    ];
    $execute = [
        $_POST["name"],
        $_POST["email"],
        password_hash($_POST["password"], PASSWORD_DEFAULT),
        time()
    ];

    generateInsertSql($table, $columns, $execute);

    urlRedirect('felhasznalok', [
        'added' => "1" 
    ]);
}

function updateUserHandler()
{
    redirectToLoginIfNotLoggedIn();
    $updateUserId = $_GET['id'] ?? NULL;

    $table = "users";
    $columns = [
        'name',
        'email',
        'is_Admin',
    ];
    $conditions = ['id ='];
    $execute = [
        $_POST["name"],
        $_POST["email"],
        $_POST["isAdmin"],
        $updateUserId
    ];

    generateUpdateSql($table, $columns, $conditions, $execute);

    urlRedirect('felhasznalok', [
        'updated' => "1" 
    ]);
}

function deleteUserHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();

    $statement = $pdo->prepare(
        'DELETE FROM users     
        WHERE id = ?'
    );
    $statement->execute([$_GET['id']]);
    
    urlRedirect('felhasznalok', [
        'deleted' => "1" 
    ]);
}

?>