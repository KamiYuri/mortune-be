<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\JsonContent;

class LoginController extends Controller
{
    use HttpResponses;

    #[Post(
        path: "/login", operationId: "login", summary: "Login a user",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "email", type: "string"),
                            new Property(property: "password", type: "string"),
                        ],
                        example: ["email" => "abc@example.org", "password" => "password"]
                    ),
                )
            ]
        ),
        tags: ["Authenticate"],
        responses: [
            new Response(response: 200, description: "Login successfully", content: new JsonContent
                (
                    properties:
                    [
                        new Property(property: "user", properties: [
                            new Property(property: "id", type: "int"),
                            new Property(property: "name", type: "string"),
                            new Property(property: "email", type: "string"),
                            new Property(property: "updated_at", type: "string"),
                            new Property(property: "created_at", type: "string"),
                        ], type: "object"),
                        new Property(property: 'token', type: "string"),
                    ],
                    example:
                    [
                        "user" => [
                            "id" => 1,
                            "name" => "abc",
                            "email" => "abc@example.org",
                            "updated_at" => "2022-11-09T17:55:48.000000Z",
                            "created_at" => "2022-11-09T17:55:48.000000Z"],
                        "token" => "1|wVhhEjCMqeShx15CAUYVBysIUh3uM9Rsb7v9QOqO"
                    ]
                ),
            ),
            new Response(response: 402, description: "Credentials do not match"),
            new Response(response: 500, description: "Error in login"),
        ],
    )]

    /**
     * Handle an authentication attempt.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return $this->error('Credentials do not match', 402);
            }

            $token = Auth::user()->createToken('API_Token')->plainTextToken;

            return $this->success([
                'user' => new UserResource(Auth::user()),
                'token' => $token,
            ], 'Login successfully.');
        } catch (Exception $error) {
            return $this->error($error);
        }
    }
}
