<?php
// database/factories/ExperimentFactory.php
namespace Database\Factories;

use App\Models\Experiment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperimentFactory extends Factory
{
    protected $model = Experiment::class;
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-1 year', 'now');
        $end = $this->faker->dateTimeBetween($start, '+1 month');
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
        ];
    }
}
