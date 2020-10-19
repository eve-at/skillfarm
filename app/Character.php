<?php

namespace App;

use App\Library\Sso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Cache;
use Mockery\Exception;
use Swagger\Client\Eve\ApiException;

class Character extends Model
{
    public $incrementing = false;
    protected $skillpoints;
    protected $spPerExtractor = 500000;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'name', 'owner', 'refresh_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getToken()
    {
        if ($this->expires_in - time() > 15) {
            return $this->token;
        }

        $accessToken = Sso::provider()->getAccessToken('refresh_token', [
            'refresh_token' => $this->refresh_token
        ]);

        $this->token = $accessToken->getToken();
        $this->expires_in = $accessToken->getExpires();
        $this->save();

        return $this->token;
    }

    public function skillpoints()
    {
        return Sso::characterSkillpoints($this);
    }

    public function skillpointsMin()
    {
        return 5500000;
    }

    public function extractable()
    {
        //

        return $this->extractors() * $this->spPerExtractor;
    }

    public function extractors()
    {
        //

        return ceil(($this->skillpoints() - $this->skillpointsMin()) / $this->spPerExtractor);
    }
}
