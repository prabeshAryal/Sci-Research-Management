<?php
// app/Models/Researcher.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Researcher extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'institution'];

    public function experiments()
    {
        return $this->belongsToMany(Experiment::class);
    }
}
