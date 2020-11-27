<div style='border: solid 1px black;'>
    <p>Competencias da Oni </p>
    <?php 
    $competencias = new processa_competencias;
    foreach($competencias->competencias_no_sistema as $esfera => $competencias_no_sistema){
        ?>
        <!-- Escrevendo a esfera  -->
        <p><strong><?php echo $esfera; ?></strong></p>
        <?php
        foreach($competencias_no_sistema as $competencia => $niveis){
        ?>
            <!-- Escrevendo a competencia  -->
            <p><?php echo $competencia; ?></p>
            <?php
            for ($i=1; $i < 6 ; $i++) { 
            ?>
                <!-- Escrevendo o nível  -->
                <p><?php echo $i; ?></p>
                <?php
                if(is_array($niveis[$i])){
                    foreach($niveis[$i] as $oni_do_nivel){
                        $oni_obj = get_user_by('slug', $oni_do_nivel);
                        //Escrevendo o avatar e nome de cada oni daquele nível
                        ?>
                        <img width='50' src="<?php echo get_avatar_url($oni_obj->ID);?>">
                        <p><?php echo $oni_do_nivel; ?></p>
                    <?php
                    }
                }
            }
        }
    }
    ?>
</div>