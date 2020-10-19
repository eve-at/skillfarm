<?php

namespace App\Http\Controllers;

use App\Character;
use App\Library\Sso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class SsoController extends Controller
{
    public function index(Request $request)
    {
        $authCode = $request->input('code');
        if(empty($authCode)) {
            throw new Exception("Eve Authentication Failed");
        }

        $provider = Sso::provider();

        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $authCode,
            ]);

            $owner = $provider->getResourceOwner($accessToken);

            $character = Character::firstOrCreate([
                'id' => $owner->getCharacterID(),
            ], [
                'name' => $owner->getCharacterName(),
            ]);
            $character->user_id = Auth::id();
            $character->owner = $owner->getCharacterOwnerHash();
            $character->token = $accessToken->getToken();
            $character->refresh_token = $accessToken->getRefreshToken();
            $character->expires_in = $accessToken->getExpires();
            $character->save();

            return redirect()->route('farm', ['#character' . $owner->getCharacterID()]);
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token or user details.
            return response()->view('error.missing', [
                'code' => 401,
                'message' => $e->getMessage()
            ])->setStatusCode(401); // 401 Not Unauthorized
        }
    }
}
