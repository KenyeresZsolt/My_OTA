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

    echo render('wrapper.php', [
        'content' => render("hero-list.php", [
            "heroes" => $heroes,
            "departments" => $departments,
            "info" => $_GET["info"] ?? "",
            "editedHeroId" => $_GET["edit"] ?? ""
        ]),
        'activeLink' => '/hero',
        "isAuthorized" => isLoggedIn(),
        'isAdmin' => isAdmin(),
        'title' => "Kollégák",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => playChatSound()
    ]);

}

function getDepartmentByName()
{
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT *
        FROM departments d
        WHERE d.name = ?'
    );
    $statement->execute([$_POST["department"]]);
    return $department = $statement->fetch(PDO::FETCH_ASSOC);
}

function createHeroHandler()
{
    redirectToLoginIfNotLoggedIn();
        
    $department = getDepartmentByName();
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO heroes (name, email, departmentId)
        VALUES (?, ?, ?)'
    );
    $statement->execute([
        $_POST["name"],
        $_POST["email"],
        $department["id"]
    ]);

    header("Location: /hero?info=added");
}

function updateHeroHandler()
{
    redirectToLoginIfNotLoggedIn();
    $updateHeroId = $_GET['id'] ?? "";

    $department = getDepartmentByName();

    $pdo = getConnection();
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

    header("Location: /hero?info=updated");
}

function deleteHeroHandler()
{
    redirectToLoginIfNotLoggedIn();
    $pdo = getConnection();

    $statement = $pdo->prepare(
        'DELETE FROM heroes     
        WHERE id = ?'
    );
    $statement->execute([$_GET['id']]);
    
    header("Location: /hero?info=deleted");
}

?>