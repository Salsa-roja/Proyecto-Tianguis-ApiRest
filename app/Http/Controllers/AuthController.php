<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function authenticate()
    {
        $this->validate($this->request, [
            'user'     => 'required',
            'password'  => 'required'
        ]);
        $auth = AuthService::authenticate($this->request->user, $this->request->password);
        return response()->json($auth, $auth['status']);
    }
}
