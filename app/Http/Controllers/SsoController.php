<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use jbs1\OAuth2\Client\Provider\EveOnline;
use Mockery\Exception;

class SsoController extends Controller
{
    public function index(Request $request)
    {
        $authCode = $request->input('code');
        if(empty($authCode)) {
            throw new Exception("Eve Authentication Failed");
        }

        $provider = new EveOnline([
            'clientId'                => config('app.eve_app_id'),
            'clientSecret'            => config('app.eve_app_secret'),
            'redirectUri'             => route("sso"),
        ]);

        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $authCode,
            ]);

            echo 'Access Token: ' . $accessToken->getToken() . "<br>";
            echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
            echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
            echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

            $owner = $provider->getResourceOwner($accessToken);

            Character::firstOrCreate([
                'id' => $owner->getCharacterID(),
                'user_id' => Auth::id(),
            ], [
                'name' => $owner->getCharacterName(),
                'owner' => $owner->getCharacterOwnerHash(),
                'refresh_token' => $accessToken->getToken(),
            ]);

            return redirect()->route('farm', ['#character' . $owner->getCharacterID()]);
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token or user details.
            return response()->view('error.missing', [
                'code' => 401,
                'message' => $e->getMessage()
            ])->setStatusCode(401); // 401 Not Unauthorized
        }

//

        return redirect()->route('index');
    }
}
