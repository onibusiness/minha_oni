<?php get_header(); 
$processa_projetos = new processa_projetos;
?>
<div class="row">
    <?php
    while ( $processa_projetos->projetos->have_posts() ) : $processa_projetos->projetos->the_post(); 
    $fields = get_fields();
        if($fields['status'] == 'ativo'){
        ?>
            <div class="col-12 col-md-3">
                <div class="atomic_card background_white" >
                <p class="escala0 mb-1 onipink bold"><?php echo $fields['projeto']; ?></p>
                <?php
                
                echo "<pre>";
                var_dump($fields);
                echo "</pre>";
                ?>
                </div>
            </div>


        <?php
        }
        ?>
    <?php
    endwhile;
    ?>
</div>
<?php
    get_footer();
?>