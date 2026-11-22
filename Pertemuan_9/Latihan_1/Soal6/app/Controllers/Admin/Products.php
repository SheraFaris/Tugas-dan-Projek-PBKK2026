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


    /**
     * Upload foto produk.
     *
     * Return:
     * - string: nama file yang berhasil diupload
     * - null: tidak ada file yang dipilih
     *
     * Throws RuntimeException jika upload gagal.
     */
    private function uploadProductImage(): ?string
    {
    // 1. Ambil file dari form
    $file = $this->request->getFile('image');

    // Tidak ada file yang dipilih
    if ($file === null ||
        $file->getError() === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    // 2. Periksa status upload
    if (!$file->isValid()) {
        throw new \RuntimeException(
            $file->getErrorString()
        );
    }

    // 3. Aturan validasi gambar
    $rules = [
        'image' => [
            'rules' =>
                'uploaded[image]' .
                '|is_image[image]' .
                '|mime_in[image,image/jpeg,image/png]' .
                '|max_size[image,1024]' .
                '|max_dims[image,1080,1080]'
        ]
    ];

    // 4. Validasi file
    if (!$this->validate($rules)) {
        $errors = $this->validator->getErrors();

        throw new \RuntimeException(
            implode('; ', $errors)
        );
    }

    // 5. Tentukan folder tujuan
    $uploadPath = FCPATH . 'upload/product/';

    if (!is_dir($uploadPath)) {
        throw new \RuntimeException(
            'Folder upload produk tidak ditemukan.'
        );
    }

    // 6. Buat nama file acak
    $newName = $file->getRandomName();

    // 7. Pindahkan file
    if (!$file->move($uploadPath, $newName)) {
        throw new \RuntimeException(
            'Gagal menyimpan foto produk.'
        );
    }

    // 8. Kembalikan nama file
    return $newName;
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
        // Jika request POST, proses CREATE
        if ($this->request->is('post')) {
            
            $imageName = null;
        
            try {
                
                // 1. Ambil data dari form                
                $data = [
                    'name' => $this->request->getPost('name'),
                    'price' => $this->request->getPost('price'),
                    'description' => $this->request->getPost('description'),
                ];                

                // 2. Upload gambar melalui method Checkpoint 2
                $imageName = $this->uploadProductImage();

                // 3. Tentukan nama gambar untuk database
                $data['image'] = $imageName ?? 'default.jpg';

                // 4. Simpan produk menggunakan Model
                $result = $this->productModel->addProduct($data);     
                
                // 5. Jika validasi atau INSERT gagal
                if ($result === false) {

                    // Hapus gambar baru agar tidak menjadi file yatim
                    if ($imageName !== null) {
                        $filePath = FCPATH . 'upload/product/' . $imageName;

                        if (is_file($filePath)) {
                            unlink($filePath);
                        }
                    }

                    return redirect()->back()
                        ->withInput()
                        ->with('errors', $this->productModel->errors());
                }   
                
                // 6. Jika berhasil, kembali ke daftar produk
                return redirect()->to('/admin/products')
                    ->with('success', 'Produk dan foto berhasil disimpan!');  
            } catch (\Throwable $e) {

                // Bersihkan gambar jika ada error setelah upload
                if ($imageName !== null) {
                    $filePath = FCPATH . 'upload/product/' . $imageName;

                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }

                log_message('error', 'Gagal menambah produk: {message}', [
                    'message' => $e->getMessage()
                ]);

                // Error upload yang aman ditampilkan pada form
                $message = $e instanceof \RuntimeException
                    ? $e->getMessage()
                    : 'Gagal menyimpan produk. Periksa log aplikasi.';

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [$message]);                
            }
        }
    
        // Jika request GET, tampilkan form tambah produk
        return view('admin/product/new_form');
    }

    // UPDATE: Mengubah produk
    public function edit($id = null)
    {
        // 1. Pastikan ID diberikan
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        // 2. Ambil data produk lama
        $product = $this->productModel->getById($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound();
        }

        // 3. Jika request POST, proses UPDATE
        if ($this->request->is('post')) {

            $newImageName = null;
            $oldImageName = $product['image'] ?? 'default.jpg';

            try {
                // 4. Ambil input dari form
                $data = [
                    'name' => $this->request->getPost('name'),
                    'price' => $this->request->getPost('price'),
                    'description' => $this->request->getPost('description'),
                ];

                // 5. Coba upload foto baru
                // Menghasilkan null jika tidak ada file baru
                $newImageName = $this->uploadProductImage();

                // 6. Jika ada foto baru, ubah kolom image
                if ($newImageName !== null) {
                    $data['image'] = $newImageName;
                }

                // Jika tidak ada foto baru, kolom image
                // tidak diubah sehingga foto lama tetap ada.

                // 7. Simpan perubahan ke database
                $result = $this->productModel->updateProduct(
                    $id,
                    $data
                );

                // 8. Jika UPDATE gagal karena validasi
                if ($result === false) {

                    // Hapus foto baru yang sudah diupload
                    if ($newImageName !== null) {
                        $newPath = FCPATH
                            . 'upload/product/'
                            . $newImageName;

                        if (is_file($newPath)) {
                            unlink($newPath);
                        }
                    }

                    return redirect()->back()
                        ->withInput()
                        ->with(
                            'errors',
                            $this->productModel->errors()
                        );
                }

            } catch (\Throwable $e) {

                // 9. Bersihkan foto baru jika ada exception
                if ($newImageName !== null) {
                    $newPath = FCPATH
                        . 'upload/product/'
                        . $newImageName;

                    if (is_file($newPath)) {
                        unlink($newPath);
                    }
                }

                log_message(
                    'error',
                    'Gagal update produk: {message}',
                    ['message' => $e->getMessage()]
                );

                $message = $e instanceof \RuntimeException
                    ? $e->getMessage()
                    : 'Gagal memperbarui produk. Periksa log.';

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [$message]);
            }

            // 10. UPDATE berhasil.
            // Hapus foto lama jika sudah diganti.
            if (
                $newImageName !== null &&
                $oldImageName !== 'default.jpg' &&
                $oldImageName !== $newImageName &&
                preg_match('/^[a-zA-Z0-9_.-]+$/', $oldImageName)
            ) {
                $oldPath = FCPATH
                    . 'upload/product/'
                    . $oldImageName;

                if (is_file($oldPath)) {
                    if (!@unlink($oldPath)) {
                        log_message(
                            'warning',
                            'Gagal menghapus foto lama produk ID: {id}',
                            ['id' => $id]
                        );
                    }
                }
            }

            // 11. Kembali ke daftar produk
            return redirect()->to('/admin/products')
                ->with(
                    'success',
                    'Produk berhasil diperbarui!'
                );
        }

        // 12. Jika request GET, tampilkan form
        return view('admin/product/edit_form', [
            'product' => $product
        ]);
    }


    // DELETE: Menghapus produk
    public function delete($id = null)
    {
        // 1. Pastikan ID tersedia
        if ($id === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        // 2. Cari produk berdasarkan ID
        $product = $this->productModel->getById($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound();
        }

        // 3. Simpan nama foto sebelum data dihapus
        $imageName = $product['image'] ?? 'default.jpg';

        try {
            // 4. Hapus record produk dari database
            $result = $this->productModel->deleteProduct($id);

            // 5. Jika penghapusan database gagal
            if ($result === false) {
                return redirect()->to('/admin/products')
                    ->with(
                        'error',
                        'Gagal menghapus produk dari database.'
                    );
            }

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Gagal menghapus produk ID {id}: {message}',
                [
                    'id' => $id,
                    'message' => $e->getMessage()
                ]
            );

            return redirect()->to('/admin/products')
                ->with(
                    'error',
                    'Terjadi kesalahan saat menghapus produk.'
                );
        }

        // 6. Database berhasil dihapus.
        // Bersihkan foto jika bukan default.jpg.

    // 6. Bersihkan foto setelah DELETE database berhasil
        try {
            if (
                is_string($imageName) &&
                $imageName !== 'default.jpg' &&
                preg_match(
                    '/\A[a-zA-Z0-9_-][a-zA-Z0-9_.-]*\z/D',
                    $imageName
                ) &&
                !str_contains($imageName, '..')
            ) {
                // Cek apakah foto dipakai produk lain
                $otherProducts = $this->productModel
                    ->where('image', $imageName)
                    ->countAllResults();

                if ($otherProducts === 0) {
                    $imagePath = FCPATH
                        . 'upload/product/'
                        . $imageName;

                    if (is_file($imagePath) &&
                        !@unlink($imagePath)) {
                        log_message(
                            'warning',
                            'Gagal menghapus file foto: {image}',
                            ['image' => $imageName]
                        );
                    }
                }
            }
        } catch (\Throwable $e) {
            log_message(
                'warning',
                'Produk sudah dihapus, tetapi pembersihan foto gagal: {message}',
                ['message' => $e->getMessage()]
            );
        }


        // 7. Kembali ke daftar produk
        return redirect()->to('/admin/products')
            ->with(
                'success',
                'Produk berhasil dihapus!'
            );
    }

}
