<?php

function route_class()
{
    $routeClsName = str_replace('.', '-', Route::currentRouteName());

    return $routeClsName;
}

function outlink($href, $text, $target = 'blank')
{
    $rel = '';

    if ($target == 'blank') {
        $rel = 'rel="noopener noreferrer"';
    }

    return "<a href=\"{$href}\" target=\"_{$target}\" {$rel}>{$text}</a>";
}