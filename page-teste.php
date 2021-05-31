



<?php get_header(); ?>

<?php

 
/*
$id_guardiao_metodo = 7;
$dados_guardiao_metodo = get_field('informacoes_gerais', 'user_'.$id_guardiao_metodo);
$id_clickup_guardiao_metodo = $dados_guardiao_metodo['id_do_clickup'];
echo "<pre>";
var_dump($id_clickup_guardiao_metodo);
echo "</pre>"; 
*/

echo "oia";
$my_posts = new WP_Query( array( 'p' => 6787, 'post_type' => 'advertencias' ) );

if($my_posts->have_posts()) : 
    
    while ( $my_posts->have_posts() ) : $my_posts->the_post(); 

        $campos = get_fields();
        echo "<pre>";
        var_dump($campos);
        echo "</pre>";

    endwhile; //end the while loop

endif; // end of the loop. 
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
