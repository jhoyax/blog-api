<?php

namespace App\Transformers;

use App\Comments;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;

class CommentsTransformer extends TransformerAbstract
{
    public function transform(Comments $comment)
    {
        return [
            'id'                => (int) $comment->id,
            'commentable_id'    => (int) $comment->commentable_id,
            'creator_id'        => (int) $comment->creator_id,
            'parent_id'         => (int) $comment->parent_id,
            'body'              => $comment->body,
            'commentable_type'  => $comment->commentable_type,
            'created_at'        => $comment->created_at->format('Y-m-d H:i:s'),
            'updated_at'        => $comment->updated_at->format('Y-m-d H:i:s')
        ];
    }
}

