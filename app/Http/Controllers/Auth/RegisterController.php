<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
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
        }catch (Exception $error) {
            return Helper::sendError('Error in register', $error, 500);
        }
    }
}
