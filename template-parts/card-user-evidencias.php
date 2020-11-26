<div style='border: solid 1px black;'>
    <p>Evidências: </p>
    <a href="<?php echo get_site_url()."/evidencias/";?>">Cadastrar evidencias</a>
    <?php 
    $evidencias = new processa_evidencias;
    $evidencias_do_oni = $evidencias->evidencias_filtradas;
    while ( $evidencias_do_oni->have_posts() ) : $evidencias_do_oni->the_post(); 
    $campos = get_fields();
    ?>
      <p><?php echo $campos['data']." |  ".$campos['competencia']->post_title." - ".$campos['parecer'];?></p>
    <?php
    endwhile;
    ?>
</div>