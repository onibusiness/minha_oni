



<?php get_header(); ?>

<?php

$historico = new historico;
$historico_pagamentos = $historico->pegaHistoricoPagamento(15);
$ultimo_mes_com_pagamento = array_key_first($historico_pagamentos);
$historico_pagamentos = $historico_pagamentos[$ultimo_mes_com_pagamento];
echo "<pre>";
var_dump($historico_pagamentos);
echo "</pre>";
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
