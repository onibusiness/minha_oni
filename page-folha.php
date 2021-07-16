<?php
/*
Template Name: Folha
*/ 
?>
<?php get_header();?>

<?php

    $processa_folha = get_stylesheet_directory() . '/includes/fechamento_mensal/processa_folha_class.php';
    include($processa_folha);


    ?>

<div class="row ">
    <div class="col-12 ">
        <div class="atomic_card background_white">
            <form method="post" action="" class='row '>
                <div class="col-2">
                    <p>Data inicial:
                        <input type="date" name="data_inicial" value="<?php echo $processa_folha->p_dia ?>">
                    </p>
                </div>
                <div class="col-2">
                    <p>Data final:
                        <input type="date" name="data_final" value="<?php echo $processa_folha->u_dia ?>">
                    </p>
                </div>
                <div class="col-2">
                    <input class="btn btn-info" name="form_action[Filtrar]" type="submit" value="Filtrar">
                    </div>
                <div class="col-1 offset-5">
                    <!--<input  class="btn btn-success"  name="form_action[Salvar]" type="submit" value="Salvar"  onclick="return confirm('Você quer consolidar a folha??');">-->
                    <a  class="white btn btn-success" href="https://minha.oni.com.br/consolidafolha" onclick="return confirm('Você quer consolidar a folha??');"> Salvar </a>
                </div>
                
            </form>
             
        </div>
    </div>
</div>

<div class="row ">

    <?php
    if(count($processa_folha->alerts) > 0){
    ?>
        <div class="col-6 ">
            <div class=" py-4 px-5 mb-3 alert-danger" role="alert">
                <p class="escala1"> A folha ainda não pode ser fechada! </p>
                <?php 
                foreach($processa_folha->alerts as $alert){
                ?>
                    <p class="escala-1"><?php echo $alert;?></p>
                <?php
                }
                ;?>
            </div>
        </div>
        <?php
    }
    ?>

        <div class="col-6 ">
            <div class=" py-4 px-5 mb-3 atomic_card background_white">
                <p class="escala0 bold"> Projetos e guardas da folha </p>
                <p class="escala-1  underline" data-toggle="collapse" data-target="#review_projetos" aria-expanded="false" aria-controls="review_projetos" style="text-decoration: underline; cursor:pointer;"> Revisar projetos e guardas </p>
                
                 <div class="collapse pb-3" id="review_projetos">
                    <div class='row'>
                        <p class='col-3 escala-1 mb-2 bold'>Projeto</p>
                        <p class='col-3 escala-1 mb-2 bold'>Guarda visão</p>
                        <p class='col-3 escala-1 mb-2 bold'>Guarda time</p>
                        <p class='col-3 escala-1 mb-2 bold'>Guarda método</p>
                    </div>
                    <?php 

                    foreach($processa_folha->projetos as $projeto => $gestores){
                        ?>
                        <div class='row'>
                            <p class="col-3 escala-2 mb-0 bold"><?php echo $projeto;?></p>
                            <p class="col-3 escala-2 mb-0 "><?php echo $gestores['guardiao_visao'][0]['display_name'];?></p>
                            <p class="col-3 escala-2 mb-0 "><?php echo $gestores['guardiao_time'][0]['display_name'];?></p>
                            <div class='col-3 escala-2 mb-0' >
                                <?php 
                                if($gestores['guardiao_metodo']){
                                    foreach($gestores['guardiao_metodo'] as $guardiao_metodo){
                                    ?>  
                                        <p ><?php echo $guardiao_metodo['display_name'];?></p>
                                    <?php
                                    }
                                };?>
                            </div>
                        </div>
                    <?php
                    };?>
                </div>
            </div>
        </div>



</div>



