<?php get_header();?>
<?php 
    $competencias = new processa_competencias;
?> 
<div class="row">
    <?php
    $lentes_do_oni = $historico_pagamentos[$mes['classe']]['lentes'];
  

    foreach($competencias->lentes as $prisma => $lente){
        ?>
        <div class="col-12 col-md-6 px-0 px-md-3"  >
            <div class="col-12" >
                <p class="escala0 bold petro under_lightgrey mt-3"><?php echo $prisma; ?></p>
            </div>
            <?php
            
            while ( $lente->have_posts() ) : $lente->the_post(); 
                if(is_array($lentes_do_oni)){

                    if(in_array( get_the_title(), array_column($lentes_do_oni, 'lente'))){
                    ?>
                        <p class=" col-12 escala-1 petro publish"><?php echo get_the_title(); ?></p>
                    <?php
                    }
                }else{
                    ?>
                        <p class=" col-12 escala-1 grey"><?php echo get_the_title(); ?></p>
                    <?php
                   
                }
            endwhile;
            ?>
        </div>
    <?php
        
    }
    if($competencias->lentes_por_oni[$user_name]){
        foreach($competencias->lentes_por_oni[$user_name] as $lentes_do_oni => $bol){
            ?>
            <p class="escala-1"><?php echo $lentes_do_oni; ?></p>
            <?php
        }
    }
    ?>
</div>


<?php 
$competencias_do_oni = $historico_pagamentos[$mes['classe']]['competencias'];

foreach($competencias->competencias_no_sistema as $esfera => $competencias_no_sistema){
    ?>
    <!-- Escrevendo a esfera  -->
    <div class="col-12 px-0 px-md-3" style="break-inside: avoid;" >
        <p class="escala0 bold onipink under_lightgrey mt-3"><?php echo $esfera; ?></p>
   
        <div class="d-flex ">
            <?php

            //Fazendo o loop nas competencias do sistema e apontando para a competencia do oni para pegar o nível
            if(!empty($competencias_no_sistema)){
                foreach($competencias_no_sistema as $competencia => $niveis){
                    $onion_up = false;
                    if($competencias_do_oni){

                        foreach($competencias_do_oni as $competencia_do_oni){
                        
                            if ($competencia_do_oni->competencia == $competencia) {
                                
                                $nivel_do_oni = $competencia_do_oni->pontos;
                                $onion_up = true;
                                break;
                            }else{
                                $nivel_do_oni = 0;
                            }
                        }
                    }else{
                        $nivel_do_oni = 0;
                    }

                    ?>
                    </div>
                     <div class="d-flex ">
    
                    <!-- Escrevendo a competencia  -->
                    <div class="col-6 col-md-8 pl-0">
                        <p class="escala-1"><?php echo $competencia; ?></p>
                    </div>
                    <div class="col-md-5 d-flex justify-content-around align-self-center">
                        <?php
                        for ($i=0; $i < 5; $i++) { 
                            if($nivel_do_oni > $i){
                                if($nivel_do_oni == $i+1 && $onion_up == true){
                                    ?>
                                    <p class="competency_sphere background_onionup"></p>
                                    <?php
                                }else{
                                ?>
                                <p class="competency_sphere background_green"></p>
                                <?php
                                }
                            }else{
                
                                ?>
                                <p class="competency_sphere background_grey"></p>
                                <?php
                                
                            }
                        }  
                        ?>
                        <!-- Escrevendo o nível  -->
                    </div>
                    <?php     
                }   
            }
            ?>
        </div>
        
    </div>
    <?php
}

?>



<?php get_footer();?>