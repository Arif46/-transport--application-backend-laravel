<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorizedAccessTokenController extends Controller
{
    /**
     * refresh token function
     */
    public function refresh(Request $request)
    {
        $token = $request->user()->token();
        $newToken = $token->refresh();

        return response()->json([
            'access_token' => $newToken->accessToken,
            'token_type' => 'Bearer',
            'expires_in' => $newToken->expires_at->diffInSeconds(now()),
        ]);
    }

    /**
     * revoke  token function
     */
    public function revoke(Request $request)
    {
        $tokenId = $request->user()->token()->id;

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $tokenId)
            ->update(['revoked' => true]);

        $request->user()->token()->revoke();

        return response()->json(['message' => 'Token revoked successfully']);
    }
}
