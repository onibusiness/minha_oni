<div class="main">
    <?php 
    $ferias_pendentes = processa_ferias::feriasPendentes();
    $ferias_pendentes = $ferias_pendentes->posts;
    ?>
    <h3><strong>Pedidos de férias pendentes</strong></h3>

    <ul>
        <?php
        foreach($ferias_pendentes as $ferias){
        ?>
            <?php 

            $campos = get_fields($ferias->ID);

            ?>
            <li style='border-top: solid 1px #ececec;'><p><?php echo $campos['oni']->user_nicename;?><span style='    color: #72777c;'> [de <?php echo $campos['primeiro_dia_fora'];?> a <?php echo $campos['ultimo_dia_fora'];?>]</span> </p> <a class="button button-primary" href="<?php echo get_edit_post_link($ferias->ID);?>">Link para aprovar</a></li>
        <?php
        }
        ?>
        
    </ul>
</div>