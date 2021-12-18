<?php

function heroListHandler()
{
    redirectToLoginIfNotLoggedIn();

    $pdo = getConnection();

    $statement = $pdo->prepare(
        'SELECT h.*, d.name department
        FROM heroes h
        left join departments d on h.departmentId = d.id');
    $statement->execute();
    $heroes = $statement->fetchAll(PDO::FETCH_ASSOC);

    $heroName = array_column($heroes, 'name');
    array_multisort($heroName, SORT_ASC, $heroes);

    $statement = $pdo->prepare(
        'SELECT *
        FROM departments d'
    );
    $statement->execute();
    $departments = $statement->fetchAll(PDO::FETCH_ASSOC);

    $isAdded = isset($_GET["added"]);
    $isUpdated =isset($_GET["updated"]);
    $isDeleted = isset($_GET["deleted"]);

    $heroListTemplate = compileTemplate("hero-list.php", [
        "heroes" => $heroes,
        "departments" => $departments,
        "isAdded" => $isAdded,
        "isUpdated" => $isUpdated,
        "isDeleted" => $isDeleted,
        "editedHeroId" => $_GET["edit"] ?? ""
    ]);
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => $heroListTemplate,
        'activeLink' => '/hero',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Kollégák",
        'unreadMessages' => countUnreadMessages()
    ]);

}

function createHeroHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();
    
    $statement = $pdo->prepare(
        'SELECT *
        FROM departments d
        WHERE d.name = ?'
    );
    $statement->execute([$_POST["department"]]);
    $department = $statement->fetch(PDO::FETCH_ASSOC);
 
    $statement = $pdo->prepare(
        'INSERT INTO heroes (name, email, departmentId)
        VALUES (?, ?, ?)'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        $department["id"]
    ]);

    header("Location: /hero?added=1");
}

function updateHeroHandler()
{
    redirectToLoginIfNotLoggedIn();
    $updateHeroId = $_GET['id'] ?? "";

    $pdo = getConnection();

    $statement = $pdo->prepare(
        'SELECT *
        FROM departments d
        WHERE d.name = ?'
    );
    $statement->execute([$_POST["department"]]);
    $department = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare(
        'UPDATE heroes h
        SET h.name = ? , h.email = ?, h.departmentId = ?
        WHERE h.id = ?'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        $department["id"],
        $updateHeroId
    ]);

    header("Location: /hero?updated=1");
}

function deleteHeroHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();

    $statement = $pdo->prepare(
        'DELETE FROM heroes     
        WHERE id = ?'
    ); // itt miért nem lehet a táblának aliast adni? Azzal nem fut le.
    $statement->execute([$_GET['id']]);
    
    header("Location: /hero?deleted=1");
}

?>