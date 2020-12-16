<?php
/*
Template Name: Guia de conhecimento
*/ 
?>
<?php get_header(); ?>


    <?php get_template_part( 'template-parts/search' );?>
    <div class="row py-5">
        <div class="col-12">
          <div class="row">
            <?php
            $categorias = get_categories(array('hide_empty' => false));
            foreach($categorias as $categoria):
              if($categoria->category_parent == 0 && $categoria->cat_ID !== 1 ):
                $categorias_filhas = get_categories(
                  array( 'hide_empty'      => false, 'parent' => $categoria->cat_ID )
                );
                ?>
                <div class='col-12 col-md-4 col-lg-3 my-3'>
                  <div class='card p-4 p-md-5'>
                    <?php include(get_stylesheet_directory() . '/template-parts/card-categoria.php');?>
                  </div>
                </div>
              <?php
                
              endif;
            endforeach;
            ?>
          </div>
        </div>
    </div>


<?php get_footer(); ?>