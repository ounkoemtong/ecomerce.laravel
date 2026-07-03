<?php

namespace Database\Factories;

use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->numerify('##########'),
            'role_id' => RoleModel::query()->firstOrCreate(['name' => 'customer'])->id,
            'status' => 'active',
        ];
    }
}
