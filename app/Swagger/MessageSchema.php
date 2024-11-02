<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Message",
 *     type="object",
 *     title="Message",
 *     description="A message model representing chatroom messages",
 *     required={"id", "chatroom_id", "user_id", "message_text"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the message",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="chatroom_id",
 *         type="integer",
 *         description="The ID of the chatroom the message belongs to",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user who sent the message",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="message_text",
 *         type="string",
 *         description="The content of the message",
 *         example="Hello everyone!"
 *     ),
 *     @OA\Property(
 *         property="attachment_path",
 *         type="string",
 *         description="Path to the attachment file, if any",
 *         nullable=true,
 *         example="root/picture/file.jpg"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the message was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the message was last updated"
 *     )
 * )
 */
class MessageSchema
{
    // This class is used only for Swagger annotations and does not need any methods.
}
