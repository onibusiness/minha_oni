<div class="atomic_card background_white">
  <div class="col-md-12 pl-0 d-flex justify-content-between">
    <p class="escala1 bold align-self-center">Próximas ferias: </p>
    <div >
    <button type="button" class="btn btn-outline-dark " data-toggle="collapse" data-target="<?php echo '#ferias'.$user_id;?>" aria-expanded="false" aria-controls="<?php echo "ferias".$user_id;?>">
                Pedir férias
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
      $status = get_post_status();
      if(strtotime($data_de_inicio_ferias) >= $hoje){
      ?>
        <p class='mt-3 <?php echo $status;?>'><?php echo $dias_de_ferias." dias úteis | de ".$campos['primeiro_dia_fora']." a ".$campos['ultimo_dia_fora'];?></p>
      <?php
      } 
    endwhile;
    ?>
    <div class="row">
        <div class="col">
            <div class="collapse" id="<?php echo "ferias".$user_id;?>">
            
              <?php 
              acf_form(array(
                'post_id'       => 'new_post',
                'new_post'      => array(
                    'post_type'     => 'ferias' ,
                    'post_status'   => 'pending'
                ),
                'submit_value'  => 'Salvar'
              ));
              ?>
              
            </div>
        </div>
    </div>
</div>
