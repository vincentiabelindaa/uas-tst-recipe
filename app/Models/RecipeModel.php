<?php namespace App\Models;

use CodeIgniter\Model;

class RecipeModel extends Model
{
    protected $table = 'recipes';
    
    protected $primaryKey = 'recipe_name';
    protected $useAutoIncrement = false; 
    
    protected $allowedFields = ['recipe_name', 'ingredients', 'matched_ingredients'];
}