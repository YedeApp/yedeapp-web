<?php

function getRouteCls()
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

function truncate($value, $length = 200)
{
    $string = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));

    return str_limit($string, $length);
}

function jumpToComment($comment, $courseSlug = '') {
    return $comment->topic->link($courseSlug) . '#comment_' . $comment->id;
}