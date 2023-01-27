<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Request;

class LogoutController extends Controller
{
    use HttpResponses;

    #[OA\Post(
        path: '/logout',
        operationId: "logout", summary: "Logout a user", tags: ["Authenticate"],
        responses: [
            new OA\Response(response: 200, description: "Logout successfully."),
            new OA\Response(response: 500, description: "Error in logout"),
        ]
    )]
    /**
     * Handle logout request
     *
     * @return JsonResponse
     */
    public function logout() {
        try {
            Auth::user()->tokens()->delete();

            return $this->success(null, "Logout successfully.");
        } catch (Exception $error) {
            return $this->error("Error in logout ".$error, 500);
        }
    }
}
