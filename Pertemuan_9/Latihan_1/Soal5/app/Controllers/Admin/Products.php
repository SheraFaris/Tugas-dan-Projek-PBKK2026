<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    // READ: Menampilkan semua produk
    public function index()
    {
        $data['products'] = $this->productModel->getAll();

        return view('admin/product/list', $data);
    }

    // CREATE: Menambah produk
    public function add()
    {
        if ($this->request->is('post')) {

            $data = [
                'name' => $this->request->getPost('name'),
                'price' => $this->request->getPost('price'),
                'description' => $this->request->getPost('description'),
            ];

            if ($this->productModel->addProduct($data) === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->productModel->errors());
            }

            return redirect()->to('/admin/products')
                ->with('success', 'Produk berhasil ditambahkan!');
        }

        return view('admin/product/new_form');
    }

    // UPDATE: Mengubah produk
    public function edit($id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $product = $this->productModel->getById($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($this->request->is('post')) {

            $data = [
                'name' => $this->request->getPost('name'),
                'price' => $this->request->getPost('price'),
                'description' => $this->request->getPost('description'),
            ];

            if ($this->productModel->updateProduct($id, $data) === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->productModel->errors());
            }

            return redirect()->to('/admin/products')
                ->with('success', 'Produk berhasil diperbarui!');
        }

        $data['product'] = $product;

        return view('admin/product/edit_form', $data);
    }

    // DELETE: Menghapus produk
    public function delete($id = null)
    {
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $product = $this->productModel->getById($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->productModel->deleteProduct($id);

        return redirect()->to('/admin/products')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
