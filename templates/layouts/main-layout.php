<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="<?= $css_file ?>">
        <link rel="shortcut icon" href="pictures/favicon.ico" type="image/x-icon">
    </head>
    <body>

        <?php if (isset($page_header)): ?>
            <?= $page_header ?>
        <?php endif; ?>

        <?= $page_content ?>
    </body>
</html>
