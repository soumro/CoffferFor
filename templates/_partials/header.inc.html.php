<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?> -
        <?= site_name() ?>
    </title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= site_url('/assets/materialize/css/materialize.css') ?>" rel="stylesheet"
        media="screen,projection" />
    <link href="<?= site_url('/assets/css/style.css') ?>" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
    <?php include 'top-menu-inc.htm.php' ?>
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <?php include 'messages.inc.html.php' ?>