<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Book::create(['name' => 'Principles of Genetics', 'course_id' => 1]);
        Book::create(['name' => 'Introduction to Molecular Biology', 'course_id' => 2]);
    }
}
