<?php
// app/Models/Equipment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'manufacturer', 'serial_number'];

    public function experiments()
    {
        return $this->belongsToMany(Experiment::class, 'experiment_equipment');
    }
}
