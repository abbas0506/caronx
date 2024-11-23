<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Type::create(['sr' => 1, 'name' => 'MCQs', 'default_title' => 'Choose the correct option']);
        Type::create(['sr' => 2, 'name' => 'Short', 'default_title' => 'Answer the following short questions']);
        Type::create(['sr' => 3, 'name' => 'Long', 'default_title' => null]);
        Type::create(['sr' => 4, 'name' => 'Examples', 'default_title' => null]);
        Type::create(['sr' => 5, 'name' => 'Numericals', 'default_title' => null]);
        // 
    }
}
