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

function generateUpdateSql($sqlInput)
{
    $table = $sqlInput['table'];
    $col = implode(" = ?, ", $sqlInput['columns']);
    $cond = implode(" = ? AND ", $sqlInput['conditions']);
    return "UPDATE $table SET $col = ? WHERE $cond = ?";

}


function validationMessages($type = null)
{
    $messages = [
        'kuldesSikeres' => 'Küldés sikeres',
    ];

    return $type && isset($messages[$type]) ? $messages[$type] : $messages;
}

