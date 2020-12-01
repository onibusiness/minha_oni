<div class="atomic_card background_white">
  <div class="col-md-12 pl-0 d-flex justify-content-between">
    <p class="escala2 align-self-center">Próximas ferias: </p>
    <div >
      <button type="button" class="btn btn-outline-dark">
        <a href="<?php echo get_site_url()."/ferias/";?>">Pedir ferias</a>
      </button>
    </div>
  </div>
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
