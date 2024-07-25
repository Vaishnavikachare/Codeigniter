<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= session()->get('first_name') ?> <?= session()->get('last_name') ?></h2>
    <a href="/logout" class="btn btn-danger" style="float:right;">Logout</a>
    <br>
    <?php if (session()->get('user_type') == 'Employee'): ?>
        <h5>This is Employee Dashboard</h5>
        <hr><br><br>
    <?php elseif (session()->get('user_type') == 'Dealer'): ?>
        <h5>This is Dealer Dashboard</h5>
       
    <?php endif; ?>
</div><br><br>
<div class="container">
    <h4>Dealer Profile</h4>
    <table class="table table-bordered mt-3">
        <tr>
            <th>First Name</th>
            <td><?= esc($dealer['first_name']) ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?= esc($dealer['last_name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($dealer['email']) ?></td>
        </tr>
        <tr>
            <th>City</th>
            <td><?= esc($dealer['city']) ?></td>
        </tr>
        <tr>
            <th>State</th>
            <td><?= esc($dealer['state']) ?></td>
        </tr>
        <tr>
            <th>Zip</th>
            <td><?= esc($dealer['zip']) ?></td>
        </tr>
    </table>
    <a href="<?= base_url('update-profile') ?>" class="btn btn-primary">Edit Profile</a>
    
</div>
</body>
</html>
