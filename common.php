<?php

function url_redirect($url, $params = [])
{
    $p = '';
    foreach ($params as $k => $v)
    {
        $p .= ($p ? '&' : '?') . "$k=$v";
    }
    header("Location: /{$url}{$p}");
    exit;
}


function validationMessages($type = null)
{
    $messages = [
        'kuldesSikeres' => 'Küldés sikeres',
    ];

    return $type && isset($messages[$type]) ? $messages[$type] : $messages;
}

