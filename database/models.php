<?php
use Illuminate\Database\Eloquent\Model as mod;

class Bruker extends mod
{
    public $table = "Bruker";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tags()
    {
        return $this->belgongsTo('TagsBruker');
    }
}

class Aktivitet extends mod
{
    public $table = "Aktivitet";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
}
