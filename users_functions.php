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
        "editedUserId" => $_GET["edit"] ?? ""
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

    header("Location: /felhasznalok?added=1");
}

function updateUserHandler()
{
    redirectToLoginIfNotLoggedIn();
    $updateUserId = $_GET['id'] ?? "";

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'UPDATE users u
        SET u.name = ? , u.email = ?, u.is_Admin = ?
        WHERE u.id = ?'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        $_POST["isAdmin"],
        $updateUserId
    ]);

    header("Location: /felhasznalok?updated=1");
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
    
    header("Location: /felhasznalok?deleted=1");
}

?>