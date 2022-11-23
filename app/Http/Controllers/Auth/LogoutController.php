<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class LogoutController extends Controller
{
    use HttpResponses;

    #[OA\Post(
        path: '/logout',
        operationId: "logout", summary: "Logout a user", tags: ["Authenticate"],
        responses: [
            new OA\Response(response: 200, description: "Logout a user"),
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
            Auth::user()->currentAccessToken()->delete();
            return $this->success();
        } catch (\Exception $error) {
            return $this->error("Error in logout", 500);
        }
    }
}
