<?php

namespace Database\Seeders;

use App\Models\AuthorBook;
use Illuminate\Database\Seeder;

class AuthorBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AuthorBook::factory(500)->create();
    }
}