<div class="row">
    <div class="col-12 col-md-3">
        <div class="atomic_card ">
            <p class="escala1 onipink font-weight-bold mb-0">Dados financeiros</p>
            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($processa_folha->receitas,2,",",".");?></p>
            <p class="escala0 bold mb-2">Receitas </p>

            <p class="escala-2 onipink underline" data-toggle="collapse" data-target="#receitas" aria-expanded="false" aria-controls="receitas" style="text-decoration: underline; cursor:pointer;"> Ver todas as receitas </p>
   
            <div class="collapse pb-3" id="receitas">
            
                <?php
                foreach($processa_folha->lista_receitas as $receita){
                    ?>
                    <p class="escala-2 mb-0"> <?php echo $receita;?> </p>
                <?php
                }
                ?>
            </div>
            
            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($processa_folha->custos_de_projeto,2,",",".");?></p>
            <p class="escala0 bold mb-2">Custos de projeto </p>

            <p class="escala-2 onipink underline" data-toggle="collapse" data-target="#custos" aria-expanded="false" aria-controls="receitas" style="text-decoration: underline; cursor:pointer;"> Ver todas os custos de projetos </p>
   
            <div class="collapse pb-3" id="custos">
            
                <?php
                foreach($processa_folha->lista_custos_de_projeto as $custo){
                    ?>
                    <p class="escala-2 mb-0"> <?php echo $custo;?> </p>
                <?php
                }
                ?>
            </div>
            <p class="escala0 mb-0">
            </p>

            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($processa_folha->budget_folha,2,",",".");?></p>
            <p class="escala0 bold mb-2">Valor da folha  </p>
            

        </div>
        <div class="atomic_card">
            <p class="escala1 onipink font-weight-bold mb-0">Dados do sistema</p>
            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($processa_folha->valor_do_onion,2,",",".");?></p>
            <p class="escala0 bold mb-2">Valor do onion </p>

            <p class="escala3 bold mb-0"><span class="onipink">Ø </span><?php echo $processa_folha->onions_no_sistema;?></p>
            <p class="escala0 bold mb-2">Onions no sistema </p>

            <p class="escala-1 mb-0">Onions de lentes <span class="bold"><?php echo $processa_folha->onions_lentes;?></span></p>
            <p class="escala-1 mb-0">Onions de competencias <span class="bold"><?php echo $processa_folha->onions_competencia;?></span></p>
            <p class="escala-1 mb-0">Onions de papeis <span class="bold"><?php echo $processa_folha->onions_papeis;?></span></p>
            <p class="escala-1 mb-0">Onions subsidados para os trainees <span class="bold"><?php echo $processa_folha->onions_subsidiados;?></span></p>
            <p class="escala-1 mb-0">Onions de férias <span class="bold"><?php echo $processa_folha->onions_ferias;?></span></p>
    
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="row">
            <?php 
            global $wp_roles;
            foreach($processa_folha->onis as $oni => $folha){

            ?>
                <div class="col-12 col-md-6  ">
                    <div class="row mr-2 px-3 py-5 atomic_card background_white">
                        <div class="col-12 col-md-6">
                            <img class="image_profile" src="<?php echo get_avatar_url($folha["ID"]);?>">
                            <p class="escala1 onipink font-weight-bold mb-0"><?php echo $oni;?></p>
                            <p class="escala0 mb-2 onipink"><?php echo $wp_roles->roles[$folha['funcao']]['name'];?></p>
                    
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['advertencias'];?></span> Advertências</p>
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['onions_competencia'];?></span> Onions de competencias </p>
                            <?php
                            
                            foreach($folha['competencias'] as $competencia){
              
                                ?>
                                <p class="escala-2 mb-0 grey"> <?php echo $competencia['pontos']." - ".$competencia['competencia'];?> </p>
                            <?php
                            }
                            ?>
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['onions_lentes'];?></span> Onions de lentes </p>
                            <?php
                            foreach($folha['lentes'] as $lente){
              
                                ?>
                                <p class="escala-2 mb-0 grey"> <?php echo $lente['lente'];?> </p>
                            <?php
                            }
                            ?>
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['onions_papeis'];?></span> Onions de papeis </p>
                            <?php
                            foreach($folha['guardas'] as $papel){

                                if($papel["com_rodinhas"] == false){
                                ?>
                                <p class="escala-2 mb-0 grey"> <?php echo "[".$papel['papel']."] ".$papel['projeto']->post_title;?> </p>
                            <?php
                                }
                            }
                            ?>
                            <p class="escala0 mb-0 onipink"><span class="bold escala1"><?php echo $folha['onions_de_ferias'];?></span> Onions descontados </p>
                            <p class="escala3 bold mb-0"><span class="onipink">Ø </span><?php echo $folha['onions'];?></p>
                            <p class="escala0 bold mb-2">Onions</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['onions_lentes']*$processa_folha->valor_do_onion,2,",",".");?></p>
                            <p class="escala0 bold mb-2">Lentes  </p>
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format(($folha['onions_competencia']+$folha['gap_trainee'])*$processa_folha->valor_do_onion,2,",",".");?></p>
                            <?php
                            if($folha['gap_trainee'] > 0){
                                    ?>
                                    <p class="escala-2 mb-0 onipink">Considerando 20 onions (subtraídos os onions de lente) </p>
                                <?php
                                
                            }
                            ?>
                            <p class="escala0 bold mb-2">Competências  </p>
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['onions_papeis']*$processa_folha->valor_do_onion,2,",",".");?></p>
                            <p class="escala0 bold mb-2">Papéis  </p>
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['reembolsos'],2,",",".");?></p>
                            <p class="escala0 bold mb-2">Reembolsos  </p>
                            <?php
                            if($folha['descricao_reembolsos']){
                                foreach($folha['descricao_reembolsos'] as $descricao_reembolso){
                                    ?>
                                    <p class="escala-2 mb-0 grey"> <?php echo $descricao_reembolso;?> </p>
                                <?php
                                }
                            }
                            ?>
                            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['remuneracao'],2,",",".");?></p>
                            <p class="escala0 bold mb-2">Remuneração  </p>
                        </div>
                    </div>
                </div>

            <?
            }   

            ?>
        </div>
    </div>
</div>




<?php get_footer(); ?>