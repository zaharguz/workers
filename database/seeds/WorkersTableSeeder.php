<?php

use Illuminate\Database\Seeder;
use App\Worker;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int)$this->command->ask('How many workers do you need ?', 50000);

        $this->command->info("Creating {$count} workers");
        Worker::truncate();

        for ($i = 0; $i < $count; $i++) {
            factory(Worker::class)->create([
                'chief_id' => rand(Worker::min('id'), Worker::max('id')),
            ]);
        }

        $this->command->info('Workers Created!');
    }
}
