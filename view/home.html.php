<?php $this->extend('layout') ?>

<?php $this->start('title') ?>
<?= 'home' ?>
<?php $this->end() ?>

<?php $this->start('styles') ?>
<script src="styles/main.css"></script>
<script src="styles/coponent.css"></script>
<?php $this->end() ?>


<?php $this->start('content') ?>

<h1>Bonjour <?= $name ?></h1>

<?php $this->end() ?>