<div class="atomic_card background_white py-4">
    <?php 
    $users_wordpress = get_users();
    foreach($users_wordpress as $user){
        $classe = "";
        if($user->ID == $_GET['oni']){
            $classe = "ativo";
        }
        if($evidencias->evidencias_por_gestor[get_current_user_id()]){

            $evidencias_avaliar = array_count_values(array_column($evidencias->evidencias_por_gestor[get_current_user_id()], 'oni'));
        }

    ?>  
        <div class="col-12 align-self-center my-2"  > 
            <a  class="d-flex flex-row " href="?oni=<?php echo $user->ID; ?>"> 
                <div class="col-2  align-self-center p-0">
                    <img class="image_profile_small" src="<?php echo get_avatar_url($user->ID);?>">
                </div>
                <div class="col-10 p-0 align-self-center pl-4">
                    <p class="escala0 mb-0 <?php echo $classe;?>"><?php echo $user->user_nicename;?>
                        <?php 
                        if(current_user_can('edit_users') && $evidencias->onis_status_evidencias[$user->user_nicename]['sem_parecer'] ){
                        ?>
                            <span  class='alerta'><?php echo $evidencias->onis_status_evidencias[$user->user_nicename]['gestor_avaliar']?></span>
                            <span  class='notifica'><?php echo $evidencias->onis_status_evidencias[$user->user_nicename]['sem_parecer']?></span>
                        <?php
                        }elseif($evidencias_avaliar[$user->ID]){
                        ?>
                            <span class='alerta'><?php echo $evidencias_avaliar[$user->ID]?></span>
                        <?php
                        }
                        ?>
                    </p>
                </div>
            </a>
        </div>
    <?php
    }
    ?>
</div>