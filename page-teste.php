



<?php get_header(); ?>

<?php
echo "<pre>";
var_dump($pipefy);
echo "</pre>";


echo "<pre>";
var_dump($clickup);
echo "</pre>";

$args = array(
    'posts_per_page' => -1,
    'no_found_rows' => true,
    'post_type'		=> 'evidencias',
    'post_status'   => 'publish',
    'meta_key'		=> 'parecer',
    'meta_value'	=> 'onion_up'
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
    $fields = get_fields();
    $id = get_the_ID();
    
    echo $fields['oni']->data->display_name."</br>";
    echo $fields['Lente']->post_title."</br>";
    $args = array(
        'posts_per_page' => -1,
        'no_found_rows' => true,
        'post_type'		=> 'evolucoes',
        'post_status'   => 'publish',
        'meta_key'		=> 'evidencia',
        'meta_value'	=> $id
    );
    $quar = new WP_Query( $args );
    if ( $quar->have_posts() ) : while ( $quar->have_posts() ) : $quar->the_post();
    $ied = get_the_ID();
    echo $ied."</br>";
    echo "<hr>";
    endwhile;endif;

endwhile;endif;



         $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'frente',
                    'value' => $id_frente_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();

            $oni = get_field('oni');
            $informacoes_oni = get_field('informacoes_gerais', 'user_'.$oni['ID']);
            echo "<pre>";
            var_dump($informacoes_oni['id_do_clickup']);
            echo "</pre>";
        endwhile;endif;


$alteramissoes = get_transient('alteramissoes');
echo "<pre>";
var_dump($alteramissoes);
echo "</pre>";




$status_altera_missao = get_transient('status_altera_missao');
echo "<pre>";
var_dump($status_altera_missao);
echo "</pre>";


$tasks_alteradas = get_transient('tasks_alteradas');
echo "<pre>";
var_dump($tasks_alteradas);
echo "</pre>";

/*
TESTANDO AS FUNÇÕES DE CRON
$wp_cron_tasks = get_option( 'cron' );

wp_schedule_single_event( time() + 600, 'admin_action_criar_missoes_clickup' ); 
wp_clear_scheduled_hook(  'admin_action_criar_missoes_clickup' );
*/


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
