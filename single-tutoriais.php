<?php get_header(); ?>

  <div class="container-fluid">
    <?php get_template_part( 'template-parts/search' );?>
    <div class="row py-5">
        <div class="col-3"></div> 
        <article class="col-6 card p-5">
       
          <?php
          
          while(have_posts()): the_post();
              ?>
              <h1 class='escala3 onipink bold mb-4'>
                <?php the_title();?>
              </h1>
              <?php
                if( have_rows('conteudo') ):
                  while( have_rows('conteudo') ) : the_row();

                      $explicacao = get_sub_field('explicacao');
                      $artigo_obj = get_sub_field('artigo');
                      $artigo_title = get_post_field('post_title', $artigo_obj->ID);
                      $artigo_content = get_post_field('post_content', $artigo_obj->ID);
                      ?>
                      <div><?php echo $explicacao;?></div>
                      <div>
                        <h3 class='escala1 onipink bold '>
                          <?php echo $artigo_title;?>
                        </h3>
                        <?php echo $artigo_content;?>
                      </div>
                      <?
                      

                  endwhile;
                endif;
      
              ?>
              <?php
          endwhile;
          ?>
        
        </article>
        <div class="col-3"> </div>

    </div>
  </div>

<?php get_footer(); ?>