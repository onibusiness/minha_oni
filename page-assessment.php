<?php get_header(); 
if(current_user_can('edit_users')){
    $admin = true;
}
if($_GET['oni']){
    wp_set_current_user($_GET['oni']);
}

$logado = wp_get_current_user();

$oni_nicename = $logado->user_nicename;
$profile_id = $logado->ID;
$onions_guarda = 0;
$onions_competencias = 0;
$equivalencia_pontos_onions = array(0 => 0, 1 => 1, 2 => 2, 3 => 4, 4 => 6, 5 => 8); //tabela de equivalência de pontos pra onions

?>
<div class="row">
    <div class="col-12 col-md-4 ">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/card-user-info.php');
        ?>
        <div class="atomic_card background_white py-4">
            <p class="escala1 bold onipink">Guardião de </p>
            <?php 
                $papeis = processa_papeis::filtraPapeis($profile_id);
                
                while ( $papeis->have_posts() ) : $papeis->the_post(); 

                    $campos = get_fields();
                    $data_de_inicio_guarda = str_replace('/', '-', $campos['data_de_inicio']);
                    $data_de_termino_guarda = str_replace('/', '-', $campos['data_de_terminio']);
                    $titulo_guardas = get_field_object('papel');
                    

                    if(strtotime($data_de_inicio_guarda) <= $hoje && strtotime($data_de_termino_guarda) >= $hoje){
                        $onions_guarda += 3;
        
                    ?>
                        <div class="display-flex justify-content-between ">
                        <p class="pl-0 escala0 mb-1"><?php echo $titulo_guardas['choices'][$campos['papel']]." de ".$campos['projeto']->post_title?> </p>
                        <p class="lightgrey"><?php echo "de ".$campos['data_de_inicio']." a ".$campos['data_de_terminio'];?></p>
                        </div>
                    <?php
                    }
                endwhile;
            ?>
        </div>
        <?php
        if($admin){
        ?>
            <div class="atomic_card background_white py-4">
                <?php 
                $users_wordpress = get_users();
                foreach($users_wordpress as $user){
                    $classe = "";
                    if($user->ID == $_GET['oni']){
                        $classe = "ativo";
                    }
                    

                    ?>  
                    <div class="col-12 align-self-center my-2"  > 
                        <a  class="d-flex flex-row " href="?oni=<?php echo $user->ID; ?>"> 
                            <div class="col-2  align-self-center p-0">
                                <img class="image_profile_small" src="<?php echo get_avatar_url($user->ID);?>">
                            </div>
                            <div class="col-10 p-0 align-self-center pl-4">
                                <p class="escala0 mb-0 <?php echo $classe;?>"><?php echo $user->user_nicename;?>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col-12 col-md-8">
        <div class="row">
        
            <div class="col-12  atomic_card background_white py-4 order-2"> 
                <div  class=" duas-colunas" style="column-gap: 2em;">
                    <?php 

                    $competencias = new processa_competencias;

        
                    foreach($competencias->competencias_no_sistema as $esfera => $competencias_no_sistema){
        
                        ?>
                        <!-- Escrevendo a esfera  -->
                        <div class="col-12 " style="break-inside: avoid;"> 
                            <p class="escala0 bold onipink under_lightgrey mt-3"><?php echo $esfera; ?></p>
                        
                                <?php
                
                                //Fazendo o loop nas competencias do sistema e apontando para a competencia do oni para pegar o nível
                                if(!empty($competencias_no_sistema)){
                
                                    foreach($competencias_no_sistema as $competencia => $niveis){
                                    
                                        ?>
                                        <div class="d-flex">
                                        <!-- Escrevendo a competencia  -->
                                        <div class="col-6 col-md-8 pl-0">
                                            <p class="escala-1"><?php echo $competencia; ?></p>
                                        </div>
                                        <div class="col-md-5 d-flex justify-content-around align-self-center">
                                            <?php
                                            $nivel_do_oni = 0;
                                            
                                            foreach($niveis as $nivel => $onis_no_nivel){
                                    
                                                if($competencias->competencias_por_oni[$oni_nicename][$competencia] == $nivel){
                                                    $nivel_do_oni = $nivel;
                                                
                                                }
                                            
                                            }
                                            $onions_competencias += $equivalencia_pontos_onions[$nivel_do_oni];
                                            for ($i=0; $i < 5; $i++) { 
                                                if($nivel_do_oni > $i){
                                                    ?>
                                                    <p class="competency_sphere background_green"></p>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <p class="competency_sphere background_grey"></p>
                                                    <?php
                                                }
                                            }  
                                            ?>
                                            <!-- Escrevendo o nível  -->
                                            </div>
                                        </div>
                                        <?php     
                                    }   
                                }
                                ?>
                            
                        </div>
                        <?php
                    }
                
                    ?>
                </div>
            </div>
    

            <div class="col-12 atomic_card background_white py-4 order-1">
                <div class="row">
                    <div class="col-3 offset-1">
                        <p class="escala3 bold mb-0"> <span class="onipink">Ø</span> <?php echo $onions_guarda+$onions_competencias;?></p>
                        <p class="escala0 bold mb-2 pb-2">Total de onions</p>
                    </div>
                    <div class="col-4">
                        <p class="escala3 bold mb-0"><?php echo $onions_guarda;?></p>
                        <p class="escala0 bold mb-2 pb-2">Onions de guarda</p>
                        </div>
                    <div class="col-4">
                        <p class="escala3 bold mb-0"><?php echo $onions_competencias;?></p>
                        <p class="escala0 bold mb-2 pb-2">Onions de competências</p>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<?php get_footer();?>