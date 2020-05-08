<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Sébastien Merour">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL; ?>public/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL; ?>public/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL; ?>public/images/icons/favicon-16x16.png">
    <link rel="manifest" href="<?= BASE_URL; ?>site.webmanifest">
    <!-- Prism -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>public/css/prism.css">
    <!-- style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet">
    <script src="https://kit.fontawesome.com/14f8a7289e.js"></script>
    <!-- Custom styles for this template -->
    <link href="<?php echo BASE_URL; ?>public/css/scroll-back.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/css/dashboard.css" rel="stylesheet">
    <!-- TINYMCE script -->
    <script src="https://cdn.tiny.cloud/1/g3t2j6ax1fih16h88zn6d7z6bd9akw3ur6zuo3p7qainhbeq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
      selector: '#content',
      auto_focus: 'element1',
      height: "400px",
        });
    </script>
    <title><?php echo $title; ?></title>
</head>
<body>
