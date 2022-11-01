<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title><?= $model['title'] ?? 'Marleess'; ?></title>

    <!--Bootstrap  v5.2.1 (https://getbootstrap.com/)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $model['resource']['style'] ?>style.css" rel="stylesheet">

</head>
<body class="bg-dark <?= $model['resource']['black'] ?? '' ?>">
<div class="container-fluid">