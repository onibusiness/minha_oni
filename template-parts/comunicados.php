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
<div style='border: solid 1px black;'>
    <p><?php the_title();?></p>
    <p><?php the_content();?></p>
    </div>
<?php
} 
endwhile;
?>
