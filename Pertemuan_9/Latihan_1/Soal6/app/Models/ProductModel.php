<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $useAutoIncrement = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'name',
        'price',
        'image',
        'description'
    ];

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'price' => 'required|numeric',
        'description' => 'required'
    ];

    // READ: Mengambil seluruh produk
    public function getAll()
    {
        return $this->findAll();
    }

    // READ: Mengambil produk berdasarkan ID
    public function getById($id)
    {
        return $this->find($id);
    }

    // CREATE: Menambahkan produk baru
    public function addProduct($data)
    {
        $data['product_id'] = bin2hex(random_bytes(16));

        if (empty($data['image'])) {
            $data['image'] = 'default.jpg';
        }

        return $this->insert($data);
    }

    // UPDATE: Mengubah produk
    public function updateProduct($id, $data)
    {
        return $this->update($id, $data);
    }

    // DELETE: Menghapus produk
    public function deleteProduct($id)
    {
        return $this->delete($id);
    }
}
