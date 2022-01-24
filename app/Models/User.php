<?php
namespace App\Models;

use Simplecode\Database\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint; 

class User extends Model{

    protected $fillable = ['name','email','password'];
    
   static function createTable(){
    $schema = DB::Schema();
    //Crée la table si ça n'existe pas
    if (!$schema->hasTable('users')) {
        $schema->create('users', function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
   }
}