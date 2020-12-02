<?php 
$args = array(  
    'post_type' => 'comunicados' ,
    'post_status' => array('publish'),
    'posts_per_page' => -1
);
$comunicados = new WP_Query( $args ); 
while ( $comunicados->have_posts() ) : $comunicados->the_post(); 
$dias = "+".get_field('dias')." days";
$data_publicada = get_the_date('y-m-d');//data de publicacao do aviso
$data_limite = strtotime($dias, strtotime($data_publicada));//data limite do aviso
//só mostra se tiver na data
if($data_limite >= $hoje){
?>
<div class="atomic_card background_pink py-4 px-5">
    <p class="escala1 bold onipetro"><?php the_title();?></p>
    <div class="escala-1"><?php the_content();?></div>
    </div>
<?php
} 
endwhile;
?>
