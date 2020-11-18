<?php get_header(); 
acf_form_head(); 
acf_enqueue_uploader();
$post_type_atual = is_archive() ? get_queried_object()->name : false;
$user_atual = get_current_user_id();


//FAZENDO O LOOP DOS ANTIGOS 
$args = array(  
    'post_type' => $post_type_atual ,
    'post_status' => array('pending','publish'),
    'posts_per_page' => -1,
    'meta_query' => array(
		array(
			'key' => 'oni',
			'value' => $user_atual,
			'compare' => '=='
        )
    )
);
$posts_antigos = new WP_Query( $args ); 
while ( $posts_antigos->have_posts() ) : $posts_antigos->the_post(); 
    $campos = get_fields();
    foreach($campos as $nome_do_campo => $conteudo_do_campo){
        if($nome_do_campo != 'oni' && $nome_do_campo != '_validate_email' ){
            $objeto_do_campo = get_field_object($nome_do_campo);

            if(is_object($conteudo_do_campo)){
                $conteudo_do_campo = $conteudo_do_campo->post_title;
            }
            echo "<p><strong>".$objeto_do_campo['label']."</strong> :".$conteudo_do_campo."</pre>";
        }
    }
    ?>
    <p>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="<?php echo '#'.$post_type_atual.$post->ID;?>" aria-expanded="false" aria-controls="<?php echo $post_type_atual.$post->ID;?>">Editar</button>
    </p>
    
    <div class="row">
        <div class="col">
            <div class="collapse" id="<?php echo $post_type_atual.$post->ID;?>">
                <div class="card card-body">
                   <?php acf_form();?>
                </div>
            </div>
        </div>
    </div>
    <?php
 
    // DÁ PRA COLOCAR UM FORM PARA CADA OCORRÊNCIA OCULTO E PERMITIR A EDIÇÃO COM O CLIQUE DE UM BOTÃO  
    // DIEGO: implementar botão para deletar o form pelo front
    // DIEGO: mostrar um botão verde ou amarelo de acordo com o status do post, se estiver publicado fica verdde (sócio aprovrou)

endwhile;


//CRIAR UM NOVO 
acf_form(array(
    'post_id'       => 'new_post',
    'new_post'      => array(
        'post_type'     => $post_type_atual ,
        'post_status'   => 'pending'
    ),
    'submit_value'  => 'Criar'
));

wp_reset_postdata(); 



?>

<?php the_content(); ?>

<?php get_footer();?>