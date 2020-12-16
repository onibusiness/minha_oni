
<?php 
$competencias_do_oni = $historico_pagamentos[$mes['classe']]['competencias'];
$competencias = new processa_competencias;
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
