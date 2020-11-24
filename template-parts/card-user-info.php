<div style='border: solid 1px black;'>
    <img width='50' src="<?php echo get_avatar_url($user_atual->ID);?>">
    <p><?php echo $user_atual->user_nicename;?></p>
    <a href="<?php echo get_site_url()."/user/".$user_atual->user_nicename;?>">Editar perfil</a>
</div>