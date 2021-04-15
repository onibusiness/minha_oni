



<?php get_header(); ?>

<?php
$request = get_transient('request');
echo "<pre>";
var_dump($request);
echo "</pre>";

$table_records_frentes = get_transient('table_records_frentes');
echo "<pre>";
var_dump($table_records_frentes);
echo "</pre>";

?>
<?php get_footer(); ?>
