<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<?php    if ( !is_user_logged_in() ) {
      auth_redirect();
      
  } 
  ?>
  <head>
  <?php 
    
    wp_head(); 
 
    ?>

    <link rel=”alternate” href=”https://www.oni.com.br” hreflang=”pt-br” />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="content-language" content="pt-br">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo bloginfo('url'); ?>/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo bloginfo('url'); ?>/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo bloginfo('url'); ?>/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo bloginfo('url'); ?>/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo bloginfo('url'); ?>/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo bloginfo('url'); ?>/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo bloginfo('url'); ?>/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo bloginfo('url'); ?>/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo bloginfo('url'); ?>/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo bloginfo('url'); ?>/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo bloginfo('url'); ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo bloginfo('url'); ?>/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo bloginfo('url'); ?>/favicon-16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=yes"/>
    <meta name="theme-color" content="#ed1843"/>


    <title>Minha Oni</title>


    <link rel="preload" href="<?php echo bloginfo('template_directory'); ?>/css/webfonts/355CEC_14_0.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="<?php echo bloginfo('template_directory'); ?>/css/webfonts/355CEC_20_0.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="<?php echo bloginfo('template_directory'); ?>/css/bootstrap.min.css" as="style">
    
		<link rel="preload" href="<?php echo bloginfo('template_directory'); ?>/css/apps.css" as="style">
    <link rel="preload" href="<?php echo bloginfo('template_directory'); ?>/css/fonts.css" as="style">
    <link rel="preload" href="<?php echo bloginfo('template_directory'); ?>/css/bootstrap.min.css" as="style">

		<link rel="stylesheet" href="<?php echo bloginfo('template_directory'); ?>/css/apps.css">
    <link rel="stylesheet" href="<?php echo bloginfo('template_directory'); ?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo bloginfo('template_directory'); ?>/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/4dad82588a.js" crossorigin="anonymous"></script>

    <?php
      /* Esse snnipet te mostra qual arquivo do template está sendo renderizado no front
      global $template;
      echo basename($template);*/
    ?>
    <nav class="navbar navbar-expand-lg navbar-light  " role="navigation">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse-menu" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a  href="<?php echo bloginfo('url'); ?>">
          <img style='height:80px;' src="<?php echo bloginfo('template_directory'); ?>/img/Oni-Asssinatura-02.svg"/>
        </a>
        <div id= "collapse-menu" class = "navbar-collapse collapse">
          <?php
          wp_nav_menu( array(
            'theme_location' => 'menu-geral', 
            'container' => 'ul', 
            'menu_class' => 'navbar-nav w-100 escala1 d-flex justify-content-end',
          ));
          ?>
        </div>
      </nav>
  </head>
  <body >
  <div class="row">
    <div class="col-12 px-4 py-2">