<div class="atomic_card background_white">
    <p class="escala1 bold">Avaliando oni </p>
    <div class="col-10">
        <?php
        //CRIAR UM NOVO 
        acf_form(array(
            'post_id'       => 'new_post',
            'new_post'      => array(
                'post_type'     => 'avaliacoes' ,
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

