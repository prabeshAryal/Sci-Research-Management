<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Researcher;
use App\Models\Equipment;
use App\Models\Experiment;
use App\Models\Observation;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $researchers = Researcher::factory()->count(3)->create();
        $equipment = Equipment::factory()->count(3)->create();
        $experiments = Experiment::factory()->count(2)->create();

        // Attach researchers and equipment to experiments
        foreach ($experiments as $experiment) {
            $experiment->researchers()->attach($researchers->random(2));
            $experiment->equipment()->attach($equipment->random(2));
            Observation::factory()->count(3)->create([
                'experiment_id' => $experiment->id
            ]);
        }
    }
}
