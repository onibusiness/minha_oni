<div class="atomic_card background_white py-4">
    <p class="escala1 bold onipink mb-2">Falta dar feedback para </p>
    <?php 
    $avaliados = array();
    while ( $avaliacoes->avaliacoes_filtradas->have_posts()) : $avaliacoes->avaliacoes_filtradas->the_post(); 
        $oni_avaliado = get_field('oni_avaliado');
        $avaliados[] = $oni_avaliado['user_nicename'];
    endwhile;

    $users_wordpress = get_users();
    foreach($users_wordpress as $user){
        $classe = "";
        if($user->ID == $_GET['oni']){
            $classe = "ativo";
        }
        ?>  
      
       <?php
        if(!in_array($user->user_nicename, $avaliados)){
        ?>
             <div class="col-12 align-self-start my-2"  >         
                <a  class="d-flex flex-row " href="?oni_avaliado=<?php echo $user->ID; ?>"> 
                    <div class="col-2  align-self-center p-0">
                        <img class="image_profile_small" src="<?php echo get_avatar_url($user->ID);?>">
                    </div>
                    <div class="col-10 p-0 align-self-center pl-4">
                        <p class="escala0 mb-0 <?php echo $classe;?>"><?php echo $user->user_nicename;?>
                        
                        </p>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
    <?php
    }
    ?>
</div>