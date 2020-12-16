<?php get_header(); 
acf_form_head(); 
acf_enqueue_uploader();
?>
<div class="row pb-4">
    <div class="col-12 col-lg-10 offset-lg-1">
        <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#novaevidencia"  aria-controls="#novaevidencia">
        Cadastrar evidência
      </button>
    </div>
</div>
<div class="row collapse" id="novaevidencia">
    <div class="col-10 offset-1">
        <?php
        //CRIAR UM NOVO 
        acf_form(array(
            'post_id'       => 'new_post',
            'new_post'      => array(
                'post_type'     => 'evidencias' ,
                'post_status'   => 'pending'
            ),
            'submit_value'  => 'Criar'
        ));
        ?>

    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-10 offset-lg-1">
        <p class="escala1 bold">Todas as suas evidências: </p>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-10 offset-lg-1 ">
        <div class="atomic_card  background_white ">
            <?php 
            $evidencias = new processa_evidencias;
            $evidencias_do_oni = $evidencias->evidencias_filtradas;
            
            while ( $evidencias_do_oni->have_posts()) : $evidencias_do_oni->the_post(); 
                $campos = get_fields();

                ?>
                
                <div class=" row">
                    <div class="col-12">
                        <div class='row align-items-center'>
                            <div class='col-12 col-lg-1'>
                                <p class="escala-1"><p class='<?php echo $campos['parecer'];?>'></p>
                            </div>
                            <div class='col-12 col-lg-1'>
                                <p class="onipink bold escala-1 mb-0">Data</p>
                            <p class="escala-1"><?php echo $campos['data'];?></p>
                            </div>
                            <div class='col-12 col-lg-2'>
                                <p class="onipink bold escala-1 mb-0">Competência</p>
                                <p class="escala-1"><?php echo $campos['competencia']->post_title;?></p>
                            </div>
                            <div class='col-12 col-lg-2'>
                                <p class="onipink bold escala-1 mb-0">Projeto</p>
                                <p class="escala-1"><?php echo $campos['projeto']->post_title;?></p>
                            </div>
                            <div class='col-12 col-lg-6 text-right'>
                            
                                <span class="ml-4" type="button" data-toggle="collapse" data-target="<?php echo '#descricao'.$post->ID;?>"  aria-controls="<?php echo $post_type_atual.$post->ID;?>"><i class="fas fa-eye"></i> Ver</span>
                        
                                <span class="ml-4" type="button" data-toggle="collapse" data-target="<?php echo '#evidencia'.$post->ID;?>"  aria-controls="<?php echo $post_type_atual.$post->ID;?>"><i class="fas fa-edit"></i> Editar</span>
                                
                                <?php
                             
                                if (current_user_can('edit_post', $post->ID)){
                                ?>
                                    <a  class="ml-4" onclick="return confirm('Quer mesmo deletar essa evidência?')" class="delete-post" href="<?php echo get_delete_post_link( $post->ID );?>"><i class="fas fa-trash-alt"></i> Deletar</a>
                                    <?php
                                }
                                ?>
            
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="collapse row" id="<?php echo "descricao".$post->ID;?>">
                            <div class="col-5">
                                <p class=" bold escala-1 mb-0">Evidência</p>
                                <p class="escala-1"><?php echo $campos['evidencia'];?></p>
                                <p class=" bold escala-1 mb-0">Link</p>
                                <p class="escala-1"><a href='<?php echo $campos['link_da_evidencia'];?>' target="_blank">link</a></p>
                            </div>
                            <div class="col-7">
                                <p class=" bold escala-1 mb-0">Feedback Método</p>
                                <p class="escala-1"><?php echo $campos['feedback_guardiao_metodo'];?></p>
                                <p class=" bold escala-1 mb-0">Feedback Visão</p>
                                <p class="escala-1"><?php echo $campos['feedback_guardiao_visao'];?></p>
                                <p class=" bold escala-1 mb-0">Feedback Time</p>
                                <p class="escala-1"><?php echo $campos['feedback_guardiao_time'];?></p>
                                <p class=" bold escala-1 mb-0">Feedback Sócios</p>
                                <p class="escala-1"><?php echo $campos['feedback_dos_socios'];?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="collapse row" id="<?php echo "evidencia".$post->ID;?>">
                            <p class="col-12">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="<?php echo '#evidencia'.$post->ID;?>"  aria-controls="<?php echo $post_type_atual.$post->ID;?>">Fechar</button>
                            </p>
                            <?php acf_form();?>
                        </div>
                    </div>
                
                </div>
                <hr class='col-12'/>

                
                <?php
            endwhile;
            ?>
        
        </div>
    </div>
</div>
<?php









?>

<?php the_content(); ?>

<?php get_footer();?>