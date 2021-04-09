<?php $historico = new historico;
            $ultimo_mes = end($historico->seis_meses);
            ?> 
            <!-- Barra de botões de meses controlando as linhas debaixo via collapse -->
            <div class="atomic_card background_white" id="acordiao">
                <div class="row">
                    <p class=" col-12 escala1 bold">Seu histórico de onions e competências: </p>
                    <div class="col-12 d-flex flex-wrap ">
                        <?php foreach($historico->seis_meses as $mes){
                             $expandido = 'false';
                             if($mes == $ultimo_mes){
                                 $expandido = "true";
                             }
                            ?>
                            <p>
                                <div class="taboni  target_js" data-toggle="collapse" data-target="<?php echo '#'.$mes['classe'];?>" aria-expanded="<?php echo $expandido;?>" aria-controls="<?php echo $mes['classe'];?>"><?php echo $mes['data'];?></div>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <?php 
                    $historico_pagamentos = $historico->pegaHistoricoPagamento($profile_id);
                    foreach($historico->seis_meses as $mes){
                        $mostrar = '';
                        if($mes == $ultimo_mes){
                            $mostrar = "show";
                        }
                        ?>
                        <!-- Uma row para cada mês de histórico -->
                        <div class="col-12 col-md-12 row collapse target_js pl-4 pt-4 <?php echo $mostrar;?>" id="<?php echo $mes['classe'];?>" data-parent="#acordiao">
                            <?php
                            if($historico_pagamentos[$mes['classe']]){
                                ?>
                                <!-- Coluna da esquerda  -->
                                <div class="col-12 col-lg-4">
                                    <!-- Card de remuneração  -->
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="escala3 bold grey mb-0"> <span class="onipink">Ø</span> <?php echo $historico_pagamentos[$mes['classe']]['onions_competencia'];?></p>
                                            <p class="escala0 bold mb-1 pb-1">Onions de competencia</p>

                                            <p class="escala3 bold grey mb-0"> <span class="onipink">Ø</span> <?php echo +$historico_pagamentos[$mes['classe']]['onions_papeis'];?></p>
                                            <p class="escala0 bold mb-4 pb-4">Onions de papéis</p>

                                            <p class="escala3 bold mb-0"> <span class="onipink">Ø</span> <?php echo $historico_pagamentos[$mes['classe']]['onions_competencia']+$historico_pagamentos[$mes['classe']]['onions_papeis'];?></p>
                                            <p class="escala0 bold mb-1 pb-1">Total de onions</p>

                                            <p class="escala3 bold mb-0"> <span class="onipink">R$</span> <?php echo $historico_pagamentos[$mes['classe']]['remuneracao'];?></p>
                                            <p class="escala0 bold mb-4 pb-4">Valor da NF-e</p>

                                        
                                        </div>
                                    </div> 
                                    <!-- Card de guardas  -->
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="escala0 bold onipink">Guardião de:</p>
                                            <?php
                                            if($historico_pagamentos[$mes['classe']]['guardas']){
                                                foreach($historico_pagamentos[$mes['classe']]['guardas'] as $guarda){
                                                
                                                    ?>
                                                <p class="escala-1"><?php echo $titulo_guardas['choices'][$guarda['papel']]." de ".$guarda['projeto']['post_title']?> </p>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>         
                                </div>
                                <!-- Coluna da direita  -->
                                <div class="col-12 col-lg-8">
                           
                                    <!-- Card de competências  -->
                                    <div class="col-12 px-0">
                                        <?php
                                        
                                        include(get_stylesheet_directory() . '/template-parts/user-lentes-historico.php');
                                        ?>
                                    </div>
                                    <div class="col-12 px-0 duas-colunas" style="column-gap: 2em;">
                                            <?php
                                            
                                        include(get_stylesheet_directory() . '/template-parts/user-competencias-historico.php');
                                        ?>
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