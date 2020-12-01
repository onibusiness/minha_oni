<div class="atomic_card background_white py-4 px-5">
    <p class="escala2  onipink" >Equipamentos oni com você </p>
    
    <div class="row petro px-3">
        <?php 
        $equipamentos = equipamentos::filtraEquipamentos($current_user);
        while ( $equipamentos->have_posts() ) : $equipamentos->the_post(); 
        ?>
            <p class="pl-0 col-md-6 escala1"><?php echo get_the_title();?></p>
        <?php
        endwhile;
        ?>
    </div>
</div>