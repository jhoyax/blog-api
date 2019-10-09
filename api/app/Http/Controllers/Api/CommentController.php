<?php

namespace App\Http\Controllers\Api;

use App\Posts;
use App\Comments;
use App\Http\Controllers\Controller;
use App\Transformers\CommentsTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Http\Requests\CommentsRequest;

class CommentController extends Controller
{
    protected $commentsTransformer;
    protected $fractal;

    public function __construct(Manager $fractal, CommentsTransformer $commentsTransformer)
    {
    	$this->fractal = $fractal;
        $this->commentsTransformer = $commentsTransformer;
    }

    public function index($slug)
    {
        $post = Posts::where('slug', $slug)->first();

        if($post) {

	        $comments = $post->comments();
	        $data = new Collection($comments->get(), $this->commentsTransformer);
	        $data = $this->fractal->createData($data); // Transform data

	        return response()->json($data->toArray());
        }

        return response()->json(['message' => "No query results for model [".Posts::class."]"], 404);
    }

    public function store($slug, CommentsRequest $request)
    {
        $request['creator_id'] = $request->user()->id;
        $comment = new Comments($request->toArray());

        $post = Posts::where('slug',$slug)->first();

        if($post) {
            $response = $post->comments()->save($comment);
        	return response()->json(['data' => $this->commentsTransformer->transform($response)], 201);
        }

        return response()->json(['message' => "No query results for model [".Posts::class."]"], 404);
    }

    public function update($slug, $id, CommentsRequest $request)
    {
        $post = Posts::where('slug',$slug)->first();

        if($post) {
        	$comment = $post->comments()->find($id);
        	if($comment) {
	        	$response = $comment->update($request->toArray());

	        	$comment = $post->comments()->find($id); // fetch again the data
	            return response()->json(['data' => $this->commentsTransformer->transform($comment)]);
        	}
        	return response()->json(['message' => "No query result for model [".Comments::class."]"], 404);
        }

        return response()->json(['message' => "No query result for model [".Posts::class."]"], 404);
    }

    public function delete($slug, $id)
    {
        $post = Posts::where('slug',$slug)->first();


        if($post) {
        	$comment = $post->comments()->find($id);
        	if($comment) {
        		$deleted = $comment->delete();
            	return response(['status' => 'Record deleted successfully']);
        	}
        }

        return response()->json(['status' => 'No record deleted'], 422);
    }
}