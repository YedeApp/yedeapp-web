<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS filtering
        $topic->content = clean($topic->content, 'html');

        // Truncate 200 chars from topic content as its description.
        $topic->description = truncate($topic->content);

    }

    public function saved(Topic $topic)
    {
        // If the topic has no slug, add it using baidu translation api.
        // if (!$topic->slug) {

        //     // Dispatch to queue jobs
        //     dispatch(new TranslateTopicSlug($topic));
        // }
    }
}