<?php

namespace Database\Factories;

use App\Models\Misi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class MisiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Misi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = Carbon::now()->addDays(rand(1, 10));
        $endDate = (clone $startDate)->addDays(rand(5, 30));
        
        return [
            'nama_misi' => $this->faker->sentence(4),
            'deskripsi' => $this->faker->paragraph(3),
            'lokasi' => $this->faker->city,
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'kuota_relawan' => $this->faker->numberBetween(5, 50),
            'status' => 'aktif',
        ];
    }

    /**
     * Indicate that the mission is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function aktif()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'aktif',
            ];
        });
    }

    /**
     * Indicate that the mission is completed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function selesai()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'selesai',
            ];
        });
    }
}
