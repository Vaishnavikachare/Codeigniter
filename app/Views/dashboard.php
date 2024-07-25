<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= session()->get('first_name') ?> <?= session()->get('last_name') ?></h2>
    <a href="/logout" class="btn btn-danger">Logout</a>

    <?php if (session()->get('user_type') == 'Employee'): ?>
        <h3>Employee Dashboard</h3>
        <a href="<?= base_url('dashboard/dealers') ?>" class="btn btn-primary">View Dealers</a>
    <?php elseif (session()->get('user_type') == 'Dealer'): ?>
        <h3>Dealer Dashboard</h3>
        <a href="<?= base_url('dashboard/update-profile') ?>" class="btn btn-primary">Update Profile</a>
    <?php endif; ?>
</div>
</body>
</html>
