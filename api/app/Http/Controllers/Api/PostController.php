<?php

namespace App\Http\Controllers\Api;

use App\Posts;
use App\Http\Controllers\Controller;
use App\Transformers\PostsTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Http\Requests\PostsRequest;

class PostController extends Controller
{
    protected $postsTransformer;
    protected $fractal;

    public function __construct(Manager $fractal, PostsTransformer $postsTransformer)
    {
    	$this->fractal = $fractal;
        $this->postsTransformer = $postsTransformer;
    }

    public function index()
    {
        $posts = Posts::paginate(15);

        $data = new Collection($posts->items(), $this->postsTransformer);
        $data->setPaginator(new IlluminatePaginatorAdapter($posts));
        $data = $this->fractal->createData($data); // Transform data

        return response()->json($data->toArray());
    }

    public function show($slug)
    {
        $post = Posts::where('slug', $slug)->first();

        if($post)
            return response()->json(['data' => $this->postsTransformer->transform($post)]);

        return response()->json(['message' => "No query results for model [".Posts::class."]"], 404);
    }

    public function store(PostsRequest $request)
    {
        $request['user_id'] = $request->user()->id;

        $response = Posts::create($request->toArray());

        return response()->json(['data' => $this->postsTransformer->transform($response)], 201);
    }

    public function update($slug, PostsRequest $request)
    {
        $response = Posts::where('slug', $slug)
                    ->update($request->toArray());

        if($response) {
        	$post = Posts::where('slug', $request->get('slug'))->first(); // fetch again the data
            return response()->json(['data' => $this->postsTransformer->transform($post)]);
        }

        return response()->json(['message' => 'No record updated'], 422);
    }

    public function delete($slug)
    {
        $deleted = Posts::where('slug',$slug)->delete();

        if($deleted) {
            return response()->json(['status' => 'Record deleted sucessfully']);
        }

        return response()->json(['status' => 'No record deleted'], 422);
    }
}