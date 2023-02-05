<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Laravolt\Avatar\Facade as Avatar;
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
                'username' => $request["username"],
                'email' => $request["email"],
                'password' => Hash::make($request["password"])
            ]);

            $path = "avatars/".$user->id."/";

            if(!File::isDirectory($path))
                File::makeDirectory($path, 0777, true,true);

            $avatar_file_name = time().'.png';
            Avatar::create($request["username"])->save(public_path($path.$avatar_file_name));

            $user->update(["avatar_url" => "avatars/".$user->id."/".$avatar_file_name]);

            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API_Token')->plainTextToken,
            ], 'Register successfully.');
        } catch (Exception $error) {
            return $this->error($error);
        }
    }
}
