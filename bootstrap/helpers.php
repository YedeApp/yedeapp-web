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
 * Insert is-invalid css class to the input field if it has any error emerged.
 */
function checkError($errors, $field) {
    return $errors->has($field) ? 'is-invalid' : '';
}

/**
 * Show the errors info below the input field which causes error occured.
 */
function showErrorFeedback($errors, $field) {
    if ($errors->has($field)) {
        return '<div class="invalid-feedback">' . $errors->first($field) . '</div>';
    }

    return '';
}

/**
 * Show session stroed message on the page.
 */
function showSessionMessage($key) {
    if (Session::has($key)) {
        $s = '<div class="alert alert-primary alert-dismissible fade show d-inline-block" role="alert">';
        $s .= Session::get($key);
        $s .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $s .= '</div>';
        return $s;
    }

    return '';
}