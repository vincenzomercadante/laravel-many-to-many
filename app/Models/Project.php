<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type_id',
        'description',
        'github_reference',
        'slug',
    ];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function get_description($n_charts){
        return ($n_charts < strlen($this->description)) ? substr($this->description, 0, $n_charts) . '...' : substr($this->description, 0, $n_charts);
    }
}
