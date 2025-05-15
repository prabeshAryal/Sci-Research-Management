<?php
// app/Models/Observation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;
    protected $fillable = ['experiment_id', 'observation_date', 'data', 'notes'];

    public function experiment()
    {
        return $this->belongsTo(Experiment::class);
    }
}
