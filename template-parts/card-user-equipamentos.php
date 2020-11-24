<div style='border: solid 1px black;'>
    <p>Equipamentos oni com você: </p>
    <?php 
    $equipamentos = equipamentos::filtraEquipamentos($current_user);
    while ( $equipamentos->have_posts() ) : $equipamentos->the_post(); 
    ?>
        <p><?php echo get_the_title();?></p>
    <?php
    endwhile;
    ?>
</div>