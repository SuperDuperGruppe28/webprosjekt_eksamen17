<?php
use Illuminate\Database\Eloquent\Model as mod;

class TestModel extends mod
{
    public $table = "aper";
    protected $dates = ["starts_at"];
    public $timestamps = false;
}