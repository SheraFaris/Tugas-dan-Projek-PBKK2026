
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Toko Buah</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand"
       href="<?= site_url('admin/products') ?>">
        Toko Buah - Admin
    </a>
</nav>

<div class="container-fluid mt-4">

    <h2>Daftar Produk</h2>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <div class="card mb-3">

        <div class="card-header">
            <a href="<?= site_url('admin/products/add') ?>"
               class="btn btn-primary btn-sm">
                + Add New
            </a>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover"
                       id="dataTable">

                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Photo</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($products as $product): ?>

                        <tr>
                            <td>
                                <?= esc($product['name']) ?>
                            </td>

                            <td>
                                Rp <?= number_format(
                                    (float) $product['price'],
                                    0, ',', '.'
                                ) ?>
                            </td>

                        
                            <!-- PHOTO -->
                            <td>
                                <?php
                                    $imageName = $product['image'] ?? 'default.jpg';

                                    $imagePath = FCPATH . 'upload/product/' . $imageName;

                                    $hasImage = $imageName !== 'default.jpg'
                                        && preg_match('/^[a-zA-Z0-9_.-]+$/', $imageName)
                                        && is_file($imagePath);
                                ?>

                                <?php if ($hasImage): ?>

                                    <img
                                        src="<?= esc(base_url(
                                            'upload/product/' . rawurlencode($imageName)
                                        ), 'attr') ?>"
                                        alt="<?= esc($product['name'], 'attr') ?>"
                                        width="80"
                                        height="80"
                                        style="object-fit: cover; border-radius: 5px;">

                                <?php else: ?>

                                    <span class="text-muted">
                                        Belum ada foto
                                    </span>

                                <?php endif; ?>
                            </td>


                            <td>
                                <?= esc(mb_strimwidth(
                                    $product['description'],
                                    0, 120, '...'
                                )) ?>
                            </td>

                            <td>
                                <a
                                    href="<?= site_url(
                                        'admin/products/edit/'
                                        . $product['product_id']
                                    ) ?>"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form
                                    action="<?= site_url(
                                        'admin/products/delete/'
                                        . $product['product_id']
                                    ) ?>"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus produk ini?'
                                    );">

                                    <?= csrf_field() ?>

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>

                <?php if (empty($products)): ?>
                    <p class="text-center text-muted">
                        Belum ada produk.
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

</body>
</html>
