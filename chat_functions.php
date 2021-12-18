<?php

function chatPageHandler()
{
    redirectToLoginIfNotLoggedIn();

    //lekérem az összes beszélgetést
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT c.*, cu.member_userID 
        FROM conversations c
        LEFT JOIN conversation_users cu ON c.id = cu.conversationID
        WHERE cu.member_userID = ?');
    $statement->execute([$_SESSION["userId"]]);
    $conversations = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    //hozzáfűzöm a beszélgetésekhez az üzeneteket
    foreach($conversations as $index => $conversation){
        $statement = $pdo->prepare(
            'SELECT cm.*, u.name sender
            FROM chat_messages cm
            LEFT JOIN users u ON cm.fromUserId = u.id 
            WHERE conversationId = ?');
        $statement->execute([$conversation['id']]);
        $messages = $statement->fetchAll(PDO::FETCH_ASSOC);
        $conversations[$index]['messages'] = $messages;
    }

    //lekérem az összes usert, a beszélgetés-hozzáférésekhez kell
    $statement = $pdo->prepare(
        'SELECT u.id, u.name
        FROM users u
        WHERE u.id <> ?'
    );
    $statement->execute([$_SESSION["userId"]]);
    $allUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

    //lekérem a beszélgetések tagjait
    $statement = $pdo->prepare(
        'SELECT cu.*, u.name
        FROM `conversation_users` cu
        LEFT JOIN users u on cu.member_userID = u.id'
    );
    $statement->execute();
    $convMembers = $statement->fetchAll(PDO::FETCH_ASSOC);

    //látta beállítása
    $statement = $pdo->prepare(
        'UPDATE chat_messages cm
        LEFT JOIN conversation_users cu on cm.conversationId = cu.conversationID
        SET cm.seen = "1", cm.seenAt = ?
        WHERE cm.seen = "0" AND cu.member_userID = ? AND cm.fromUserId <> ?'
    );
    $statement->execute([
        time(),
        $_SESSION["userId"],
        $_SESSION["userId"]
    ]);


    $newMessage = isset($_GET["new"]);
    $isDeleted = isset($_GET["deleted"]);

    $chatPageTemplate = compileTemplate("chat-page.php", [
        "conversationsWithMessages" => $conversations,
        "userId" => $_SESSION["userId"],
        "newMessage" => $newMessage,
        "isDeleted" =>$isDeleted,
        "manageMembers" => $_GET['manage-members'] ?? "",
        "allUsers" => $allUsers,
        "convMembers" => $convMembers
    ]);
    echo compileTemplate('wrapper.php', [
        'innerTemplate' => $chatPageTemplate,
        'activeLink' => '/chat',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Chat",
        'unreadMessages' => countUnreadMessages()
    ]);

}

function newConversationHandler()
{
    redirectToLoginIfNotLoggedIn();

    $startUser = $_SESSION["userId"];
    $startTime = time();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO conversations (name, started_by_userID, startedAt)
        VALUES (?, ?, ?)'
    );
    $statement->execute([
        $_POST['name'],
        $startUser,
        $startTime,
    ]);

    $statement = $pdo->prepare(
        'SELECT *
        FROM conversations c
        WHERE c.started_by_userID = ? AND c.startedAt = ?'
    );
    $statement->execute([
        $startUser,
        $startTime
    ]);
    $startedConv = $statement->fetchAll(PDO::FETCH_ASSOC);

    $newConvId = $startedConv[0]['id'];

    $statement = $pdo->prepare(
        'INSERT INTO conversation_users (conversationID, member_userID)
        VALUES (?, ?)'
    );
    $statement->execute([
        $newConvId,
        $startUser
    ]);

    header('Location: /chat?conversation-started');

}

function sendMessageHandler()
{
    redirectToLoginIfNotLoggedIn();

    $convId = $_GET['convId'];
    $message = $_POST['message'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO chat_messages (conversationId, fromUserId, sentAt, message)
        VALUES (?, ?, ?, ?)');
    $statement->execute([
        $convId,
        $_SESSION['userId'],
        time(),
        $message
    ]);

    header('Location: /chat?href=#' . $convId);
}

function addMemberHandler()
{
    redirectToLoginIfNotLoggedIn();

    $convId = $_GET['convId'];
    $member = $_POST['member'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO conversation_users (conversationID, member_userID)
            VALUES (?, ?)');
    $statement->execute([
        $convId,
        $member
    ]);

    header ('Location: /chat?manage-members=' . $convId);
}

function deleteMemberHandler()
{
    redirectToLoginIfNotLoggedIn();

    $convId = $_GET['convId'];
    $convMember = $_GET['convMember'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM conversation_users
        WHERE (conversationID = ? AND member_userID = ?)'
    );
    $statement->execute([
        $convId,
        $convMember
    ]);

    header('Location: /chat?manage-members=' . $convId);
}

function deleteConversationHandler()
{
    redirectToLoginIfNotLoggedIn();
    
    $deleteConvId = $_GET['id'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM conversation_users
        WHERE conversationID = ?');
    $statement->execute([$deleteConvId]);

    $statement = $pdo->prepare(
        'DELETE FROM chat_messages
        WHERE conversationId = ?');
    $statement->execute([$deleteConvId]);

    $statement = $pdo->prepare(
        'DELETE FROM conversations
        WHERE id = ?');
    $statement->execute([$deleteConvId]);

    header('Location: /chat?deleted=1');
    
}

?>
