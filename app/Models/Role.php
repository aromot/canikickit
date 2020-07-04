<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  public $timestamps = null;

  protected $fillable = [
		'name'
  ];
  
  static public function make(string $name): self
  {
    return new self([
      'name' => $name
    ]);
  }
}