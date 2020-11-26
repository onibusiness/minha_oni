<div style='border: solid 1px black;'>
    <img width='50' src="<?php echo get_avatar_url($user_atual->ID);?>">
    <p><?php echo $user_atual->user_nicename;?></p>
    <p><?php echo $user_atual->user_email;?></p>
    <p><?php echo get_field( 'celular', 'user_'.$user_atual->ID);?></p>
    <p>Aniversário : <?php echo get_field( 'data_de_nascimento', 'user_'.$user_atual->ID);?></p>
    <p>Oniversário : <?php echo get_field( 'oniversario', 'user_'.$user_atual->ID);?></p>
    <p>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="<?php echo '#'.$user_atual->user_nicename;?>" aria-expanded="false" aria-controls="<?php echo $user_atual->user_nicename;?>">Editar</button>
    </p>
    
    <div class="row">
        <div class="col">
            <div class="collapse" id="<?php echo $user_atual->user_nicename;?>">
                <div class="card card-body">
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
</div>