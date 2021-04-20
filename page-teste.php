



<?php get_header(); ?>

<?php
$criamissao = get_transient('criamissoes');
echo "<pre>";
var_dump($criamissao);
echo "</pre>";
// 
echo "<pre>";
var_dump(clickup::clickMissoesGestao($criamissao[0], $criamissao[1], $criamissao[2]));
echo "</pre>";



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
