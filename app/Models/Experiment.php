<?php
// app/Models/Experiment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'start_date', 'end_date'];

    public function researchers()
    {
        return $this->belongsToMany(Researcher::class);
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'experiment_equipment');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }
}
