<div class="atomic_card background_white ">
    <p class="escala1 bold onipink">Férias da equipe </p>
    
    <p class="escala0 font-weight-bold">Onis de férias</p>
    <div class="row">

        <?php 
        $ferias_da_oni = ferias::feriasDaOni($hoje);

        if(is_array($ferias_da_oni['atuais'])){
            foreach($ferias_da_oni['atuais'] as $oni_de_ferias){
            ?>
            <div class="col-md-4 d-flex mt-3">
                <div class="col-3 col-md-4 align-self-center">
                    <img class="image_profile" src="<?php echo get_avatar_url($oni_de_ferias["ID_oni"]);?>">
                </div>
                <div class="col-9 col-md-8 pl-1 pt-2" >
                    <p class="escala0 mb-0"><?php echo $oni_de_ferias['nome_oni']." - ".$oni_de_ferias['dias_de_ferias']." dias úteis";?></p>
                    <p class="escala-1 mb-0"><?php echo "De ".$oni_de_ferias['data_de_inicio_ferias']." a ".$oni_de_ferias['data_de_termino_ferias'];?></p>
                </div>
            </div>   
            <?php
            }
        }
    ?>
    </div> 
    <p class="escala0 font-weight-bold" >Próximas férias</p>
    <div class="row">
        <?php
        if(is_array($ferias_da_oni['proximas'])){
            foreach($ferias_da_oni['proximas'] as $proximas_ferias){
            ?>
                <div class="col-md-4 d-flex mt-3">
                <div class="col-3 col-md-4 align-self-center">
                    <img class="image_profile" src="<?php echo get_avatar_url($proximas_ferias["ID_oni"]);?>">
                </div>
                <div class="col-9 col-md-8 pl-1 pt-2" >
                    <p class="escala0 mb-0"><?php echo $proximas_ferias['nome_oni']." - ".$proximas_ferias['dias_de_ferias']." dias úteis";?></p>
                    <p class="escala-1 mb-0"><?php echo "De ".$proximas_ferias['data_de_inicio_ferias']." a ".$proximas_ferias['data_de_termino_ferias'];?></p>
                </div>
            </div>  
        <?php
            }
        }
        ?>
    </div>
</div>

