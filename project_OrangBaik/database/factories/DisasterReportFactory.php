<?php

namespace Database\Factories;

use App\Models\DisasterReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisasterReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DisasterReport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'lokasi' => $this->faker->address(),
            'jenis_bencana' => $this->faker->randomElement(['banjir', 'gempa', 'kebakaran', 'longsor', 'lainnya']),
            'deskripsi' => $this->faker->paragraph(3),
            'bukti_media' => json_encode(['banjir_test.jpg']),
            'status' => 'pending',
        ];
    }

    /**
     * Indicate that the report has been verified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'diterima',
            ];
        });
    }

    /**
     * Indicate that the report has been rejected.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'ditolak',
            ];
        });
    }
}
