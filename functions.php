<?php
/************************ PUXANDO A CLASSE MINHA ONI COM OPERAÇÕES PRÓPRIAS *************************************/
$minha_oni = get_stylesheet_directory() . '/includes/minha_oni_class.php';
include($minha_oni);

/************************ VARIÁVEIS GERAIS *************************************/
$user_atual = wp_get_current_user();
$hoje = strtotime("today");