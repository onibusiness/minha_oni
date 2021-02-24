<?php
    global $template;
    $user_id = $user_atual->ID;
    $user_name = $user_atual->user_nicename;
    $user_email = $user_atual->user_email;
    
    if(basename($template) == "page-user.php"){
     
        $user_id =  um_profile_id();
        $user_name = um_user('display_name');
        $user_email = um_user('user_email');
        $informacoes = get_field( 'informacoes_gerais', 'user_'.$user_id);
        
    }
?>
<div class="atomic_card pt-4 pb-3">
    <div class="d-flex">
        <div class="col-2 col-md-2 align-self-center p-0">
            <img class="image_profile" src="<?php echo get_avatar_url($user_id);?>">
        </div>
        <div class="col-7 col-md-7 p-0 align-self-center pl-4">
            <p class="escala1 font-weight-bold mb-0"><?php echo $user_name;?></p>
            <p class="escala-1 mb-0"><?php echo $user_email;?></p>
            
        </div>
        <div class="ml-auto col-3 col-md-3 align-self-center ">
            <button type="button" class="btn btn-outline-dark " data-toggle="collapse" data-target="<?php echo '#perfil'.$user_id;?>" aria-expanded="false" aria-controls="<?php echo "perfil".$user_id;?>">
                Editar
            </button>
        </div>
    </div>
    <div class="mt-4">
        <p class="escala-1 mb-1"><?php echo $informacoes['celular'];?></p>
        <p class="escala-1 mb-1">Aniversário : <?php echo $informacoes['data_de_nascimento'];?></p>
        <p class="escala-1 mb-1">Oniversário : <?php echo $informacoes['oniversario'];?></p>
       
    
    </div>
    <div class="row">
        <div class="col">
            <div class="collapse" id="<?php echo "perfil".$user_id;?>">
            
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