<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Auth;

class LogoutController extends Controller
{
    use HttpResponses;

    public function logout() {
        Auth::user()->currentAccessToken()->delete();
        return $this->success();
    }
}
