<div class="atomic_card background_white">
  <div class="col-md-12 pl-0 d-flex justify-content-between">
    <p class="escala1 bold">Evidências: </p>
    <div>
      <button type="button" class="btn btn-outline-dark">
        <a href="<?php echo get_site_url()."/evidencias/";?>">Cadastrar evidências</a>
      </button>
    </div>
  </div>
  
  <div class="col-md-12 pl-0">
    <table class="table mt-4">
      <thead>
          <tr class='escala-1'>
              <th scope="col">Data</th>
              <th scope="col">Título</th>
              <th scope="col">Parecer</th>
          </tr>
      </thead>
      <tbody>
        <?php 
        $evidencias = new processa_evidencias;
        $evidencias_do_oni = $evidencias->evidencias_filtradas;
        while ( $evidencias_do_oni->have_posts() ) : $evidencias_do_oni->the_post(); 
          $campos = get_fields();
          ?>
          
          <tr class='escala-1'>
            <td><?php echo $campos['data'];?></td>
            <td><?php echo $campos['competencia']->post_title;?></td>
            <td><?php echo $campos['parecer'];?></td>
          </tr>
        <?php
        endwhile;
        ?>
      </tbody>
    </table>
  </div>
</div>

