<div style='border: solid 1px black;'>
    <p>Próximas ferias: </p>
    <a href="<?php echo get_site_url()."/ferias/";?>">Pedir ferias</a>
    <?php 
    $ferias = ferias::filtraFerias($current_user);
    while ( $ferias->have_posts() ) : $ferias->the_post(); 
    $campos = get_fields();
    $data_de_inicio_ferias = str_replace('/', '-', $campos['primeiro_dia_fora']);
    $data_de_termino_ferias = str_replace('/', '-', $campos['ultimo_dia_fora']);
    $dias_de_ferias = minha_oni::contaDiasUteis(strtotime($data_de_inicio_ferias), strtotime($data_de_termino_ferias));
    if(strtotime($data_de_inicio_ferias) >= $hoje){
    ?>
      <p><?php echo $dias_de_ferias." dias úteis | de ".$campos['primeiro_dia_fora']." a ".$campos['ultimo_dia_fora'];?></p>
    <?php
    } 
    endwhile;
    ?>
</div>