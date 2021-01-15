<h2 class='escala3 onipink bold'><?php echo $categoria->name;?></h2>
    
    <?php
    if($categoria->name == "Gestão de projeto"){
    ?>
        <h3><a class='escala0 onipink bold' href="<?php echo get_home_url()."/gestao"; ?>">Mapa de gestão </a></h3>
    <?php
    }
    if($categoria->name == "Carreira"){
    ?>
        <h3><a class='escala0 onipink bold' href="<?php echo get_home_url()."/mapa-competencias"; ?>">Mapa de competências </a></h3>
    <?php
    }
    foreach($categorias_filhas as $categoria_filha):
        $class= " ";
    $args = array(
        'post_type' => 'post',
        'order' => 'DESC',
        'cat' => $categoria_filha->cat_ID
    );
    $the_query = new WP_Query($args);
    if($the_query->have_posts()){
        $class= "categoria-guia ";
    }
    ?>
        <h3 data-toggle="collapse" data-target="<?php echo '#'.$categoria_filha->slug;?>" aria-expanded="false" aria-controls="<?php echo $categoria_filha->slug;?>"  class='<?php echo $class;?> escala0 petro bold'><?php echo $categoria_filha->name;?></h3>
        
        <?php
        if($the_query->have_posts()):
        ?>
        <div class=" collapse mb-4" id="<?php echo $categoria_filha->slug;?>">
        <?php  
        while($the_query->have_posts()): $the_query->the_post();
            ?>
            <p class="pl-3 m-0">
            
            <a class='escala-1 ' href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
            </p>
        <?php
        endwhile;
        ?>
        </div>
        <?php               
        endif;
        ?>
        
    <?php   
    endforeach;
    wp_reset_query();
    ?>
    