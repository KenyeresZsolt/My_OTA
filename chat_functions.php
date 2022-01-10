<?php

function chatPageHandler()
{
    redirectToLoginIfNotLoggedIn();

    $playChatSound = playChatSound();

    //lekérem az összes beszélgetést
    $pdo = getConnection();
    $statement = $pdo->prepare(
        'SELECT c.*, cu.member_user_id 
        FROM conversations c
        LEFT JOIN conversation_users cu ON c.id = cu.conversation_id
        WHERE cu.member_user_id = ?');
    $statement->execute([$_SESSION["userId"]]);
    $conversations = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    //hozzáfűzöm a beszélgetésekhez az üzeneteket
    foreach($conversations as $index => $conversation){
        $statement = $pdo->prepare(
            'SELECT cm.*, u.name sender
            FROM chat_messages cm
            LEFT JOIN users u ON cm.from_user_id = u.id 
            WHERE cm.conversation_id = ?
            ORDER BY cm.sent_at DESC');
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
        LEFT JOIN users u on cu.member_user_id = u.id'
    );
    $statement->execute();
    $convMembers = $statement->fetchAll(PDO::FETCH_ASSOC);

    //látta beállítása
    $statement = $pdo->prepare(
        'UPDATE chat_messages cm
        LEFT JOIN conversation_users cu on cm.conversation_id = cu.conversation_id
        SET cm.seen = "1", cm.seen_at = ?
        WHERE cm.seen = "0" AND cu.member_user_id = ? AND cm.from_user_id <> ?'
    );
    $statement->execute([
        time(),
        $_SESSION["userId"],
        $_SESSION["userId"]
    ]);

    echo render('wrapper.php', [
        'content' => render("chat-page.php", [
            "conversationsWithMessages" => $conversations,
            "userId" => $_SESSION["userId"],
            "info" => $_GET['info'] ?? NULL,
            "manageMembers" => $_GET['manage-members'] ?? NULL,
            "allUsers" => $allUsers,
            "convMembers" => $convMembers
        ]),
        'activeLink' => '/chat',
        "isAuthorized" => true,
        'isAdmin' => isAdmin(),
        'title' => "Chat",
        'unreadMessages' => countUnreadMessages(),
        'playChatSound' => $playChatSound
    ]);
    
    //hiba: ha több felhasználó van egy beszélgetésben, akkor ha az egyik elolvassa az üzenetet, akkor a többinél is olvasottként jelenik meg.
}

function newConversationHandler()
{
    redirectToLoginIfNotLoggedIn();

    $startUser = $_SESSION["userId"];
    $startTime = time();

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO conversations (name, started_by_user_id, started_at)
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
        WHERE c.started_by_user_id = ? AND c.started_at = ?'
    );
    $statement->execute([
        $startUser,
        $startTime
    ]);
    $startedConv = $statement->fetchAll(PDO::FETCH_ASSOC);

    $newConvId = $startedConv[0]['id'];

    $statement = $pdo->prepare(
        'INSERT INTO conversation_users (conversation_id, member_user_id)
        VALUES (?, ?)'
    );
    $statement->execute([
        $newConvId,
        $startUser
    ]);

    urlRedirect('chat', [
        'info' => "started#$newConvId"
    ]);

}

function sendMessageHandler()
{
    redirectToLoginIfNotLoggedIn();

    $convId = $_GET['convId'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO chat_messages (conversation_id, from_user_id, sent_at, message)
        VALUES (?, ?, ?, ?)');
    $statement->execute([
        $convId,
        $_SESSION['userId'],
        time(),
        $_POST['message']
    ]);

    urlRedirect('chat', [
        'href' => "#$convId"
    ]);
}

function addMemberHandler()
{
    redirectToLoginIfNotLoggedIn();

    $convId = $_GET['convId'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'INSERT INTO conversation_users (conversation_id, member_user_id)
            VALUES (?, ?)');
    $statement->execute([
        $convId,
        $_POST['member']
    ]);

    header ('Location: /chat?manage-members=' . $convId . '#' . $convId);
}

function deleteMemberHandler()
{
    redirectToLoginIfNotLoggedIn();

    $convId = $_GET['convId'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM conversation_users
        WHERE (conversation_id = ? AND member_user_id = ?)'
    );
    $statement->execute([
        $convId,
        $_GET['convMember']
    ]);

    urlRedirect('chat', [
        'manage-members' => "$convId#$convId"
    ]);
}

function deleteConversationHandler()
{
    redirectToLoginIfNotLoggedIn();
    
    $deleteConvId = $_GET['id'];

    $pdo = getConnection();
    $statement = $pdo->prepare(
        'DELETE FROM conversation_users
        WHERE conversation_id = ?');
    $statement->execute([$deleteConvId]);

    $statement = $pdo->prepare(
        'DELETE FROM chat_messages
        WHERE conversation_id = ?');
    $statement->execute([$deleteConvId]);

    $statement = $pdo->prepare(
        'DELETE FROM conversations
        WHERE id = ?');
    $statement->execute([$deleteConvId]);

    urlRedirect('chat', [
        'info' => 'deleted'
    ]);
    
}

function countUnreadMessages()
{
    if(!isLoggedin()){
        return;
    }
    
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'SELECT COUNT(cm.id) unread_messages
        FROM `chat_messages` cm
        LEFT JOIN conversation_users cu on cm.conversation_id = cu.conversation_id
        WHERE cm.seen = "0" AND cu.member_user_id = ? and cm.from_user_id <> ?'
        );
    $stmt->execute([
        $_SESSION["userId"],
        $_SESSION["userId"]
    ]);
    $unreadMessages = $stmt->fetch(PDO::FETCH_ASSOC);

    return $unreadMessages['unread_messages'];
}

function playChatSound()
{
    if(countUnreadMessages()>0){
        return true;
    }
    else {
        return false;
    }
}

?>
