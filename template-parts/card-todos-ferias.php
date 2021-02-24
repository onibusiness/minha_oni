<div class="atomic_card background_white ">
      
    <?php 
    $ferias_da_oni = ferias::feriasDaOni($hoje);
    ?>

    <div class="row">
        <div class="col-12 col-md-4">
            <p class="escala1 onipink bold">Onis de férias</p>
            <?php
            if(is_array($ferias_da_oni['atuais'])){
                ?>          
                <?php
                foreach($ferias_da_oni['atuais'] as $oni_de_ferias){
                ?>
                    <div class="col-md-12 d-flex ">
                        <div class="col-3 col-md-4 align-self-center">
                            <img class="image_profile" src="<?php echo get_avatar_url($oni_de_ferias["ID_oni"]);?>">
                        </div>
                        <div class="col-9 col-md-8 pl-1 pt-2" >
                            <p class="escala0 bold mb-0"><?php echo $oni_de_ferias['nome_oni'];?></p>
                            <p class="escala-1 mb-0"><?php echo $oni_de_ferias['dias_de_ferias']." dias úteis";?></p>
                            <p class="escala-1 mb-0"><?php echo "De ".$oni_de_ferias['data_de_inicio_ferias']." a ".$oni_de_ferias['data_de_termino_ferias'];?></p>
                        </div>
                    </div>   
                <?php
                }
                ?>
            
            <?php
            }
            ?>
        </div>
        <div class="col-12 col-md-8">
            <p class="escala1 onipink bold">Próximos onis de férias</p>
            <div class="row">
                <?php
                if(is_array($ferias_da_oni['proximas'])){
                    $i = 0;
                    foreach($ferias_da_oni['proximas'] as $proximas_ferias){
                        if($i<3){
                        ?>
                        <div class="col-md-4 d-flex ">
                            <div class="col-3 align-self-center">
                                <img class="image_profile_small" src="<?php echo get_avatar_url($proximas_ferias["ID_oni"]);?>">
                            </div>
                            <div class="col-9  pl-1" >
                                <p class="escala0 grey bold mb-0"><?php echo $proximas_ferias['nome_oni'];?></p>
                                <p class="escala-1 grey mb-0"><?php echo $proximas_ferias['dias_de_ferias']." dias úteis";?></p>
                                <p class="escala-1 grey mb-0"><?php echo "De ".$proximas_ferias['data_de_inicio_ferias']." a ".$proximas_ferias['data_de_termino_ferias'];?></p>

                            </div>
                        </div>  
                        <?php
                        }        
                    $i++;
                    }
                }
                ?>
                </div>
            </div>
        </div>
 
</div>

