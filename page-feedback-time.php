<?php get_header(); 
acf_form_head(); 
acf_enqueue_uploader();

?>

    

<div class="row mt-4">
    <div class="col-12 col-lg-10 offset-lg-1">
        <p class="escala3 bold onipink"><?php echo $nome_projeto; ?> Percepção sobre os gestores da frente <?php echo $nome_frente; ?> </p>
    </div>
</div>
<div class="row "> 
    <div class="col-10 offset-1">
        <?php
        //CRIAR UM NOVO 
        acf_form(array(
            'post_id'       => 'new_post',
            'new_post'      => array(
                'post_type'     => 'feedback_time' ,
                'post_status'   => 'publish'
            ),
            'fields' => array(),
            'submit_value'  => 'Enviar feedback',
            'html_submit_button'  => '<input type="submit" class="btn btn-danger" value="%s" />',
            'return' => site_url()."/obrigado",
        ));
        ?>

    </div>
</div>

<?php









?>

<?php the_content(); ?>

<?php get_footer();?>