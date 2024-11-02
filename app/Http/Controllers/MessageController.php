<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use App\Jobs\ProcessAttachment;


/**
 * @OA\Tag(
 *     name="Messages",
 *     description="API Endpoints for managing messages in chatrooms"
 * )
 */
class MessageController extends Controller
{
    /**
     * Send a message in a chatroom.
     *
     * @OA\Post(
     *     path="/api/message/send",
     *     summary="Send a message in a chatroom",
     *     tags={"Messages"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="chatroom_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="message_text", type="string", example="Hello everyone!"),
     *             @OA\Property(property="attachment", type="string", format="binary", example="file.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Message sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="object", ref="#/components/schemas/Message")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function send(Request $request)
    {
        $request->validate([
            'chatroom_id' => 'required|exists:chatrooms,id',
            'user_id' => 'required|exists:users,id',
            'message_text' => 'nullable|string',
            'attachment' => 'nullable|file',
        ]);

        $message = Message::create([
            'chatroom_id' => $request->chatroom_id,
            'user_id' => $request->user_id,
            'message_text' => $request->message_text,
            'attachment_path' => null,
        ]);

        if ($request->hasFile('attachment')) {
            ProcessAttachment::dispatch($message, $request->file('attachment'));
        }

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message], 201);
    }

     /**
     * List all messages in a chatroom.
     *
     * @OA\Get(
     *     path="/api/messages/{chatroom_id}",
     *     summary="List messages in a chatroom",
     *     tags={"Messages"},
     *     @OA\Parameter(
     *         name="chatroom_id",
     *         in="path",
     *         required=true,
     *         description="ID of the chatroom",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of messages in the chatroom",
     *         @OA\JsonContent(
     *             @OA\Property(property="messages", type="array", @OA\Items(ref="#/components/schemas/Message"))
     *         )
     *     ),
     *     @OA\Response(response=404, description="Chatroom not found")
     * )
     */
    public function list($chatroom_id)
    {
        $messages = Message::where('chatroom_id', $chatroom_id)->with('user')->get();
        return response()->json(['messages' => $messages]);
    }
}
