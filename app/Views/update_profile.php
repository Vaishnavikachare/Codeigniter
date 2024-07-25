<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Update Profile</h2>
    <form action="/update-profile" method="post" id="updateProfileForm">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?= set_value('city') ?>">
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" value="<?= set_value('state') ?>">
        </div>
        <div class="mb-3">
            <label for="zip" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zip" name="zip" value="<?= set_value('zip') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger mt-3"><?= $validation->listErrors() ?></div>
    <?php endif; ?>
</div>
</body>
</html>
