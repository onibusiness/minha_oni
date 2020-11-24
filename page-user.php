
<?php
/*
Template Name: User
*/
?>
<?php acf_form_head(); ?>
<?php get_header();
//Pega o ID do perfil quando está na página profile do Ultimate member
$profile_id = um_profile_id();
//Pega e ajusta a permissão do perfil
$profile_atual = get_user_meta($profile_id);
$permissoes = unserialize($profile_atual['wp_capabilities'][0]);

um_fetch_user( um_profile_id() );
//echo um_user('display_name');

?>

<?php the_content(); ?>
    <!-- 
    /*
    TO-DO
    Definir uma interação de front com botão e fomulário oculto apenas para administradores
    */
    -->
<?php 
//Se for Administrador
if(current_user_can('administrator')){
    // Puxando o ACF form com as opções de perfil para o preenchimento pelo front do administrator  
    $options = array(
    'field_groups' => ['group_5f3fe0d54faef'],
    'post_id' => "user_{$profile_id}",
    'form' => true,
    );
    
    acf_form($options);
}
?>
    <!-- 
    /*
    TO-DO
    Implementar o feedback de post atualizado em um alert do bootstap
    */
    -->

<?php get_footer();?>