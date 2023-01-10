<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->show('styles') ?>
    <?php $this->show('scripts') ?>
    <title><?php $this->show('title') ?></title>
</head>

<body>
    <header>
        <nav>
            <?php $this->yield('partial.nav') ?>
        </nav>
    </header>
    <?php $this->show('content') ?>
</body>

</html>