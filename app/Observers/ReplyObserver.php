<?php

namespace App\Observers;


use App\Models\Reply;
use App\Notifications\TopicReplied;


// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //
    }

    public function updating(Reply $reply)
    {
        //
    }


    public function saving(Reply $reply){

    	$reply->content = clean($reply->content , 'user_topic_body');
    }


    public function saved(Reply $reply){

    	$reply->topic->updateReplyCount();
        // 通知话题作者有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }


    public function deleted(Reply $reply){

        
        $reply->topic->updateReplyCount();
        // $reply->topic->reply_count = $reply->topic->replies->count();
        // $reply->topic->save();
    }



}