<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Batch;
use App\Models\Exam;
use App\Models\Examtype;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'medition' => $this->faker->randomFloat(0, 0, 9999999999.),
            'examtype_id' => Examtype::factory(),
            'batch_id' => Batch::factory(),
        ];
    }
}
