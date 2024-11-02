<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Chatroom",
 *     type="object",
 *     title="Chatroom",
 *     description="A chatroom model",
 *     required={"id", "name", "max_members"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the chatroom",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the chatroom",
 *         example="General Chat"
 *     ),
 *     @OA\Property(
 *         property="max_members",
 *         type="integer",
 *         description="The maximum number of members allowed in the chatroom",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The creation timestamp of the chatroom"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The last update timestamp of the chatroom"
 *     )
 * )
 */
class ChatroomSchema
{
    // This class is only for Swagger annotations and does not need any methods.
}
