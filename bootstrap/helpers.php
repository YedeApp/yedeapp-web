<?php

/**
 * Produce a css class by page's route name
 */
function getRouteCls()
{
    $routeClsName = str_replace('.', '-', Route::currentRouteName());

    return $routeClsName;
}

/**
 * External link
 */
function outlink($href, $text, $target = 'blank')
{
    $rel = '';

    if ($target == 'blank') {
        $rel = 'rel="noopener noreferrer"';
    }

    return "<a href=\"{$href}\" target=\"_{$target}\" {$rel}>{$text}</a>";
}

/**
 * Truncate strings to defined length.
 */
function truncate($value, $length = 200)
{
    $string = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));

    return str_limit($string, $length);
}

/**
 * Jump to specific comment location.
 */
function jumpToComment($comment, $courseSlug = '') {
    return $comment->topic->link($courseSlug) . '#comment_' . $comment->id;
}

/**
 * Check if the current tab is actived by url params.
 */
function checkNavActive($if_route, $if_route_param) {
    return active_class($if_route && $if_route_param);
}

/**
 * Check nav active status on user profile page.
 */
function checkUserNavActive($value = '', $key = 'tab') {
    $if_route = if_route('user.show');

    $if_route_param = if_route_param($key, $value);

    return checkNavActive($if_route, $if_route_param);
}