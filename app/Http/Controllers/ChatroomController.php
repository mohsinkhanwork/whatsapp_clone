<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatroom;
use OpenApi\Attributes as OA;

/**
 * @OA\Tag(
 *     name="Chatrooms",
 *     description="API Endpoints for managing chatrooms"
 * )
 */
class ChatroomController extends Controller
{

    /**
     * Create a new chatroom.
     *
     * @OA\Post(
     *     path="/api/chatroom/create",
     *      tags={"Chatrooms"},
     * @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="General Chat"),
     *             @OA\Property(property="max_members", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Chatroom created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="chatroom", type="object", ref="#/components/schemas/Chatroom")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_members' => 'required|integer|min:2',
        ]);

        $chatroom = Chatroom::create([
            'name' => $request->name,
            'max_members' => $request->max_members,
        ]);

        return response()->json(['chatroom' => $chatroom], 201);
    }

    /**
     * List all chatrooms.
     *
     * @OA\Get(
     *     path="/api/chatroom/list",
     *     summary="List all chatrooms",
     *     tags={"Chatrooms"},
     *     @OA\Response(
     *         response=200,
     *         description="List of chatrooms",
     *         @OA\JsonContent(
     *             @OA\Property(property="chatrooms", type="array", @OA\Items(ref="#/components/schemas/Chatroom"))
     *         )
     *     )
     * )
     */
    public function list()
    {
        $chatrooms = Chatroom::with('members')->get();
        return response()->json(['chatrooms' => $chatrooms]);
    }

    /**
     * Enter a chatroom.
     *
     * @OA\Post(
     *     path="/api/chatroom/enter",
     *      summary="Enter a chatroom",
     *     tags={"Chatrooms"}, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="chatroom_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Joined chatroom successfully"),
     *     @OA\Response(response=403, description="Chatroom is full"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function enter(Request $request)
    {
        $request->validate([
            'chatroom_id' => 'required|exists:chatrooms,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $chatroom = Chatroom::withCount('members')->findOrFail($request->chatroom_id);

        if ($chatroom->members_count >= $chatroom->max_members) {
            return response()->json(['error' => 'Chatroom is full'], 403);
        }

        $chatroom->members()->attach($request->user_id);

        return response()->json(['message' => 'Joined chatroom successfully']);
    }

    /**
     * Leave a chatroom.
     *
     * @OA\Post(
     *     path="/api/chatroom/leave",
     * summary="Leave a chatroom",
     *     tags={"Chatrooms"}, 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="chatroom_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Left chatroom successfully"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function leave(Request $request)
    {
        $request->validate([
            'chatroom_id' => 'required|exists:chatrooms,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $chatroom = Chatroom::findOrFail($request->chatroom_id);
        $chatroom->members()->detach($request->user_id);

        return response()->json(['message' => 'Left chatroom successfully']);
    }

}
