<?php get_header(); ?>
<div class="row">
    <div class="col-4">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/card-user-info.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-guardas.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-proximas-ferias.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-equipamentos.php');
        ?>
    </div>
    <div class="col-8 pl-0">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/search.php');
        include(get_stylesheet_directory() . '/template-parts/comunicados.php');
        include(get_stylesheet_directory() . '/template-parts/card-todos-ferias.php');
        include(get_stylesheet_directory() . '/template-parts/card-todos-competencias.php');
        ?>

    </div>
</div>



<?php get_footer();?>