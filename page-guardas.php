<?php get_header();?>
<div class="row">
    <div class="col-12 col-lg-7 offset-lg-1">
        <div class="atomic_card   background_white ">
            <div class="row d-flex justify-content-around ">
                <div class="col">
                    <p class=" escala1 bold grey">Projeto</p>
                </div>
                <div class="col text-center">
                    <p class=" escala1 bold onipink">Guardião da visão</p>
                </div>
                <div class="col text-center">
                    <p class=" escala1 bold onipink">Guardião do time</p>
                </div>
                <div class="col text-center">
                    <p class=" escala1 bold onipink">Guardião do método</p>
                </div>
            </div>
            <hr>
            <?php
              $meta_query[] =
              array(
                  'key' => 'status',
                  'value' => 'Ativo',
                  'compare' => '=='
              ); 
            $args = array(  
                'post_type' => 'projetos',
                'post_status' => array('publish'),
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'   => 'ASC',
                'meta_query' => $meta_query
            );
            $projetos = new WP_Query( $args ); 

            $args_guardas = array(  
                'post_type' => 'papeis',
                'post_status' => array('publish'),
                'posts_per_page' => -1,
            );
            $guardas = new WP_Query( $args_guardas ); 

           
            if($projetos->have_posts()):while($projetos->have_posts()): $projetos->the_post();
                $campos_projetos = get_fields();
                $projeto_id = get_the_id();
        
                ?>
                <div class="row d-flex justify-content-around">
                    <div class="col">
                        <p class="escala0"><?php echo $campos_projetos['projeto'];?></p>
                    </div>
                    <?php
                      $visao = null;
                      $time = null;
                      $metodo = null;
                    if($guardas->have_posts()):while($guardas->have_posts()): $guardas->the_post();
                        $campos_guardas = get_fields();
                        $data_de_inicio_guarda = str_replace('/', '-', $campos_guardas['data_de_inicio']);
                        $data_de_termino_guarda = str_replace('/', '-', $campos_guardas['data_de_terminio']);
             
                        if(strtotime($data_de_inicio_guarda) <= $hoje && strtotime($data_de_termino_guarda) >= $hoje){
                
                            if($campos_guardas['projeto']->ID == $projeto_id) {
                 
                                if($campos_guardas['papel'] == "guardiao_visao"){ 
                                    $visao = $campos_guardas['oni'];
                
                                }
                                if($campos_guardas['papel'] == "guardiao_time"){ 
                                    $time = $campos_guardas['oni'];
                                }
                                if($campos_guardas['papel'] == "guardiao_metodo"){ 
                                    $metodo = $campos_guardas['oni'];
                                }
                            }
                        }
                    
                    endwhile;endif;
                            
                    ?>
                    <div class="col text-center">
                        <?php
                        if($visao){
                            ?>
                            <img class="image_profile_small"  src="<?php echo get_avatar_url($visao['ID']);?>">
                            <p class="escala-1 petro bold"><?php echo $visao['display_name'];?></p>
                        <?php
                        }
                        ?>
        
                    </div>
                    <div class="col text-center">
                        <?php
                        if($time){
                        ?>
                            <img class="image_profile_small"  src="<?php echo get_avatar_url($time['ID']);?>">
                            <p class="escala-1 petro bold"><?php echo $time['display_name'];?></p>
                        <?php
                        }
                        ?>

                    </div>
                    <div class="col text-center">
                    <?php
                        if($metodo){
                        ?>
                            <img class="image_profile_small"  src="<?php echo get_avatar_url($metodo['ID']);?>">
                            <p class="escala-1 petro bold"><?php echo $metodo['display_name'];?></p>
                        <?php
                        }
                        ?>

                    </div>
                           
    
                </div>
                <hr class="mt-1 mb-4">
                <?php
            endwhile;endif;
            ?>
        </div>
        <?php 
        include(get_stylesheet_directory() . '/template-parts/card-gerador-feedback.php');
        ?>
    </div>
    <div class="col-12 col-lg-3 ">
        <div class="atomic_card   background_white ">
            <?php 
            if($guardas->have_posts()):while($guardas->have_posts()): $guardas->the_post();
                $campos_guardas = get_fields();
                $data_de_inicio_guarda = str_replace('/', '-', $campos_guardas['data_de_inicio']);
                $data_de_termino_guarda = str_replace('/', '-', $campos_guardas['data_de_terminio']);

                if(strtotime($data_de_inicio_guarda) <= $hoje && strtotime($data_de_termino_guarda) >= $hoje){
                    
                    if($campos_guardas['papel'] == "guardiao_visao"){ 
                        $guardas_por_oni[$campos_guardas['oni']['ID']]['guardiao_visao']++;

                    }
                    if($campos_guardas['papel'] == "guardiao_time"){ 
                        $guardas_por_oni[$campos_guardas['oni']['ID']]['guardiao_time']++;
                    }
                    if($campos_guardas['papel'] == "guardiao_metodo"){ 
                        $guardas_por_oni[$campos_guardas['oni']['ID']]['guardiao_metodo']++;
                    }
                  
                }
            endwhile;endif;

           
            $onis = get_users();
            foreach($onis as $oni){

                if(!in_array("um_socio", $oni->roles )){              
                ?>
                    <div class='row'>
                        <div class="col-12 col-md-6">
                            <img class="image_profile_small "  src="<?php echo get_avatar_url($oni->ID);?>">
                            <p class="escala-1 petro bold my-0"><?php echo $oni->display_name;?></p>
                            <p class="escala-1 onipink bold"><?php echo $guardas_por_oni[$oni->ID]['guardiao_visao']+$guardas_por_oni[$oni->ID]['guardiao_time']+$guardas_por_oni[$oni->ID]['guardiao_metodo']." guardas";?></p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p class="escala-1 grey my-0 py-1"><?php echo $guardas_por_oni[$oni->ID]['guardiao_visao']+0;?> guardas de visão</p>
                            <p class="escala-1 grey my-0 py-1"><?php echo $guardas_por_oni[$oni->ID]['guardiao_time']+0;?> guardas de time</p>
                            <p class="escala-1 grey my-0 py-1"><?php echo $guardas_por_oni[$oni->ID]['guardiao_metodo']+0;?> guardas de método</p>
                        </div>
                    </div>
                    <hr>
                <?php
                }
            }
            ?>
        </div>
    </div>
   
</div>
<?php get_footer();?>