<div class="atomic_card background_white">
    <p class="escala1 bold onipink"> Competências da Oni </p>
    <div class="duas-colunas">
    <?php 
    $competencias = new processa_competencias;
    foreach($competencias->competencias_no_sistema as $esfera => $competencias_no_sistema){
        ?>
        <!-- Escrevendo a esfera  -->
        <div class="col-12 pl-0"  style="break-inside: avoid;">
            <div class="d-flex under_lightgrey mt-3">
                <div class="col-6  pl-0">
                    <p class="escala0 font-weight-bold onipetro "><?php echo $esfera; ?></p>
                </div>
                <div class="col-6 d-flex justify-content-around align-self-end">
                     <?php
                        for ($i=1; $i < 6 ; $i++) { 
                        ?>  <div class='col text-center'>
                            <!-- Escrevendo o nível  -->
                                <p class="escala-1 lightgrey"><?php echo $i; ?></p>
                            </div>
                            <?php
                        }
                    ?>
                  
                </div>  
            </div>
            
            <?php
            foreach($competencias_no_sistema as $competencia => $niveis){

            ?>
                <!-- Escrevendo a competencia  -->
                <div class="d-flex py-1" style="border-bottom: 1px solid #eeeeee;">
                    <div class="col-6 pl-0">
                        <p class="escala-1 "><?php echo $competencia; ?></p>
                    </div>
                    <div class="col-6 d-flex justify-content-around align-self-center">
                        <?php
                        for ($i=1; $i < 6 ; $i++) { 
                        ?>
                            <div class='col px-0 text-center'>
                           
                            <?php
                            if(is_array($niveis[$i])){
                                $oni_obj = null;
                                foreach($niveis[$i] as $oni_do_nivel){
                                    $oni_obj = get_user_by('slug', $oni_do_nivel);
                                   
                                    //Escrevendo o avatar e nome de cada oni daquele nível
                                    ?>
                                    <img class="image_profile_small" alt="<?php echo $i;?>" src="<?php echo get_avatar_url($oni_obj->ID);?>">
                                    
                                <?php
                                }
                                if(!$oni_obj){
                                ?>
                                    <p class='lightgrey'>•</p>
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
            <?php
            }
        ?>
        </div>
    <?php
    }
    ?>
</div>
