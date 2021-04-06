



<?php get_header(); ?>

<?php

$evidencias = new processa_evidencias;
echo "<pre>";
var_dump($evidencias->evidencias);
echo "</pre>";

?>
<?php get_footer(); ?>
