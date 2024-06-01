<?php

namespace App\Http\Controllers\Api\Posts;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     * *@OA\Get(
     *  path="api/user/likes",
     * summary="Get all likes with user information",
     * description="Retrieves all likes along with their associated user data.",
     * tags={"likes"},
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
        $Like = Like::where('user_id', auth()->guard('api')->id())->get();
        return response()->json(['message' => 'success opreation', $Like]);
    }

    /**
     * Store a newly created resource in storage.
     * /**
     * 
     * 
     *   @OA\Post(
     *     path="/api/user/likes",
     *     summary="create a like",
     *     tags={"likes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id"},
     *             @OA\Property(property="post_id", type="string", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="like created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified like has been created successfully"),
     *             @OA\Property(
     *                 property="like",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="post_id", type="string", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="like not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="like not found")
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
     *                     property="post_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The post_id field is required.")
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
        ]);
        $like = Like::create([
            'user_id' => auth()->guard('api')->id(),
            'post_id' => $request->post_id,
        ]);
        if ($like) {
            return response()->json(['message' => 'The Specified like has been created successfully', 'like' => $like]);
        }
        return response()->json(['message' => 'The like has not created ', 500]);
    }

    /**
     * Display the specified resource.
     * * @OA\Get(
     *   path="api/user/likes/{id}",
     *   summary="Get a specific like with user information",
     *   description="Retrieves a single post identified by its ID, along with the associated user data.",
     *   tags={"likes"},
     *    @OA\Parameter(
     *     name="id",
     *      in="path",
     *      description="The ID of the like to retrieve",
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
     *          example="The Specified like has been retrieved successfully"
     *        ),
     *      )
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="like not found"
     *    )
     *  )
     */
    public function show(Like $like)
    {
        // $matchThese = [
        //     'id' => $id,
        //     'user_id' => auth()->guard('api')->id()
        // ];
        // $like = Like::where($matchThese)->get();
        $like = Like::find($like)->where('user_id', auth()->guard('api')->id())->first();
        if ($like)
            return response()->json(['message' => 'The Specified like has been retrieved successfully', 'like' => $like]);
        return response()->json(['message' => 'like not found', 404]);
    }

    /**
     * Update the specified resource in storage.
     * 
     *  * @OA\Patch(
     *     path="/api/user/likes/{id}",
     *     summary="Update a like",
     *     tags={"likes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the like to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="like updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified like has been updated successfully"),
     *             @OA\Property(
     *                 property="like",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="like not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="like not found")
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
     *                     property="post_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The post_id field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, Like $like)
    {

        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        if ($like) {
            $like->update([
                'post_id' => $request->post_id
            ]);
            return response()->json(['message' => 'The Specified like has been updated successfully', 'like' => $like]);
        }
        return response()->json(['message' => 'like not found', 404]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * * @OA\Delete(
     *     path="/api/user/likes/{id}",
     *     summary="Delete a user like",
     *     description="Deletes the specified user like by ID",
     *     operationId="destroyUserlike",
     *     tags={"likes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user like to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The specified like has been deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The specified like has been deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="like not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="like not found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Like $like)
    {
        $like->delete();
        return response()->json(['message' => 'The Specified like has been deleted successfully', 204]);
    }
}
