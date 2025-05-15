<?php
// database/factories/ObservationFactory.php
namespace Database\Factories;

use App\Models\Observation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObservationFactory extends Factory
{
    protected $model = Observation::class;
    public function definition()
    {
        return [
            'observation_date' => $this->faker->date(),
            'data' => $this->faker->sentence(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
