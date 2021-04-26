



<?php get_header(); ?>

<?php



$args = array(
    'posts_per_page' => -1,
    'no_found_rows' => true,
    'post_type'		=> 'frentes',
    'post_status'   => 'publish',
    'meta_key'		=> 'id_da_frente_pipefy',
    'meta_value'	=> '418477931'
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
    $id_frente_wordpress = get_the_ID();
    echo "<pre>";
    var_dump($id_frente_wordpress);
    echo "</pre>";
endwhile;endif; 
wp_reset_postdata();

 $table_records_frentes = get_transient('table_records_frentes');
 echo "<pre>";
 var_dump($table_records_frentes);
 echo "</pre>";

//processa_frentes::cadastraFrente(get_transient('table_records_frentes'),get_transient('projeto_cadastrado')['projeto_cadastrado'][0]);
/*

TESTANDO AQUI O CÁLCULO DAS SEMANAS DA FRENTE

$data_de_inicio_obj = DateTime::createFromFormat('d/m/Y', '19/04/2021');
$data_de_fim_obj = DateTime::createFromFormat('d/m/Y', '04/05/2021');
$interval = $data_de_inicio_obj->diff($data_de_fim_obj);
$semanas = ceil($interval->days/7);
echo "<pre>";
var_dump($semanas);
echo "</pre>";
*/


/*

TESTANDO AQUI A CRIAÇÃO DAS MISSÕES DE GESTÃO DA FRENTE

$frentes_cadastradas = get_transient('criamissoes');
foreach($frentes_cadastradas as $frentes_cadastrada){

    clickup::clickMissoesGestao($frentes_cadastrada[0],$frentes_cadastrada[1], $frentes_cadastrada[2],$frentes_cadastrada[3], $frentes_cadastrada[4]);

} 
*/

/*
$today = DateTime::createFromFormat('d/m/Y', '17/03/2021');
echo $today->getTimestamp(); # or $dt->format('U');
$today = $today->getTimestamp();

echo "<pre>";
var_dump($today);
echo "</pre>";

$tomorrow = strtotime('tomorrow');
echo "<pre>";
var_dump($tomorrow);
echo "</pre>";

echo "<pre>";
var_dump(clickup::clickCriaList('lista',1614611719,1615994119,'3107782', '35709302') );
echo "</pre>";
*/


?>
<?php get_footer(); ?>
