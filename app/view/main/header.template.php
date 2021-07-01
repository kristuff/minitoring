<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Kristuff">
    <meta name="copyright" content="Kristuff">
    <meta http-equiv="Content-Language" content="fr-FR">
    <meta http-equiv="Cache-Control" content="max-age=200">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/site.webmanifest">
    <link rel="mask-icon" href="/assets/img/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/assets/img/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/assets/img/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- /favicon -->

    <title><?php echo $this->title; ?></title>
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/font-awesome.min.css">     
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/kristuff.minikit.min.css">
    <link rel="stylesheet" href="<?php echo $this->baseUrl; ?>assets/css/minitoring.min.css">
    <script type="application/javascript" src="<?php echo $this->baseUrl; ?>assets/js/kristuff.minikit.min.js"></script>
    <script type="application/javascript" src="<?php echo $this->baseUrl; ?>assets/js/minitoring.min.js"></script>

<?php if ($this->data('userIsAdmin') === true) {  ?>
    <script src="<?php echo $this->baseUrl; ?>assets/js/minitoring.config.min.js"></script> 
<?php  } ?>

</head>   
<body class="" 
    data-style="flat" 
    data-theme="<?php echo htmlentities($this->data('UI_THEME')); ?>" 
    data-color="<?php echo htmlentities($this->data('UI_THEME_COLOR')); ?>" 
    data-language="<?php echo $this->data("UI_LANG"); ?>" 
    data-api-token="<?php echo $this->data('apiToken'); ?>">
