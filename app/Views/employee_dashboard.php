<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
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
</div>
<div class="container">
    <h4>Dealers List</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
            </tr>
        </thead>
        <tbody>
            <?php if($dealers): ?>
                <?php foreach($dealers as $dealer): ?>
                    <tr>
                        <td><?= esc($dealer['first_name']) ?></td>
                        <td><?= esc($dealer['last_name']) ?></td>
                        <td><?= esc($dealer['email']) ?></td>
                        <td><?= esc($dealer['city']) ?></td>
                        <td><?= esc($dealer['state']) ?></td>
                        <td><?= esc($dealer['zip']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No Dealers Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?= $pager->links() ?>
</div>
</body>
</html>
