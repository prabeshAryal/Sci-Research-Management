<?php
// database/factories/EquipmentFactory.php
namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'manufacturer' => $this->faker->company(),
            'serial_number' => $this->faker->unique()->bothify('SN-####'),
        ];
    }
}
