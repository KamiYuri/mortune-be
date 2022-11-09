<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HttpResponses;

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
                $this->error('Credentials do not match', 402);
            }

            return $this->success([
                'user' => new UserResource(Auth::user()),
                'token' => Auth::user()->createToken('API Token')->plainTextToken,
            ]);
        } catch (Exception $error) {
            return Helper::sendError('Error in login', $error, 500);
        }
    }
}
