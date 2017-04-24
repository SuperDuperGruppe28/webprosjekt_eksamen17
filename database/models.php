<?php
require_once $_SERVER['DOCUMENT_ROOT']  . '/vendor/autoload.php';
require_once __DIR__ . '/databaseconfig.php';

use Illuminate\Database\Eloquent\Model as mod;


//
// Bruker
//

class Bruker extends mod
{
    public $table = "Bruker";
    public $primaryKey = "Brukernavn";
    public $incrementing = false;
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tags()
    {
        return $this->belongsTo("TagsBruker", "Brukernavn", "Bruker");
    }
    
    public function kommentarer()
    {
        return $this->belongsTo("Kommentar", "Brukernavn", "Bruker");
    }
    
    public function aktiviteter()
    {
        return $this->belongsTo("Aktivitet", "Brukernavn", "Bruker");
    }
    
    public function deltagelse()
    {
        return $this->belongsTo("Deltagelse", "Brukernavn", "Bruker");
    }
}

//
// TagsBruker
//

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

//
// Tags
//

class Tags extends mod
{
    public $table = "Tags";
    public $primaryKey = "Tag";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    public $incrementing = false;

    public function tagsBruker()
    {
        return $this->belongsTo("TagsBruker", "Tag", "Tag");
    }
}

//
// Aktivitet
//

class Aktivitet extends mod
{
    public $table = "Aktivitet";
    public $primaryKey = "id";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function brukere()
    {
        return $this->hasMany("Bruker", "Brukernavn", "Bruker");
    }
    
    public function tags()
    {
        return $this->belongsTo("TagsAktivitet", "id", "Aktivitet");
    }
    
    public function kommentarfelt()
    {
        return $this->belongsTo("Kommentarfelt", "id", "Aktivitet");
    }
    
    public function stemmer()
    {
        return $this->belongsTo("AktivitetStemmer", "id", "Aktivitet");
    }
    
    public function deltagere()
    {
        return $this->belongsTo("Deltagre", "id", "Aktivitet");
    }
}


//
// TagsAktivitet
//

class TagsAktivitet extends mod
{
    public $table = "TagsAktivitet";
    public $primaryKey  = "id";
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function tags()
    {
        return $this->hasMany("Tags", "Tag", "Tag");
    }
    
    public function aktiviteter()
    {
        return $this->hasMany("Aktivitet", "id", "Bruker");
    }
    
}

//
// Stemmer
//

class Stemmer extends mod
{
    public $table = "Stemmer";
    public $primaryKey = 'id';
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function aktivitet()
    {
        return $this->hasMany("Aktivitet", "id", "Aktivitet");
    }
    
    public function brukere()
    {
        return $this->hasMany("Bruker", "Brukernavn", "Bruker");
    }
}


//
// Kommentarfelt
//

class Kommentarfelt extends mod
{
    public $table = "Kommentarfelt";
    public $primaryKey = 'id';
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function aktivitet()
    {
        return $this->hasMany("Aktivitet", "id", "Aktivitet");
    }
    
    public function kommentarer()
    {
        return $this->belongsTo("Kommentar", "id", "Kommentar");
    }
}

//
// Kommentar
//

class Kommentar extends mod
{
    public $table = "Kommentar";
    public $primaryKey = 'id';
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function brukere()
    {
        return $this->hasMany("Bruker", "Brukernavn", "Bruker");
    }
    
    public function kommentarfelt()
    {
        return $this->hasmany("Kommentarfelt", "id", "Kommentarfelt");
    }
}

//
// Deltagelse
//

class Deltagelse extends mod
{
    public $table = "Deltagelse";
    public $primaryKey = 'id';
    protected $dates = ["starts_at"];
    public $timestamps = false;
    
    public function aktivitet()
    {
        return $this->hasMany("Aktivitet", "id", "Aktivitet");
    }
    
    public function brukere()
    {
        return $this->hasMany("Bruker", "Brukernavn", "Bruker");
    }
}