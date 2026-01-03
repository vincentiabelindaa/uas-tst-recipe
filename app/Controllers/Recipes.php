<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RecipeModel;

class Recipes extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        // authentication
        $key = $this->request->getHeaderLine('X-API-KEY');

        if (empty($key) || $key !== 'belin123') {
            return $this->failUnauthorized('Maaf, API Key tidak valid untuk melihat resep.');
        }

        $model = new RecipeModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $model = new RecipeModel();
        
        $data = $model->find($id);

        if ($data) {
            if (!empty($data['ingredients'])) {
                $ingredientsArray = explode(',', $data['ingredients']);
                $data['ingredients_list'] = array_map('trim', $ingredientsArray);
            }
            
            return $this->respond($data);
        } else {
            return $this->failNotFound('Resep dengan nama "' . $id . '" tidak ditemukan.');
        }
    }

    public function create()
    {
        $model = new RecipeModel();
        $data = [
            'recipe_name'        => $this->request->getVar('recipe_name'),
            'ingredients'        => $this->request->getVar('ingredients'),
            'matched_ingredients'=> $this->request->getVar('matched_ingredients'),
        ];
        
        if ($model->find($data['recipe_name'])) {
            return $this->failResourceExists('Resep dengan nama ini sudah ada.');
        }

        $model->insert($data);
        return $this->respondCreated(['message' => 'Resep berhasil dibuat', 'data' => $data]);
    }
}