<?php
/*
Template Name: Evidências
*/ 
?>
<?php get_header();acf_form_head(); 
acf_enqueue_uploader(); ?>
<?php
$evidencias = new processa_evidencias;

?>
<div class="container-fluid">
    <div class="row py-5">
        <div class="col-2">
            <?php 
            include(get_stylesheet_directory() . '/template-parts/card-onis-evidencias.php');
            ?>
        </div>
      

        <div class="col-7">
            <?php
            include(get_stylesheet_directory() . '/template-parts/card-oni-avaliacao-evidencias.php');
            ?>
           <div class="row">
                <div class="col-12">
                    <p class="escala1 bold">Evidências já avaliadas: </p>
                </div>
            </div>
            <?php
            include(get_stylesheet_directory() . '/template-parts/card-oni-evidencias-avaliadas.php');
            ?>
         
        </div>
        <?php if($_GET['oni']){
                $oni_nicename = get_user_by('id', $_GET['oni'])->user_nicename;?>
            
            <div class="col-3">
                <?php
                include(get_stylesheet_directory() . '/template-parts/card-user-competencias.php');
                ?>

            </div>

        <?php };?>
    </div>
</div>

<?php get_footer(); ?>