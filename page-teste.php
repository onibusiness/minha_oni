



<?php get_header(); ?>

<?php

$historico = new historico;
$historico_pagamentos = $historico->pegaHistoricoPagamento(15);
foreach($historico->seis_meses as $mes){
    $mostrar = '';
    if($mes == $ultimo_mes){
        $mostrar = "show";
    }
}
$competencias_do_oni = $historico_pagamentos[$mes['classe']]['competencias'];
foreach($competencias_do_oni as $competencia_do_oni){
    echo "<pre>";
var_dump($competencia_do_oni["competencia"]);
echo "</pre>";
}

?>
<?php get_footer(); ?>
