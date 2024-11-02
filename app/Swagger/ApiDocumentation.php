<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="WhatsApp API Clone",
 *     version="1.0.0",
 *     description="This is the API documentation for the WhatsApp API Clone project.",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
class ApiDocumentation
{
    // This class is only for Swagger annotations and does not need any methods.
}
