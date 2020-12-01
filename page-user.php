
<?php
/*
Template Name: User
*/
?>
<?php acf_form_head(); ?>
<?php get_header();

//Pega o ID do perfil quando está na página profile do Ultimate member
$profile_id = um_profile_id();

//Pega e ajusta a permissão do perfil
$profile_atual = get_user_meta($profile_id);

$permissoes = unserialize($profile_atual['wp_capabilities'][0]);
um_fetch_user( um_profile_id() );

?>

<div class="row">
    <div class="col-4">
        <?php 
        include(get_stylesheet_directory() . '/template-parts/card-user-full-info.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-guardas.php');
        include(get_stylesheet_directory() . '/template-parts/card-user-equipamentos.php');
        ?>
    </div>
    <?php
    //Se for admin ou o próprio usuário
    if(current_user_can('administrator') || get_current_user_id() == $profile_id ){
    ?>
        <div class="col-8 pl-0">
            <div class="row">
                <div class="col-7">
                <?php 
                include(get_stylesheet_directory() . '/template-parts/card-user-evidencias.php');
                ?>
                </div>
                <div class="col-5 pl-0">
                <?php 
                include(get_stylesheet_directory() . '/template-parts/card-user-todas-ferias.php');
                ?>
                </div>
            </div>
            <?php $historico = new historico;?> 
            <!-- Barra de botões de meses controlando as linhas debaixo via collapse -->
            <div class="atomic_card background_white">
                <div class="d-flex justify-content-between">
                    <?php foreach($historico->seis_meses as $mes){
                        ?>
                        <p>
                            <button class="btn btn btn-outline-danger target_js" type="button" data-toggle="collapse" data-target="<?php echo '#'.$mes['classe'];?>" aria-expanded="false" aria-controls="<?php echo $mes['classe'];?>"><?php echo $mes['data'];?></button>
                        </p>
                    <?php
                    }
                    ?>
                </div>
                <?php 
                $historico_pagamentos = $historico->pegaHistoricoPagamento($current_user);
                foreach($historico->seis_meses as $mes){
                    ?>
                    <!-- Uma row para cada mês de histórico -->
                    <div class="col-md-12 row collapse target_js pt-4" id="<?php echo $mes['classe'];?>">
                        <?php
                        if($historico_pagamentos[$mes['classe']]){
                            ?>
                            <!-- Coluna da esquerda  -->
                            <div class="col-5">
                                <!-- Card de remuneração  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>Onions - <?php echo $historico_pagamentos[$mes['classe']]['onions_competencia']+$historico_pagamentos[$mes['classe']]['onions_papeis'];?></p>
                                        <p>R$ - <?php echo $historico_pagamentos[$mes['classe']]['remuneracao'];?></p> 
                                    </div>
                                </div> 
                                <!-- Card de guardas  -->
                                <div class="row">
                                    <div class="col-12">
                                        <p>Guardião de:</p>
                                        <?php
                                        foreach($historico_pagamentos[$mes['classe']]['guardas'] as $guarda){
                                            ?>
                                        <p><?php echo $titulo_guardas['choices'][$guarda['papel']]." de ".$guarda['projeto']?> </p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>         
                            </div>
                            <!-- Coluna da direita  -->
                            <div class="col-7">
                                <!-- Card de competências  -->
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        echo "<pre>";
                                        var_dump($historico_pagamentos[$mes['classe']]['competencias']);
                                        echo "</pre>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                        }else{
                            ?>
                            <p>você não tem lançamentos desse mês</p>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
        </div>
    </div>
    <?php
    //Se for outro usuário vendo o perfil dele
}else{
    ?>
        <div class="col-8">
            <?php
             $historico = new historico;
             $historico_pagamentos = $historico->pegaHistoricoPagamento($current_user);
             $ultimo_do_historico = end($historico_pagamentos);
             echo "<pre>";
             var_dump($ultimo_do_historico['competencias']);
             echo "</pre>";

            ?>
        </div>
    <?php
    }
    ?>
</div>

<?php get_footer();?>