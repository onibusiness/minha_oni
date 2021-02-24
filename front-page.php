<?php get_header(); ?>
<div class="row">
    <div class="col-12 col-md-3">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/card-user-info.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-guardas.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-proximas-ferias.php');
        ?>
    </div>
    <div class="col-12 col-md-8 pl-md-0">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/search.php');
        include(get_stylesheet_directory() . '/template-parts/comunicados.php');
        include(get_stylesheet_directory() . '/template-parts/card-todos-ferias.php');
        include(get_stylesheet_directory() . '/template-parts/card-todos-metodos.php');
        include(get_stylesheet_directory() . '/template-parts/card-todos-competencias.php');
        ?>

    </div>
</div>



<?php get_footer();?>