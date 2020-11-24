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
            $users_wordpress = get_users();
            foreach($users_wordpress as $user){
                if($user->ID == $_GET['oni']){
                    $classe = "ativo";
                }
            ?>  
                <p class="<?php echo $classe;?>">
                    <a href="?oni=<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></a> 
                    <span><?php echo "(".$evidencias->onis_status_evidencias[$user->user_nicename]['sem_parecer'].")"?></span>
                    <span><?php echo "(".$evidencias->onis_status_evidencias[$user->user_nicename]['gestor_avaliar'].")"?></span>
                    <span><?php echo "(".$evidencias->onis_status_evidencias[$user->user_nicename]['socio_avaliar'].")"?></span>
                </p>
            <?php
            }
            ?>
        </div>
        <?php if($_GET['oni']){
                $oni_nicename = get_user_by('id', $_GET['oni'])->user_nicename;?>
            
            <div class="col-3">
            <?php 
                $competencias = new processa_competencias;
                //Fazendo o loop nas competencias do sistema e apontando para a competencia do oni para pegar o nível
                while ( $competencias->competencias->have_posts() ) : $competencias->competencias->the_post(); 
                    echo get_the_title()." - nível : ".$competencias->competencias_por_oni[$oni_nicename][get_the_title()];

                endwhile;
               
            ?>
            </div>
        <?php };?>

        <div class="col-6">
            <?php

                while ( $evidencias->evidencias_filtradas->have_posts() ) : $evidencias->evidencias_filtradas->the_post(); 
                    $campos = get_fields();
                    $id_evidencia = $post->ID;
    
    
                    foreach($campos as $nome_do_campo => $conteudo_do_campo){
                        if($nome_do_campo != '_validate_email' ){
                            $objeto_do_campo = get_field_object($nome_do_campo);

                            if(is_object($conteudo_do_campo)){
                                $conteudo_do_campo = $conteudo_do_campo->post_title;
                            }
                            echo "<p><strong>".$objeto_do_campo['label']."</strong> :".$conteudo_do_campo."</pre>";
                        }
                    }
                    ?>
                    <p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="<?php echo '#evidencia'.$id_evidencia;?>" aria-expanded="false" aria-controls="<?php echo 'evidencia'.$id_evidencia;?>">Editar</button>
                    </p>

                    <h5>
                    Outras Evidências de <?php echo $campos['competencia']->post_title; ?> do <?php echo $campos['oni']->data->user_nicename ?> 
                    </h5>
                    <p>
                    <?php 
                    $outras_evidencias = processa_evidencias::maisEvidenciasCompetencia($campos['oni'], $campos['competencia'], $evidencias);
                    foreach($outras_evidencias as $outra_evidencia){
        
                        if($outra_evidencia !== $id_evidencia ){
                            $data = get_field('data', $outra_evidencia);
                            $evidencia = get_field('evidencia', $outra_evidencia);
                            $feedback_socios = get_field('feedback_dos_socios', $outra_evidencia);
                            $parecer = get_field('parecer', $outra_evidencia);
                            echo "[".$parecer."] ".$data." | ".$evidencia." | ".$feedback_socios;
                        }
                    }
                     ?> 
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="collapse" id="<?php echo "evidencia".$id_evidencia;?>">
                                <div class="card card-body">
                                <?php acf_form();?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                

                endwhile;

            ?>
         
        </div>
    </div>
</div>

<?php get_footer(); ?>