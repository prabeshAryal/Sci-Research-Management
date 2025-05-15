<?php
// database/factories/ResearcherFactory.php
namespace Database\Factories;

use App\Models\Researcher;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResearcherFactory extends Factory
{
    protected $model = Researcher::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'institution' => $this->faker->company(),
        ];
    }
}
