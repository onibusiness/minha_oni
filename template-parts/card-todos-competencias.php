<div class="atomic_card background_white">
    <p class="escala1 bold onipink"> Competências da Oni </p>
    <div class="d-flex flex-wrap">
    <?php 
    $competencias = new processa_competencias;
    foreach($competencias->competencias_no_sistema as $esfera => $competencias_no_sistema){
        ?>
        <!-- Escrevendo a esfera  -->
        <div class="col-md-6 pl-0">
            <p class="escala0 font-weight-bold onipetro under_lightgrey mt-3"><?php echo $esfera; ?></p>
            <?php
            foreach($competencias_no_sistema as $competencia => $niveis){
            ?>
                <!-- Escrevendo a competencia  -->
                <div class="d-flex">
                    <div class="col-6 col-md-8 pl-0">
                        <p class="escala-1 "><?php echo $competencia; ?></p>
                    </div>
                    <div class="col-md-4 d-flex justify-content-around align-self-center">
                        <?php
                        for ($i=1; $i < 6 ; $i++) { 
                        ?>
                            <!-- Escrevendo o nível  -->
                            <p><?php echo $i; ?></p>
                            <?php
                            if(is_array($niveis[$i])){
                                foreach($niveis[$i] as $oni_do_nivel){
                                    $oni_obj = get_user_by('slug', $oni_do_nivel);
                                    //Escrevendo o avatar e nome de cada oni daquele nível
                                    ?>
                                    <img width='50'alt="<?php echo $i;?>" src="<?php echo get_avatar_url($oni_obj->ID);?>">
                                    <p><?php echo $oni_do_nivel; ?></p>
                                <?php
                                }
                            }
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
