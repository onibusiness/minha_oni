
<div class="row">
    <?php
    $lentes_do_oni = $historico_pagamentos[$mes['classe']]['lentes'];
    $competencias = new processa_competencias;

    foreach($competencias->lentes as $prisma => $lente){
        ?>
        <div class="col-6"  >
            <div class="col-12" >
                <p class="escala0 bold petro under_lightgrey mt-3"><?php echo $prisma; ?></p>
            </div>
            <?php
            
            while ( $lente->have_posts() ) : $lente->the_post(); 
                if(is_array($lentes_do_oni)){

                    if(in_array( get_the_title(), array_column($lentes_do_oni, 'lente'))){
                    ?>
                        <p class=" col-12 escala-1 petro publish"><?php echo get_the_title(); ?></p>
                    <?php
                    }
                }else{
                    ?>
                        <p class=" col-12 escala-1 grey"><?php echo get_the_title(); ?></p>
                    <?php
                   
                }
            endwhile;
            ?>
        </div>
    <?php
        
    }
    if($competencias->lentes_por_oni[$user_name]){
        foreach($competencias->lentes_por_oni[$user_name] as $lentes_do_oni => $bol){
            ?>
            <p class="escala-1"><?php echo $lentes_do_oni; ?></p>
            <?php
        }
    }
    ?>
</div>
