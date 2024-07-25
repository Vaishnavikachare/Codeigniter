<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Dealers</h2>
    <form method="get" action="/dealers">
        <div class="mb-3">
            <input type="text" name="zip" class="form-control" placeholder="Search by Zip Code">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dealers as $dealer): ?>
                <tr>
                    <td><?= $dealer['first_name'] ?></td>
                    <td><?= $dealer['last_name'] ?></td>
                    <td><?= $dealer['email'] ?></td>
                    <td><?= $dealer['city'] ?></td>
                    <td><?= $dealer['state'] ?></td>
                    <td><?= $dealer['zip'] ?></td>
                    <td>
                        <a href="/edit-dealer/<?= $dealer['id'] ?>" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $pager->links() ?>
</div>
</body>
</html>
