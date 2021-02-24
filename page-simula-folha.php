<?php
/*
Template Name: Simula Folha
*/ 
?>
<?php get_header();?>
<?php
    $simula_folha = get_stylesheet_directory() . '/includes/fechamento_mensal/simula_folha_class.php';
    include($simula_folha);

    ?>
<form method="post" action="" >
<div class="row ">
    <div class="col-12 ">
        <div class="atomic_card background_white">
            <div class="row">
                <div class="col-2">
                    <p>Data inicial:
                        <input type="date" name="data_inicial" value="<?php echo $simula_folha->p_dia ?>">
                    </p>
                </div>
                <div class="col-2">
                    <p>Data final:
                        <input type="date" name="data_final" value="<?php echo $simula_folha->u_dia ?>">
                    </p>
                </div>
            
            </div>
            
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12 col-md-3">
        <div class="atomic_card ">
            <p class="escala1 onipink font-weight-bold mb-0">Dados financeiros</p>
            <p class="escala3 bold mb-0"><span class="onipink">R$ </span> 
                <input class="petro bold" type="text" name="receitas" value="<?php echo $simula_folha->receitas;?>">
            </p>
            <p class="escala0 bold mb-2">Receitas </p>
            

            <p class="escala-2 onipink underline" data-toggle="collapse" data-target="#receitas" aria-expanded="false" aria-controls="receitas" style="text-decoration: underline; cursor:pointer;"> Ver todas as receitas </p>
   
            <div class="collapse pb-3" id="receitas">
            
                <?php
                foreach($simula_folha->lista_receitas as $receita){
                    ?>
                    <p class="escala-2 mb-0"> <?php echo $receita;?> </p>
                <?php
                }
                ?>
            </div>
            
            <p class="escala3 bold mb-0"><span class="onipink">R$ </span> 
                <input class="petro bold" type="text" name="custos_de_projeto" value="<?php echo $simula_folha->custos_de_projeto;?>">
            </p>

            <p class="escala0 bold mb-2">Custos de projeto </p>

            <p class="escala-2 onipink underline" data-toggle="collapse" data-target="#custos" aria-expanded="false" aria-controls="receitas" style="text-decoration: underline; cursor:pointer;"> Ver todas os custos de projetos </p>
   
            <div class="collapse pb-3" id="custos">
            
                <?php
                foreach($simula_folha->lista_custos_de_projeto as $custo){
                    ?>
                    <p class="escala-2 mb-0"> <?php echo $custo;?> </p>
                <?php
                }
                ?>
            </div>
            <p class="escala0 mb-0">
            </p>

            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($simula_folha->budget_folha,2,",",".");?></p>
            <p class="escala0 bold mb-2">Valor da folha  </p>
            

        </div>
        <div class="atomic_card">
            <p class="escala1 onipink font-weight-bold mb-0">Dados do sistema</p>
            <p class="escala3 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($simula_folha->valor_do_onion,2,",",".");?></p>
            <p class="escala0 bold mb-2">Valor do onion </p>


            <p class="escala3 bold mb-0"><span class="onipink">Ø </span> 
                <input class="petro bold" type="text" name="onions_adicionais" value="<?php echo ($_POST['onions_adicionais']) ?  $_POST['onions_adicionais'] :  0;?>">
            </p>
            <p class="escala0 bold mb-2">Onions inseridos <span class="escala-1 onipink">números positivos adicionam, números negativos removem</span></p>

            <p class="escala3 bold mb-0"><span class="onipink">Ø </span><?php echo $simula_folha->onions_no_sistema;?></p>
            <p class="escala0 bold mb-2">Onions no sistema </p>

            <p class="escala-1 mb-0">Onions de lentes <span class="bold"><?php echo $simula_folha->onions_lentes;?></span></p>
            <p class="escala-1 mb-0">Onions de competencias <span class="bold"><?php echo $simula_folha->onions_competencia;?></span></p>
            <p class="escala-1 mb-0">Onions de papeis <span class="bold"><?php echo $simula_folha->onions_papeis;?></span></p>
            <p class="escala-1 mb-0">Onions subsidados para os trainees <span class="bold"><?php echo $simula_folha->onions_subsidiados;?></span></p>
            <p class="escala-1 mb-0">Onions de férias <span class="bold"><?php echo $simula_folha->onions_ferias;?></span></p>
    
        </div>
    </div>
    
    <div class="col-12 col-md-8">
        <div class="row">
            <?php 
            global $wp_roles;
            foreach($simula_folha->onis as $oni => $folha){

            ?>
                <div class="col-12 col-md-6  ">
                    <div class="row mr-2 px-3 py-5 atomic_card background_white">
                        <div class="col-12 col-md-6">
                            <img class="image_profile" src="<?php echo get_avatar_url($folha["ID"]);?>">
                            <p class="escala1 onipink font-weight-bold mb-0"><?php echo $oni;?></p>
                            <p class="escala0 mb-2 onipink"><?php echo $wp_roles->roles[$folha['funcao']]['name'];?></p>
                    
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['advertencias'];?></span> Advertências</p>
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['onions_competencia'];?></span> Onions de competencias </p>
                            <p class="escala0 mb-0"><span class="bold escala1"><?php echo $folha['onions_papeis'];?></span> Onions de papeis </p>


                            <p class="escala3 bold mb-0"><span class="onipink">Ø </span><?php echo $folha['onions'];?></p>
                            <p class="escala0 bold mb-2">Onions</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['onions_competencia']*$simula_folha->valor_do_onion,2,",",".");?></p>
                            <p class="escala0 bold mb-2">Competências  </p>
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['onions_papeis']*$simula_folha->valor_do_onion,2,",",".");?></p>
                            <p class="escala0 bold mb-2">Papéis  </p>
                            <p class="escala1 bold mb-0"><span class="onipink">R$ </span><?php echo number_format($folha['reembolsos'],2,",",".");?></p>
                            <p class="escala0 bold mb-2">Reembolsos  </p>
                            <?php
                            if($folha['descricao_reembolsos']){
                                foreach($folha['descricao_reembolsos'] as $descricao_reembolso){
                                    ?>
                                    <p class="escala-2 mb-0"> <?php echo $descricao_reembolso;?> </p>
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




<input class="btn btn-danger escala3" name="form_action[Filtrar]" type="submit" value="Simular" style="position:fixed; bottom:3rem; left:3rem; width:45%; height:3rem;">
</form>

<form method="post" action="" >

<input class="btn btn-info escala3" name="form_action[Reset]" type="submit" value="Resetar dados"  style="position:fixed; bottom:3rem; right:3rem ;width:45%; height:3rem;">
</form>
<?php get_footer(); ?>