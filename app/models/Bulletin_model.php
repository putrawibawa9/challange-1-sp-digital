<?php

class Bulletin_model extends Model
{
    // Table
    protected static $table = 'bulletin';
    protected static $primaryKey = 'id';


    // Fields
    public $text;
    public $timestamp;
}
?>
