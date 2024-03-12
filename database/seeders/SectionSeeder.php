<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'section_name'=>'one section',
            'description'=>'one section',
            'Created_by'=>'abeer',
        ]);
        Section::create([
            'section_name'=>'two section',
            'description'=>'two section',
            'Created_by'=>'abeer',
        ]);
        Section::create([
            'section_name'=>'three section',
            'description'=>'three section',
            'Created_by'=>'abeer',
        ]);
    }
}
