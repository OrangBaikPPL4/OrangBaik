<?php

namespace Database\Factories;

use App\Models\Relawan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelawanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Relawan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telepon' => $this->faker->phoneNumber,
            'lokasi' => $this->faker->city,
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['aktif', 'bertugas', 'selesai']),
            'verification_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

    /**
     * Indicate that the relawan is verified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'aktif',
                'verification_status' => 'approved',
            ];
        });
    }

    /**
     * Indicate that the relawan is pending.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'aktif',
                'verification_status' => 'pending',
            ];
        });
    }
}
