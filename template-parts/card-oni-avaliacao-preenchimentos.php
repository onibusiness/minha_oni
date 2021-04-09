<div class="atomic_card background_white">
<?php
if($_GET['oni_avaliado']){
?>
    <p class="escala1 bold">Dando feedback para  <?php 
    echo get_userdata($_GET['oni_avaliado'])->data->user_nicename;
    ?> </p>
    <div class='escala-1'>


        <p class='bold'>
        Essa ferramenta serve para:
        </p>
        <p>
        1. Entender e refletir sobre como o time te percebe.
        </p>
        <p>
        2. Ajudar os outros a entenderem como são enxergados.
        </p>
        <p>
        Seja o mais transparente e justo possível no seu feedback, assim, todo mundo cresce junto.
        </p>
        
    </div>
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
  <?php
}else{
?>
    <p class="escala1 bold">Selecione um Oni na lista para preencher o feedback </p>    
<?php
}
?>
</div>

