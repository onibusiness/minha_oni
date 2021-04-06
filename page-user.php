
<?php
/*
Template Name: User
*/
?>
<?php acf_form_head(); ?>
<?php get_header();


//Pega o ID do perfil quando está na página profile do Ultimate member
$profile_id = um_profile_id();

//Pega o objeto do pergil
$profile_obj = get_user_by('ID',$profile_id);

//Pega e ajusta a permissão do perfil
$profile_atual = get_user_meta($profile_id);

$permissoes = unserialize($profile_atual['wp_capabilities'][0]);
um_fetch_user( um_profile_id() );


$competencias = new processa_competencias;

?>

<div class="row">
    <div class="col-12 col-md-3">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/card-user-full-info.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-guardas.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-metodo.php');
        ?>
    </div>
    <?php
    //Se for admin ou o próprio usuário
    if(current_user_can('edit_users') || get_current_user_id() == $profile_id ){
    ?>
        <div class="col-12 col-md-8 pl-md-0">
            <div class="row">
                <div class="col-12 col-md-7">
                <?php 
                include(get_stylesheet_directory() . '/template-parts/card-user-evidencias.php');
                ?>
                </div>
                <div class="col-12 col-md-5 pl-0">
                <?php 
                include(get_stylesheet_directory() . '/template-parts/card-user-todas-ferias.php');
                ?>
                </div>
            </div>

            <?php 
            include(get_stylesheet_directory() . '/template-parts/card-user-historico.php');
            ?>

            
        </div>
    </div>
    <?php
    //Se for outro usuário vendo o perfil dele
}else{
?>
    <div class="col-8">
        <?php
            $historico = new historico;
            $ultimo_mes = end($historico->seis_meses);
            $historico_pagamentos = $historico->pegaHistoricoPagamento($profile_id);
            $mes['classe'] = array_key_first($historico_pagamentos);
      
            ?>
            <div class="atomic_card background_white" >
                <div class="row">
                    <div class="col-12" style="column-count: 2; column-gap: 2em;">
                            <?php
                        include(get_stylesheet_directory() . '/template-parts/user-competencias-historico.php');
                        ?>
                    </div>
                </div>
            </div>
        
   
    </div>
<?php
}
?>
</div>

<?php get_footer();?> 