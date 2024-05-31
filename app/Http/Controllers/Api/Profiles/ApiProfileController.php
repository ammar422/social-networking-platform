<?php

namespace App\Http\Controllers\Api\Profiles;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiProfileController extends Controller
{

    /**
     * # Get all profiles with user information

     *@OA\Get(
     *  path="api/user/profiles",
     * summary="Get all profiles with user information",
     * description="Retrieves all profiles along with their associated user data.",
     * tags={"Profiles"},
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
        $data = Profile::with('user')->get();
        return response()->json(['message' => 'The all profiles has been retrieved successfully', 'profiles' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *   path="api/user/profiles/{id}",
     *   summary="Get a specific profile with user information",
     *   description="Retrieves a single profile identified by its ID, along with the associated user data.",
     *   tags={"Profiles"},
     *    @OA\Parameter(
     *     name="id",
     *      in="path",
     *      description="The ID of the profile to retrieve",
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
     *          example="The Specified profile has been retrieved successfully"
     *        ),
     *      )
     *    ),
     *    @OA\Response(
     *      response=404,
     *      description="Profile not found"
     *    )
     *  )
     */
    public function show(string $id)
    {
        $data = Profile::find($id)->with('user')->first();
        if ($data) {
            return response()->json(['message' => 'The Specified profile has been retrieved successfully', 'profile' => $data]);
        }
        return response()->json(['message' => 'Profile not found', 404]);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Patch(
     *     path="/api/user/profiles/{id}",
     *     summary="Update a profile",
     *     tags={"Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the profile to update",
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
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The Specified profile has been updated successfully"),
     *             @OA\Property(
     *                 property="profile",
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
     *         description="Profile not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile not found")
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
    public function update(Request $request, Profile $profile)
    {
        $validatedData = $request->validate([
            'bio' => 'string'
        ]);

        if ($profile) {
            $profile->update($validatedData);
            return response()->json(['message' => 'The Specified profile has been updated successfully', 'profile' => $profile]);
        }
        return response()->json(['message' => 'Profile not found', 404]);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/user/profiles/{id}",
     *     summary="Delete a user profile",
     *     description="Deletes the specified user profile by ID",
     *     operationId="destroyUserProfile",
     *     tags={"Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user profile to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The specified profile has been deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The specified profile has been deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profile not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Profile not found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $profile = Profile::find($id)->first();
        if ($profile) {
            Auth::guard('api')->logout();
            $profile->delete();
            return response()->json(['message' => 'The Specified profile has been deleted successfully', 204]);
        }
        return response()->json(['message' => 'Profile not found', 404]);
    }
}
