<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;

class RegisterController extends Controller
{
    use HttpResponses;

    #[Post(
        path: "/register", operationId: "register", summary: "Register a user",
        requestBody: new RequestBody
        (
            content: [
                new MediaType(
                    mediaType: "application/json",
                    schema: new Schema(
                        properties: [
                            new Property(property: "name", type: "string"),
                            new Property(property: "email", type: "string"),
                            new Property(property: "password", type: "string"),
                        ],
                        example: ["name" => "abc", "email" => "abc@example.org", "password" => "password"]
                    ),
                )
            ]
        ),
        tags: ["Authenticate"],
        responses: [
            new Response(response: 200, description: "Register successfully"),
            new Response(response: 500, description: "Error in login"),
        ],
    )]

    /**
     * Handle a register request.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request) {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'user' => new UserResource($user),
                'token' => $user->createToken('API Token')->plainTextToken,
            ]);
        }catch (Exception) {
            return $this->error('Error in register', 500);
        }
    }
}
