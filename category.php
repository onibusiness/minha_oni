<?php get_header(); ?>

  <div class="container-fluid">
    <?php get_template_part( 'template-parts/search' );?>
    <div class="row py-5">
        <div class="col-2"></div> 
        <div class="col-8">
          <div class="row">
            <?php
            $categoria_atual = get_queried_object();
            $categorias_filhas = get_categories(
                array( 'hide_empty'      => false, 'parent' => $categoria_atual->cat_ID )
            );

            ?>
            <div class='col-4 my-3'>
                <div class='card p-5'>
                <h2 class='escala3 onipink bold'><?php echo $categoria_atual->name;?></h2>
                <?php
                if($categorias_filhas):
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
                else:
                    $args = array(
                        'post_type' => 'post',
                        'order' => 'DESC',
                        'cat' => $categoria_atual->cat_ID
                    );
                    $the_query = new WP_Query($args);
                        if($the_query->have_posts()):while($the_query->have_posts()): $the_query->the_post();
                        ?>
                        <a class='escala-1 pl-3' href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
                        <?php
                        endwhile;

                    endif;
                endif;
                ?>
                </div>
            </div>
          </div>
        </div>
        <div class="col-2"> </div>

    </div>
  </div>

<?php get_footer(); ?>