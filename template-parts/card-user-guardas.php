<div class="atomic_card  py-2">
    <p class="escala1 bold onipink mb-2">Guardião de </p>
    <?php 
        $papeis = papeis::filtraPapeis($profile_id);
        
          while ( $papeis->have_posts() ) : $papeis->the_post(); 

            $campos = get_fields();
            $data_de_inicio_guarda = str_replace('/', '-', $campos['data_de_inicio']);
            $data_de_termino_guarda = str_replace('/', '-', $campos['data_de_terminio']);
            $titulo_guardas = get_field_object('papel');

            if(strtotime($data_de_inicio_guarda) <= $hoje && strtotime($data_de_termino_guarda) >= $hoje){
   
              ?>
                <div class="display-flex justify-content-between ">
                  <p class="pl-0 escala-1 mb-0 bold"><?php echo $titulo_guardas['choices'][$campos['papel']]." de ".$campos['projeto']->post_title?> </p>
                  <p class="lightgrey mb-1 escala-1"><?php echo "de ".$campos['data_de_inicio']." a ".$campos['data_de_terminio'];?></p>
                </div>
              <?php
            }
          endwhile;
      ?>
</div>