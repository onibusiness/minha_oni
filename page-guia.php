<?php
/*
Template Name: Guia de conhecimento
*/ 
?>
<?php get_header(); ?>

  <div class="container-fluid">
    <?php get_template_part( 'template-parts/search' );?>
    <div class="row py-5">
        <div class="col-2"></div> 
        <div class="col-8">
          <div class="row">
            <?php
            $categorias = get_categories(array('hide_empty' => false));
            foreach($categorias as $categoria):
              if($categoria->category_parent == 0 && $categoria->cat_ID !== 1 ):
                $categorias_filhas = get_categories(
                  array( 'hide_empty'      => false, 'parent' => $categoria->cat_ID )
                );
                ?>
                <div class='col-4 my-3'>
                  <div class='card p-5'>
                    <h2 class='escala3 onipink bold'><?php echo $categoria->name;?></h2>
                    <?php
                    foreach($categorias_filhas as $categoria_filha):
                      ?>
                        <h3 class='escala0 petro bold'><?php echo $categoria_filha->name;?></h3>
                      <?php
                      $args = array(
                        'post_type' => 'post',
                        'order' => 'DESC',
                        'cat' => $categoria_filha->cat_ID
                      );
                      $the_query = new WP_Query($args);
                        if($the_query->have_posts()):while($the_query->have_posts()): $the_query->the_post();
                          ?>
                          <a class='escala-1 pl-3' href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
                          <?php
                        endwhile;

                      endif;
                    endforeach;
                    ?>
                  </div>
                </div>
              <?php
                
              endif;
            endforeach;
            ?>
          </div>
        </div>
        <div class="col-2"> </div>

    </div>
  </div>

<?php get_footer(); ?>