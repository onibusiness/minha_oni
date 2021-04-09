<div class="atomic_card  py-2">
    <p class="escala0 bold onipink mb-2">Guardas de método </p>
    
        <?php 
        
        $metodos = metodos::pegaMetodos();
        $competencias_do_oni = $competencias->competencias_por_oni[$profile_obj->data->user_nicename];

        foreach($metodos->posts as $metodo){
            $fields = get_fields($metodo->ID);
            //Verificando se o usuário atual é guardião
            if($fields['guardioes']){

                $e_guardiao = array_filter( $fields['guardioes'], function($v) use($profile_id, $com_rodinha){
                 
                    return $v['oni']['ID'] == $profile_id;
                });
            }else{
                $e_guardiao = false; 
            }
           
            //Se for guardião, printa guarda de método
            if($e_guardiao){

                ?>
                <!-- Escrevendo o método  -->
                <div class="col-12 pl-0"  style="break-inside: avoid;">
                    <div class="d-flex  mt-3 pb-3">
              
                        <div class="col-12  pl-0">
                            <?php
                            if($e_guardiao[0]['com_rodinha'] == true){
                                ?>
                                <p class="escala-1 mb-1 bold grey ">Treinando para <?php echo $fields['metodo']; ?></p>
                                <p class="escala-1 mb-1 grey "><?php echo $fields['descricao']; ?></p>
                                <?php

                            }else{
                                ?>
                                <p class="escala-1 mb-1 bold onipetro "><?php echo $fields['metodo']; ?></p>
                                <p class="escala-1 mb-1 grey "><?php echo $fields['descricao']; ?></p>
                                <?php
                            }
                            
                            foreach($fields['requisitos'] as $requisito){
                                //confere o nível atual do oni em relação ao requisito
                                if($competencias_do_oni[$requisito['competencia']->post_title] >= $requisito['nivel']){
                                    ?>  
                    
                                    <p class="escala-1 mb-1 publish "><?php echo $requisito['competencia']->post_title." ".$requisito['nivel']."+"; ?></p>
                                        
                                        
                                    <?php
                                }else{
                                    ?>  
                    
                                    <p class="escala-1 mb-1 pending "><?php echo $requisito['competencia']->post_title." ".$requisito['nivel']."+"; ?></p>
                                    <p class="escala-2 mb-1 grey ">Nível atual <?php echo $competencias_do_oni[$requisito['competencia']->post_title]; ?></p>
                                        
                                    <?php
                                }
                        
                            ?>  
             
                                
                                
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                
                
                </div>

           
            
        
        <?php
            }
        }
        ?>
</div>