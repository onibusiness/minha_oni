<div class="d-flex flex-row atomic_card " > 
   
    <div class="col-2 col-md-2 align-self-center p-0">
        <img class="image_profile" src="<?php echo get_avatar_url($user_atual->ID);?>">
    </div>
    <div class="col-5 col-md-5 p-0 align-self-center pl-4">
        <p class="escala1 font-weight-bold mb-0"><?php echo $user_atual->user_nicename;?></p>
        <p class="escala0 mb-0"><?php echo $user_atual->user_email;?></p>
    </div>
    <div class="col-5 col-md-5 mx-4 align-self-center ">
        <button type="button" class="ml-auto btn btn-outline-dark">
            <a class="onipink" href="<?php echo get_site_url()."/user/".$user_atual->user_nicename;?>">Ver perfil</a>
        </button>
    </div>
</div>