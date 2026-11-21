
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - Toko Buah</title>

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

    <h2>Tambah Produk</h2>

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
                    <strong>Periksa kembali input berikut:</strong>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form
                action="<?= site_url('admin/products/add') ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- NAME -->
                <div class="form-group">
                    <label for="name">Name*</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Product name"
                        value="<?= esc(old('name')) ?>"
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
                        placeholder="Product price"
                        value="<?= esc(old('price')) ?>"
                        required>
                </div>

                <!-- PHOTO -->
                <div class="form-group">
                    <label for="image">Photo</label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control-file"
                        accept="image/*">

                    <small class="form-text text-muted">
                        Upload foto belum diaktifkan.
                        Produk akan menggunakan default.jpg.
                    </small>
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label for="description">Description*</label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Product description..."
                        required><?= esc(old('description')) ?></textarea>
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
