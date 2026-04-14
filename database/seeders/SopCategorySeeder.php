<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sops = [
            ["id" => 1, "name" => "Communication"],
            ["id" => 2, "name" => "CONFLICT"],
            ["id" => 3, "name" => "FINANCE"],
            ["id" => 4, "name" => "LOGISTICS"],
            ["id" => 5, "name" => "ROMANCE"],
            ["id" => 6, "name" => "BOUNDARIES"],
            ["id" => 7, "name" => "GROWTH"],
        ];
    }
}
