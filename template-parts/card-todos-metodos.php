<div class="atomic_card background_white py-4"> 
    <p class="escala1 bold onipink"> Guardiões de método </p>
    <div class="duas-colunas">
        <?php 
        $metodos = processa_metodos::pegaMetodos();

        foreach($metodos->posts as $metodo){
            $fields = get_fields($metodo->ID);

            ?>
            <!-- Escrevendo o método  -->
            <div class="col-12 pl-0"  style="break-inside: avoid;">
                <div class="d-flex under_lightgrey mt-3 pb-3">
                   <!-- Escrevendo os gestores  -->
                    <div class='col-3'>
                        <?php
                        if($fields['guardioes']){
                            foreach($fields['guardioes'] as $guardiao){
                     
                                if($guardiao['com_rodinha'] == true){
                                    ?>  
                                    <div class='col-12 text-center center-block'>
                                        <img class=" image_profile_small" alt="<?php echo $i;?>" src="<?php echo get_avatar_url($guardiao['oni']['ID']);?>">
                                        <p class="escala-2 font-weight-bold mb-0 grey "><?php echo $guardiao['oni']['display_name']; ?></p>
                                        <p class='treinamento'>Treinando</p>
                                    </div>
                                        
                                    <?php

                                }else{
                                    ?>  
                                    <div class='col-12 text-center center-block'>
                                        <img class=" image_profile_small" alt="<?php echo $i;?>" src="<?php echo get_avatar_url($guardiao['oni']['ID']);?>">
                                        <p class="escala-2 font-weight-bold onipetro "><?php echo $guardiao['oni']['display_name']; ?></p>
                                    </div>
                                        
                                    <?php
                                }
                    
                            }
                        }else{
                            ?>  
                            <div class='col-12 text-center center-block'>
                                <p class="escala-2 font-weight-bold onipink ">Sem guardião</p>
                            </div>
                                
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-9  pl-0">
                        <p class="escala0 mb-1 font-weight-bold onipetro "><?php echo $fields['metodo']; ?></p>
                        <p class="escala-1 mb-1 grey "><?php echo $fields['descricao']; ?></p>
                        <?php
                        foreach($fields['requisitos'] as $requisito){
                        ?>  
                       
                        <p class="escala-2 mb-1 grey "><?php echo $requisito['competencia']->post_title." ".$requisito['nivel']."+"; ?></p>
                            
                            
                        <?php
                        }
                        ?>
                    </div>
                </div>

              
               
            </div>

           
            
        
        <?php
        }
        ?>
    </div>
</div>