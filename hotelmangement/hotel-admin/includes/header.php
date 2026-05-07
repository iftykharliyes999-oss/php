<?php
// includes/header.php
if (!isset($PAGE_TITLE)) $PAGE_TITLE = 'Hotel Admin Pro';
if (!isset($ACTIVE))     $ACTIVE = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= e($PAGE_TITLE) ?> - Lisora Grand</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assact/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include __DIR__.'/sidebar.php'; ?>
<div class="main">
