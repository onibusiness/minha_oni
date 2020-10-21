<?php get_header(); 
acf_form_head(); 
$post_type_atual = get_archive_post_type();
$user_atual = get_current_user_id();


//FAZENDO O LOOP DOS ANTIGOS 
$args = array(  
    'post_type' => $post_type_atual ,
    'post_status' => 'publish',
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
    print the_title(); 
    // DÁ PRA COLOCAR UM FORM PARA CADA OCORRÊNCIA OCULTO E PERMITIR A EDIÇÃO COM O CLIQUE DE UM BOTÃO
    // DIEGO: implementar botão e js pra exibir o form
    acf_form();
    // DIEGO: implementar botão para deletar o form pelo front
endwhile;


//CRIAR UM NOVO 
acf_form(array(
    'post_id'       => 'new_post',
    'new_post'      => array(
        'post_type'     => $post_type_atual ,
        'post_status'   => 'publish'
    ),
    'submit_value'  => 'Criar'
));

wp_reset_postdata(); 



?>

<?php the_content(); ?>

<?php get_footer();?>