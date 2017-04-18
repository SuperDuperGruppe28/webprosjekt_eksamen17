<?php
use Illuminate\Database\Eloquent\Model as mod;

class TagsBruker extends mod
{
    public $table = "TagsBruker";
    public $primaryKey  = "id";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tags()
    {
        return $this->hasMany("Tags", "Tag", "Tag");
    }
    
    public function brukere()
    {
        return $this->hasMany("Bruker", "Brukernavn", "Bruker");
    }
}

class Tags extends mod
{
    public $table = "Tags";
    public $primaryKey = "tag";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tagsBruker()
    {
        return $this->belongsTo("TagsBruker", "Tag", "Tag");
    }
}

class Bruker extends mod
{
    public $table = "Bruker";
    public $primaryKey = "Brukernavn";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tags()
    {
        return $this->belongsTo("TagsBruker", "Brukernavn", "Bruker");
    }
}

class Aktivitet extends mod
{
    public $table = "Aktivitet";
    public $primaryKey = 'id';
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tags()
    {
        return $this->hasMany("Tags");
    }
}