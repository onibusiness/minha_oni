<div style='border: solid 1px black;'>
    <p>Férias da equipe: </p>
    <?php 
    $ferias_da_oni = ferias::feriasDaOni($hoje);
    if(is_array($ferias_da_oni['atuais'])){
        foreach($ferias_da_oni['atuais'] as $oni_de_ferias){
        ?>
        <p>Onis de férias</p>
            <img width='50' src="<?php echo get_avatar_url($oni_de_ferias["ID_oni"]);?>">
            <p><?php echo $oni_de_ferias['nome_oni']." - a ".$oni_de_ferias['dias_de_ferias']." dias úteis | de ".$oni_de_ferias['data_de_inicio_ferias']." a ".$oni_de_ferias['data_de_termino_ferias'];?></p>
        <?php
        }
    }
    if(is_array($ferias_da_oni['proximas'])){
        foreach($ferias_da_oni['proximas'] as $proximas_ferias){
        ?>
        <p>Próximas férias</p>
            <img width='50' src="<?php echo get_avatar_url($proximas_ferias["ID_oni"]);?>">
            <p><?php echo $proximas_ferias['nome_oni']." - a ".$proximas_ferias['dias_de_ferias']." dias úteis | de ".$proximas_ferias['data_de_inicio_ferias']." a ".$proximas_ferias['data_de_termino_ferias'];?></p>
        <?php
        }
    }
    ?>
</div>