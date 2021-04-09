<div class="atomic_card background_white">
  <div class="col-md-12 pl-0 d-flex justify-content-between">
    <p class="escala1 bold">Últimas evidências: </p>
    <div>
      <div class="buttoni pequeno">
        <a href="<?php echo get_site_url()."/evidencias/";?>">Cadastrar evidências</a>
      </div>
    </div>
  </div>
  
  <div class="col-md-12 pl-0">
    <table class="table mt-4">
      <thead>
          <tr class='escala-1 row'>
              <th class="col-md-3" scope="col">Parecer</th>
              <th class="col-md-3" scope="col">Data</th>
              <th class="col-md-6" scope="col">Competência</th>
          </tr>
      </thead>
      <tbody>
        <?php 
        $evidencias = new processa_evidencias;
        $evidencias_do_oni = $evidencias->evidencias_filtradas;
        $i=1;
        while ( $evidencias_do_oni->have_posts()) : $evidencias_do_oni->the_post(); 
          $status = get_post_status();
          $campos = get_fields();
          ?>
          
          <tr class='escala-1 row'>
            <td class="col-md-3"><p class='<?php echo $campos['parecer'];?> m-0'></p></td>
            <td class="col-md-3"><?php echo $campos['data'];?></td>
            <td class="col-md-6"><?php echo $campos['competencia']->post_title;?></td>
          </tr>
          <?php
          if($i ==  3){
            break 1;
          }
          $i++;
        endwhile;
        ?>
      </tbody>
    </table>
    <?php
    if($i ==  3){
      ?>
      <p class='text-center '>
        <a class='bold' href="<?php echo get_site_url()."/evidencias/";?>">Ver todas as evidências</a>
      </p>
  
      <?php
    }

    ?>
  </div>
</div>

