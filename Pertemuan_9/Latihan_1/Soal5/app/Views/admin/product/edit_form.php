
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Produk - Toko Buah</title>

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

    <h2>Edit Produk</h2>

    <div class="card mb-3">

        <div class="card-header">
            <a href="<?= site_url('admin/products') ?>">
                &larr; Back
            </a>
        </div>

        <div class="card-body">

            <?php $errors = session()->getFlashdata('errors') ?? []; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <strong>Periksa kembali input:</strong>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form
                action="<?= site_url(
                    'admin/products/edit/'
                    . $product['product_id']
                ) ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- PRODUCT ID -->
                <input
                    type="hidden"
                    name="id"
                    value="<?= esc($product['product_id']) ?>">

                <!-- NAME -->
                <div class="form-group">
                    <label for="name">Name*</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?= esc(old(
                            'name',
                            $product['name']
                        )) ?>"
                        required>
                </div>

                <!-- PRICE -->
                <div class="form-group">
                    <label for="price">Price*</label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-control"
                        min="0"
                        value="<?= esc(old(
                            'price',
                            $product['price']
                        )) ?>"
                        required>
                </div>

                <!-- PHOTO -->
                <div class="form-group">
                    <label for="image">Photo</label>

                    <?php if (
                        $product['image'] !== 'default.jpg'
                        && is_file(
                            FCPATH . 'upload/product/'
                            . $product['image']
                        )
                    ): ?>

                        <div class="mb-2">
                            <img
                                src="<?= base_url(
                                    'upload/product/'
                                    . rawurlencode($product['image'])
                                ) ?>"
                                width="100"
                                alt="Foto produk">
                        </div>

                    <?php endif; ?>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control-file"
                        accept="image/*">

                    <small class="form-text text-muted">
                        Upload foto belum diaktifkan.
                        Foto produk tidak akan berubah.
                    </small>
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label for="description">
                        Description*
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        required><?= esc(old(
                            'description',
                            $product['description']
                        )) ?></textarea>
                </div>

                <button
                    type="submit"
                    class="btn btn-success">
                    Save
                </button>

            </form>
        </div>

        <div class="card-footer small text-muted">
            * Required fields
        </div>

    </div>
</div>

</body>
</html>
