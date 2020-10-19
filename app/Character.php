<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function skillpoints()
    {
        //

        $this->skillpoints = "5900000";

        return $this->skillpoints;
    }

    public function skillpointsMin()
    {
        //

        return "5500000";
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
