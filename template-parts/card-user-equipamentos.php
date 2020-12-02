<div class="atomic_card background_white py-4">
    <p class="escala1 bold  onipink" >Equipamentos oni com você </p>
    
    <div class="row petro px-3">
        <?php 
        $equipamentos = equipamentos::filtraEquipamentos($current_user);
        while ( $equipamentos->have_posts() ) : $equipamentos->the_post(); 
        ?>
            <p class="pl-0 col-md-6 escala0"><?php echo get_the_title();?></p>
        <?php
        endwhile;
        ?>
    </div>
</div>