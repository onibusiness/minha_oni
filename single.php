<?php get_header(); ?>
  <style>
    .categoria_atual{
      text-decoration: underline;
    }
  </style>

  <?php get_template_part( 'template-parts/search' );?>
  <div class="row py-5 px-3">
    <?php
    $id_atual = get_the_id();
    while ( have_posts() ) : the_post();
      $categorias = get_the_category();

      $categoria = get_category( 
        $categorias[0]->category_parent 
      );
      $categorias_filhas = get_categories(
        array( 'hide_empty'      => false, 'parent' => $categoria->cat_ID )
      );

    ?>
      <div class="col-3 order-2 order-md-1  pt-2 px-4">
        <?php include(get_stylesheet_directory() . '/template-parts/card-categoria-expandido.php');?>
      </div>
      <article class="card col-12 col-md-6 order-1 order-md-2 p-4 p-md-5">
      
        <h1 class='escala3 onipink bold mb-4'>
          <?php the_title();?>
        </h1>
      
        <?php the_content();?>
      </article>

    <?php
    endwhile;
    ?>
  </div>


<?php get_footer(); ?>