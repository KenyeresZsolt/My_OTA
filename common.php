<?php

function urlRedirect($url, $params = [])
{
    $p = '';
    foreach ($params as $k => $v)
    {
        $p .= ($p ? '&' : '?') . "$k=$v";
    }
    header("Location: /{$url}{$p}");
    exit;
}

function generateInsertSql($table, $columns, $execute)
{
    $pdo = getConnection();

    $col = implode(", ", $columns);
    $val = [];
    for($i = 0; $i < count($columns); $i++){
        $val[] = "?";
    }
    $val = implode(", ", $val);
    $sql = "INSERT INTO $table ($col) VALUES ($val)";
    
    /*echo $sql;
    echo "<pre>";
    var_dump($execute);
    exit;*/

    $stmt = $pdo->prepare($sql);
    $stmt->execute($execute);
    return $pdo->lastInsertId();
}

function generateUpdateSql($table, $columns, $conditions, $execute)
{
    $pdo = getConnection();
        
    $col = implode(" = ?, ", $columns);
    $cond = implode(" ? AND ", $conditions);
    $sql = "UPDATE $table SET $col = ? WHERE $cond ?";

    /*echo $sql;
    echo "<pre>";
    var_dump($execute);
    exit;*/

    $stmt = $pdo->prepare($sql);
    $stmt->execute($execute);
}


function validationMessages($type = null)
{
    $messages = [
        'kuldesSikeres' => 'Küldés sikeres',
    ];

    return $type && isset($messages[$type]) ? $messages[$type] : $messages;
}

