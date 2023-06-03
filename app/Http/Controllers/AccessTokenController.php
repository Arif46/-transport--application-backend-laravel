<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;

class AccessTokenController extends Controller
{
    /**
     * issue token function
     */
    public function issueToken(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        $client = Client::where('password_client', true)->first();

        $response = $http->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->username,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);

        return $response->getBody();
    }
}
