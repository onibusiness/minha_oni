<?php
/*
Template Name: Avaliações
*/ 
?>
<?php get_header();acf_form_head(); 
acf_enqueue_uploader(); ?>
<?php
$evidencias = new processa_evidencias;
global $template;
echo basename($template)
?>
<div class="container-fluid">
    <div class="row py-5">
        <div class="col-2">
            <?php 
            include(get_stylesheet_directory() . '/template-parts/card-onis-avaliacoes.php');
            ?>
        </div>
      

        <div class="col-7">
            <?php
            include(get_stylesheet_directory() . '/template-parts/card-oni-avaliacao-preenchimentos.php');
            ?>
           <div class="row">
                <div class="col-12">
                    <p class="escala1 bold">Evidências já avaliadas: </p>
                </div>
            </div>
         
        </div>

    </div>
</div>

<?php get_footer(); ?>