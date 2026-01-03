<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(ROOTPATH . 'recipes.csv', 'r'); 
        $firstline = true;

        $this->db->table('recipes')->truncate();

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            if (!$firstline) {
                $this->db->table('recipes')->insert([
                    'recipe_name' => $data[0],
                    'ingredients' => $data[1],
                    'matched_ingredients' => $data[2], 
                ]);
            }
            $firstline = false;
        }
        fclose($file);
    }
}