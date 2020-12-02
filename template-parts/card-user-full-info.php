<div class="atomic_card background_white pt-4 pb-3">
    <div class="d-flex">
        <div class="col-2 col-md-2 align-self-center p-0">
            <img class="image_profile" src="<?php echo get_avatar_url($user_atual->ID);?>">
        </div>
        <div class="col-7 col-md-7 p-0 align-self-center pl-4">
            <p class="escala1 font-weight-bold mb-0"><?php echo $user_atual->user_nicename;?></p>
            <p class="escala0 mb-0"><?php echo $user_atual->user_email;?></p>
        </div>
        <div class="ml-auto col-3 col-md-3 align-self-center ">
            <button type="button" class="btn btn-outline-dark " data-toggle="collapse" data-target="<?php echo '#'.$user_atual->user_nicename;?>" aria-expanded="false" aria-controls="<?php echo $user_atual->user_nicename;?>">
                Editar
            </button>
        </div>
    </div>
    <div class="mt-4">
        <p><?php echo get_field( 'celular', 'user_'.$user_atual->ID);?></p>
        <p>Aniversário : <?php echo get_field( 'data_de_nascimento', 'user_'.$user_atual->ID);?></p>
        <p>Oniversário : <?php echo get_field( 'oniversario', 'user_'.$user_atual->ID);?></p>
       
    
    </div>
    <div class="row">
        <div class="col">
            <div class="collapse" id="<?php echo $user_atual->user_nicename;?>">
            
                    <?php 
                    $options = array(
                        'field_groups' => ['group_5f3fe0d54faef'],
                        'post_id' => "user_{$profile_id}",
                        'form' => true,
                    );
                    
                    acf_form($options);
                    ?>
              
            </div>
        </div>
    </div>
    
</div>