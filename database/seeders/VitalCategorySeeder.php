<?php

namespace Database\Seeders;

use App\Models\VitalCategory;
use Illuminate\Database\Seeder;

class VitalCategorySeeder extends Seeder
{
    /**
     * Seed the vital_categories table with default health categories.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Blood Pressure',
                'icon'        => 'droplet',
                'description' => 'Blood pressure monitoring category',
                'status'      => 'active',
            ],
            [
                'name'        => 'Heart Rate',
                'icon'        => 'heart',
                'description' => 'Heart rate monitoring category',
                'status'      => 'active',
            ],
            [
                'name'        => 'Temperature',
                'icon'        => 'thermometer',
                'description' => 'Body temperature monitoring category',
                'status'      => 'active',
            ],
            [
                'name'        => 'Blood Sugar',
                'icon'        => 'blooddrop',
                'description' => 'Blood sugar monitoring category',
                'status'      => 'active',
            ],
            [
                'name'        => 'Weight',
                'icon'        => 'scale',
                'description' => 'Weight monitoring category',
                'status'      => 'inactive',
            ],
        ];

        foreach ($categories as $category) {
            // Avoid duplicate seeds on re-run
            VitalCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
