<div class="atomic_card background_white py-4">
    <p class="escala1 bold onipink">Guardião de </p>
    <?php 
        $papeis = papeis::filtraPapeis($current_user);
          while ( $papeis->have_posts() ) : $papeis->the_post(); 
            $campos = get_fields();
            $data_de_inicio_guarda = str_replace('/', '-', $campos['data_de_inicio']);
            $data_de_termino_guarda = str_replace('/', '-', $campos['data_de_terminio']);
            $titulo_guardas = get_field_object('papel');
            if(strtotime($data_de_inicio_guarda) <= $hoje && strtotime($data_de_termino_guarda) >= $hoje){
              ?>
                <div class="display-flex justify-content-between lightgrey">
                  <p class="pl-0 escala0"><?php echo $titulo_guardas['choices'][$campos['papel']]." de ".$campos['projeto']?> </p>
                  <p><?php echo "de ".$campos['data_de_inicio']." a ".$campos['data_de_terminio'];?></p>
                </div>
              <?php
            }
          endwhile;
      ?>
</div>