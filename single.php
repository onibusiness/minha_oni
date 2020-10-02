<?php get_header(); ?>
  <style>
    .categoria_atual{
      text-decoration: underline;
    }
  </style>
  <div class="container-fluid">
    <?php get_template_part( 'template-parts/search' );?>
    <div class="row py-5">
      <?php
      while ( have_posts() ) : the_post();
        $categorias = get_the_category();

        $categoria_pai = get_category( 
          $categorias[0]->category_parent 
        );

        $categorias_irmas = get_categories(
          array( 'hide_empty'      => false, 'parent' => $categorias[0]->category_parent )
        );
        

        $categorias_filhas = get_categories(
          array( 'hide_empty'      => false, 'parent' => $categorias[0]->cat_ID )
        );
      ?>
        <div class="col-3 ">
          <p>
            <a class='escala2 bold' href="<?php echo get_category_link($categoria_pai->cat_ID) ?>">
              <?php echo $categoria_pai->name;?>
            </a>
          </p>

          <?php foreach($categorias_irmas as $categoria_irma):?>
            <?php 
              if($categoria_irma->cat_ID == $categorias[0]->cat_ID){
                $classe = "categoria_atual";
              }else{
                $classe = "";
              }
            ?>
            <p>
              <a class="<?php echo $classe; ?>" href="<?php echo get_category_link($categoria_irma->cat_ID) ?>">
                <?php echo $categoria_irma->name;?>
              </a>
            </p>
          <?php endforeach;?>
        </div>
        <article class="col-6 card p-5">
        
          <h1 class='escala3 onipink bold mb-4'>
            <?php the_title();?>
          </h1>
        
          <?php the_content();?>
        </article>
        <div class="col-3">
          <?php foreach($categorias_filhas as $categoria_filha):?>
          <p>
            <a href="<?php echo get_category_link($categoria_filha->cat_ID) ?>">
              <?php echo $categoria_filha->name;?>
            </a>
          </p>
           
          <?php endforeach;?>
        </div>
      <?php
      endwhile;
      ?>
    </div>
  </div>

<?php get_footer(); ?>