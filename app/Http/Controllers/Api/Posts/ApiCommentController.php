<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     * *@OA\Get(
     *  path="api/user/comments",
     * summary="Get all comments with user information",
     * description="Retrieves all comments along with their associated user data.",
     * tags={"comments"},
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
        $comment = Comment::where('user_id', auth()->guard('api')->id())->get();
        return response()->json(['message' => 'success opreation', $comment]);
    }

    /**
     * Store a newly created resource in storage.
     * /**
     * 
     * 
     *   @OA\Post(
     *     path="/api/user/comments",
     *     summary="create a comment",
     *     tags={"comments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="This is a sample content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="comment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified comment has been created successfully"),
     *             @OA\Property(
     *                 property="comment",
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
     *         description="comment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="comment not found")
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
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string']
        ]);
        $comment = Comment::create([
            'user_id' => auth()->guard('api')->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);
        if ($comment) {
            return response()->json(['message' => 'The Specified comment has been created successfully', 'comment' => $comment]);
        }
        return response()->json(['message' => 'The comment has not created ', 500]);
    }

    /**
     * Display the specified resource.
     * * @OA\Get(
     *   path="api/user/comments/{id}",
     *   summary="Get a specific comment with user information",
     *   description="Retrieves a single post identified by its ID, along with the associated user data.",
     *   tags={"comments"},
     *    @OA\Parameter(
     *     name="id",
     *      in="path",
     *      description="The ID of the comment to retrieve",
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
     *          example="The Specified comment has been retrieved successfully"
     *        ),
     *      )
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="comment not found"
     *    )
     *  )
     */
    public function show(Comment $comment)
    {
        // $matchThese = [
        //     'id' => $id,
        //     'user_id' => auth()->guard('api')->id()
        // ];
        // $comment = Comment::where($matchThese)->get();
        $comment = Comment::find($comment)->where('user_id', auth()->guard('api')->id())->first();
        if ($comment)
            return response()->json(['message' => 'The Specified comment has been retrieved successfully', 'comment' => $comment]);
        return response()->json(['message' => 'comment not found', 404]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * * @OA\Patch(
     *     path="/api/user/comments/{id}",
     *     summary="Update a comment",
     *     tags={"comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the comment to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="This is a sample content")
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id"},
     *             @OA\Property(property="post_id", type="string", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="comment updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified comment has been updated successfully"),
     *             @OA\Property(
     *                 property="comment",
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
     *         description="comment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="comment not found")
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
    public function update(Request $request, Comment $comment)
    {

        $request->validate([
            'content' => 'string',
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        if ($comment) {
            $comment->update([
                'content' => $request->content
            ]);
            return response()->json(['message' => 'The Specified comment has been updated successfully', 'comment' => $comment]);
        }
        return response()->json(['message' => 'comment not found', 404]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * * @OA\Delete(
     *     path="/api/user/comments/{id}",
     *     summary="Delete a user comment",
     *     description="Deletes the specified user comment by ID",
     *     operationId="destroyUsercomment",
     *     tags={"comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user comment to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The specified comment has been deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The specified comment has been deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="comment not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="comment not found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'The Specified comment has been deleted successfully', 204]);
    }
}
