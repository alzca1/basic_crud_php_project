<?php
if (!isset($page_title)) {
    $page_title = 'Staff Area';
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>GBI - <?php echo $page_title; ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo url_for('/stylesheets/staff.css') ?>">
</head>

<body>
    <header>
        <h1> GBI Staff Area</h1>
    </header>

    <navigation>

        <ul>
            <li> <a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>

        </ul>
    </navigation>