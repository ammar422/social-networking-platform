<?php

namespace App\Http\Controllers\Api\Posts;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Gate;

class ApiPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * # Get all posts with user information

     *@OA\Get(
     *  path="api/user/posts",
     * summary="Get all posts with user information",
     * description="Retrieves all posts along with their associated user data.",
     * tags={"posts"},
     * @OA\Response(
     *   response=200,
     *  description="Successful operation",
     *  @OA\JsonContent(
     *    type="object",
     *     @OA\Property(
     *       property="message",
     *      type="string",
     *       example="The data has been retrieved successfully"
     *    ),  
     *    )
     *   )
     * )
     *)
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json(['message' => 'success opreation', $posts]);
    }

    /**
     * Store a newly created resource in storage.
     * /**
     * 
     * 
     *  * @OA\Post(
     *     path="/api/user/posts",
     *     summary="create a post",
     *     tags={"posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="This is a sample content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="post created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified post has been created successfully"),
     *             @OA\Property(
     *                 property="post",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="content", type="string", example="This is a sample content"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="post not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="content",
     *                     type="array",
     *                     @OA\Items(type="string", example="The content field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(PostRequest $request)
    {
        $post = Post::create([
            'user_id' => auth()->guard('api')->id(),
            'content' => $request->validated('content'),
        ]);
        return response()->json(['message' => 'The Specified post has been created successfully', 'post' => $post]);
    }

    /**
     * Display the specified resource.
     * * @OA\Get(
     *   path="api/user/posts/{id}",
     *   summary="Get a specific post with user information",
     *   description="Retrieves a single post identified by its ID, along with the associated user data.",
     *   tags={"posts"},
     *    @OA\Parameter(
     *     name="id",
     *      in="path",
     *      description="The ID of the post to retrieve",
     *      required=true,
     *      @OA\Schema(
     *        type="string"
     *      )
     *    ),
     *   @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *      @OA\JsonContent(
     *        type="object",
     *        @OA\Property(
     *          property="message",
     *          type="string",
     *          example="The Specified post has been retrieved successfully"
     *        ),
     *      )
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="post not found"
     *    )
     *  )
     */
    public function show(Post $post)
    {
        if ($post) {
            return response()->json(['message' => 'The Specified post has been retrieved successfully', 'post' => $post]);
        }
        return response()->json(['message' => 'post not found', 404]);
    }

    /**
     * Update the specified resource in storage.
     * 
     *  * @OA\Patch(
     *     path="/api/user/posts/{id}",
     *     summary="Update a post",
     *     tags={"posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bio"},
     *             @OA\Property(property="bio", type="string", example="This is a sample bio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="post updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified post has been updated successfully"),
     *             @OA\Property(
     *                 property="post",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="bio", type="string", example="This is a sample bio"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="post not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="bio",
     *                     type="array",
     *                     @OA\Items(type="string", example="The bio field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);
        $validatedData = $request->validate([
            'content' => 'string',
        ]);

        if ($post) {
            $post->update($validatedData);
            return response()->json(['message' => 'The Specified post has been updated successfully', 'post' => $post]);
        }
        return response()->json(['message' => 'post not found', 404]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * * @OA\Delete(
     *     path="/api/user/posts/{id}",
     *     summary="Delete a user post",
     *     description="Deletes the specified user post by ID",
     *     operationId="destroyUserpost",
     *     tags={"posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user post to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The specified post has been deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The specified post has been deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="post not found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();
        return response()->json(['message' => 'The Specified post has been deleted successfully', 204]);
    }
}
