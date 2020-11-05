<?php
$primeiro_dia_mes_passado = strtotime("first day of last month");
$ultimo_dia_mes_passado = strtotime("last day of last month");
$p_dia = date('Y-m-d', $primeiro_dia_mes_passado);
$u_dia = date('Y-m-d', $ultimo_dia_mes_passado);

if (!empty($_POST['form_action'])){
    $p_dia = $_POST['data_inicial'];
    $u_dia = $_POST['data_final'];
    $h_dia = $_POST['data_final'];
}   
$u_dia_date= strtotime($u_dia);
$uu_dia = strtotime("last day of next month",$u_dia_date);
$h_dia = date('Y-m-d', $uu_dia);

/********** DIAS *************/
$dias_uteis = getWorkdays(strtotime($p_dia), strtotime($u_dia));
?>