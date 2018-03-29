<?php

function getRouteCls()
{
    $routeClsName = str_replace('.', '-', Route::currentRouteName());

    return $routeClsName;
}

function setOutlink($href, $text, $target = 'blank')
{
    $rel = '';

    if ($target == 'blank') {
        $rel = 'rel="noopener noreferrer"';
    }

    return "<a href=\"{$href}\" target=\"_{$target}\" {$rel}>{$text}</a>";
}

function jumpToComment($comment) {
    return $comment->topic->link() . '#comment_' . $comment->id;
}