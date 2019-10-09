<?php

namespace App\Transformers;

use App\Posts;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;

class PostsTransformer extends TransformerAbstract
{
    public function transform(Posts $post)
    {
        return [
            'id'            => (int) $post->id,
            'user_id'       => (int) $post->user_id,
            'title'         => $post->title,
            'slug'          => $post->slug,
            'content'       => $post->content,
            'image'         => $post->image,
            'created_at'    => $post->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => $post->updated_at->format('Y-m-d H:i:s'),
            'deleted_at'    => $post->deleted_at ? $post->deleted_at->format('Y-m-d H:i:s') : null
        ];
    }
}

