<?php get_header(); 
$boards_alterados = get_transient('boards_alterados');

$onis = get_transient('onis');
$Contents =  get_transient('boards');
$usuario_logado = wp_get_current_user();

    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    if($usuario_logado->display_name == $curauth->data->display_name || current_user_can('administrator')){
        $args = array (
            'post_type'              => array( 'pagamentos' ),
            'post_status'            => array( 'publish' ),
            'nopaging'               => true,
            'posts_per_page'	=> -1,
            'meta_key'			=> 'data', 
            'orderby'			=> 'meta_value',
            'order'				=> 'DESC',
            's' => $curauth->data->display_name
        );


        $pagamentos = new WP_Query( $args );
        ?>
        <div class='grid-x grid-padding-x  '>
            <div class='cell large-5 ' >
   
                <div class='card-filtro' style='width:100%'>
             
                    <form method="post" action="" class='grid-x grid-padding-x  ' style=' display: flex;  align-items: center;  justify-content: center;'>
                    <h3 class='cell large-4 escala0'>Período </h3>
           
                    <select class='cell large-8' id="seleciona-semana" name="data" onchange="showHideInput(this)">
                        <?php 
                            if ( $pagamentos->have_posts() ) {
                                $x = 0;
                                while ( $pagamentos->have_posts() ) { 
                                    
                                    $pagamentos->the_post();
                                    $titulo_completo = get_the_title();
                                    $data_string = explode( " | ", $titulo_completo);                             
                                    $data_pagamento = strtotime( $data_string[1]);
                                    
                                    if (!empty($_POST['form_action'])){
                                        
                                        $data_pagamento_string = $_POST['data'];
                                        if($data_pagamento_string == $data_string[1]){
                                            echo "<option value='".$data_string[1]."' selected>".$data_string[1]."</option>";
                                        }else{
                                            echo "<option value='".$data_string[1]."'>".$data_string[1]."</option>";
                                        }
                                        
                                    } else {
                                        if($x == 0){
                                            $data_pagamento_string = $data_string[1];
                                        }
                                        
                                        echo "<option value='".$data_string[1]."'>".$data_string[1]."</option>";
                                    }
                                    
                                    $x++;    
                                }
                            }
                            
                            foreach($semanas as $semana){
                            };
                        ?>
                    </select>
                    <input class='cell large-4 large-offset-1 escala0' name="form_action[Filtrar]" type="submit" value="Filtrar">
                    </form>
                  
                </div>
            </div>
    </div>
        <?php
echo "<div class='grid-x grid-padding-x  '>";
    echo "<div class='cell large-5 petro ' >";
        echo "<div class='card ' style='width:100%;'>";
            echo "<h3 class='escala4'> ".$curauth->data->display_name." <img style='border-radius:70px;  ' width='75' title='".$onis['nome']."' src='".$onis['foto']."'/></h3>";
            echo "<hr style='border-top: 8px solid #dd1e42 !important; width:40%; margin-left:0;'>";
            echo "<p class='escala0'><strong class='petro'>Email : </strong>".$curauth->data->user_email."</p>";
            echo "<p class='escala0'><strong class='petro'>Cel : </strong>".get_field('celular', 'user_'. $curauth->data->ID )."</p>";
            echo "<p class='escala0'><strong class='petro'>Oni desde : </strong>".get_field('data_de_inicio_na_oni', 'user_'. $curauth->data->ID )."</p>";
            echo "<p class='escala0'><strong class='petro'>Aniversário : </strong>".get_field('aniversario', 'user_'. $curauth->data->ID )."</p>";
            echo "<div class='espacador_ppp'>";
            echo "</div>";
        echo "</div>";
        /*
        echo "<div  class='card btn' onclick='filterSelection(\"produtividade\", this)'  style='width:100%;' >";
            echo "<p class='escala2 bold'>Produtividade</p>";
        echo "</div>";
        */
        echo "<div  class='card btn active' onclick='filterSelection(\"papeis\", this)'  style='width:100%;' >";
            echo "<p class='escala2 bold'>Papéis & competências</p>";
        echo "</div>";
        echo "<div  class='card btn' onclick='filterSelection(\"evolucao\", this)'  style='width:100%;' >";
            echo "<p class='escala2 bold'>Evolução</p>";
        echo "</div>";
        echo "<div  class='card btn' onclick='filterSelection(\"recibo\", this)'  style='width:100%;' >";
            echo "<p class='escala2 bold'>Recibo</p>";
        echo "</div>";
    echo "</div>";

    $equivalencia_status_guardas = array(
        "Fez" => 'feita-back',
        "Falhou" => 'falhou-back',
        "Não precisou" => 'nao_planejada-back'
    
    );
    $equivalencia_guardas = array(
        "Fez" => '',
        "Falhou" => 'falhou',
        "Não precisou" => ''
    
    );

    /*********************** RECIBO ***************************    */
    
    echo "<div class='filterDiv show recibo  cell large-13' style='margin-bottom:2em;' >";
        echo "<div class='grid-x  grid-margin-x ' style='align-items:flex-start'>";
            echo "<div class=' cell large-12 '>";
            if ( $pagamentos->have_posts() ) {
                
                while ( $pagamentos->have_posts() ) { 
                    $pagamentos->the_post();
                    $titulo_completo = get_the_title();
                    $data_string = explode( " | ", $titulo_completo);
                    $data_pagamento = strtotime( $data_string[1]);
                    $data_extenso = date_i18n("F Y", $data_pagamento);
                    $id = get_the_ID();
                    $fields = get_fields($id);

                    if($data_pagamento_string == $data_string[1]){
  
                        echo "<div class='grid-x grid-padding-x grid-margin-x '>";
           
                        if(is_array($fields['explicacoes_descontos'])){
                            foreach($fields['explicacoes_descontos'] as $explicacao_advertencia){
                                
                            
                                echo "<div class='card cell large-18 '>";
                                    echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                        echo "<div class=' cell large-2 '>";
                                            echo "<img style='width:64px; height:64px;max-width: inherit !important; ' src='https://bi.oni.com.br/wp-content/themes/oni/img/frowning_face.gif'/>";
                                        echo "</div>";
                                        echo "<p class='escala0 cell large-16'><strong class='pink'>Falha grave <span style='float:right;'>Ø - 1</span></strong> </p>";
                                        
                                                echo "<p class='escala-1 grey cell large-offset-2 large-16'>".$explicacao_advertencia['explicacao_advertencia']."</p>";
                                                
                                        
                                    echo "</div>";
                                    
                                    
                                echo "</div>";   
                            }
        
                        } 
                        

                                $primeiro = false;
                        if(is_array($fields['guardas_explicacao'])){ 
                            foreach($fields['guardas_explicacao'] as $guarda ){
                                echo "<div class='card cell large-18 '>";
                                    echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                        echo "<p class='escala0 cell large-18  '><strong class='pink'>Guarda | </strong>".$guarda['projeto']."<span style='float:right;'><strong class='pink'>Ø <span class='petro'>".$guarda['onions']." de 5 </span></strong></span> </p>";
                                    echo "</div>";   
                                    echo "<hr>"; 
                                    echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['cu_na_reta']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['cu_na_reta']]." '>  Cu na reta</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['suporte_estrategico_aos_envolvidos']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['suporte_estrategico_aos_envolvidos']]." '>  Suporte estratégico aos envolvidos</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";  
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['forecast_gestao_estrategica']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['forecast_gestao_estrategica']]." '>  Forecast (gestão estratégica)</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['definir_passos_e_seus_escopos_gestao_tatica']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['definir_passos_e_seus_escopos_gestao_tatica']]." '>  Definir passos e seus escopos (gestão tática)</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['ritmo_de_projeto_e_entrega_de_valor']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['ritmo_de_projeto_e_entrega_de_valor']]." '>  Ritmo de projeto e entrega de valor</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['escolher_e_gerir_equipe_de_projeto']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['escolher_e_gerir_equipe_de_projeto']]." '>  Escolher e gerir equipe de projeto</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['gerir_missoes_gestao_operacional']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['gerir_missoes_gestao_operacional']]." '>  Gerir missões (gestão operacional)</p>";
                                        echo "</div>";
                                        echo "<div class='cell large-9'>";
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_status_guardas[$guarda['comunicacao_de_projeto_com_cliente']]."'></p>";
                                            echo "<p class='escala-1 tira-entrelinha ".$equivalencia_guardas[$guarda['comunicacao_de_projeto_com_cliente']]." '>  Comunicação de projeto com cliente</p>";
                                        echo "</div>";
                                        echo "<div class='espacador_pp'></div>";
                                    echo "</div>";
                                        
                                    if($guarda['justificativas']){
                                        echo "<hr>"; 
                                        echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                            echo "<div class='cell large-18'>";
                                                echo "<p class='escala0 cell large-18  '><strong class='pink'>Justificativas </strong></p>";
                                                echo "<pre class='escala-1 grey '>".$guarda['justificativas']."</pre>";
                                            echo "</div>";

                                        echo "</div>";
                                    }
                                    

                                echo "</div>";

                            }
                        }
                        echo "</div>";
                    }

                
                } 
            } 
            echo "</div>";
            //BLOCO DE RECIBO DA DIREITA
            echo "<div class='card-missao  cell large-6'>";
                if ( $pagamentos->have_posts() ) {
                    
                    while ( $pagamentos->have_posts() ) { 
                        $pagamentos->the_post();
                        $titulo_completo = get_the_title();
                        $data_string = explode( " | ", $titulo_completo);
                        $data_pagamento = strtotime( $data_string[1]);
                        $data_referencia = strtotime( "next month",$data_pagamento);
                        $data_extenso = date_i18n("F Y", $data_pagamento);
                        $data_referencia_extenso = date_i18n("F Y", $data_referencia);
                        $id = get_the_ID();
                        $fields = get_fields($id);
                        if($data_pagamento_string == $data_string[1]){
                            echo "<h3 class='escala2'> Recibo</h3>";
                            echo "<p class='escala-1'>Referência: <strong class='pink escala1'>".$data_extenso."</strong></p>";
                            echo "<p class='escala-1'>Pagamento: <strong class='pink escala1'>".$data_referencia_extenso."</strong></p>";
                            echo "<hr>";
                            echo "<p class='escala3' style='margin-bottom:-0.5rem'><strong class='petro'><span class='pink'>R$ </span>".number_format($fields['valor_do_onion'], 2, ',','.')."</strong></p>";
                            echo "<p class='escala0'><strong class='petro'>Valor do Onion</strong></p>";

                            echo "<p class='escala3' style='margin-bottom:-0.5rem'><strong class='petro'><span class='pink'>Ø </span>".$fields['total_de_onions']."</strong></p>";
                            echo "<p class='escala0'><strong class='petro'>Total de Onions</strong></p>";
                            echo "<p class='escala-1'>Guardas : ".$fields['guardas']."</p>";
                            echo "<p class='escala-1'>Mãos direitas : ".$fields['maos_direitas']."</p>";
                            echo "<p class='escala-1'>Onions de papéis : ".$fields['onions_de_envolvimento']."</p>";
                            echo "<p class='escala-1'>Onions de competências: ".$fields['onions_de_competencias']."</p>";
                            echo "<p class='escala-1'>Total de Onions: ".$fields['total_de_onions']."</p>"; 

                            echo "<p class='escala3' style='margin-bottom:-0.5rem'><strong class='petro'><span class='pink'>Ø </span>".number_format($fields['onions_descontados'], 2, ',','.')."</strong></p>";
                            echo "<p class='escala0'><strong class='petro'>Descontos</strong></p>";
                            echo "<p class='escala-1'>Dias de ausência: ".$fields['dias_de_ausencia']."</p>";
                            echo "<p class='escala-1'>Dias de ausência nos últimos 3 meses : ".$fields['dias_de_ausencias_nos_3_meses_anteriores']."</p>";
                            echo "<p class='escala-1'>Onions descontados: ".$fields['onions_descontados']."</p>";
                         

                            echo "<p class='escala3' style='margin-bottom:-0.5rem'><strong class='petro'> <span class='pink'>R$</span> ".str_replace( '-','',number_format($fields['valor_reembolsos'], 2, ',','.'))."</strong></p>";
                            echo "<p class='escala0'><strong class='petro'>Total de Reembolsos</strong></p>";
                            echo "<p class='escala-1'>".str_replace( '-','',$fields['reembolsos'])."</p>";
                            
                            echo "<p class='escala3' style='margin-bottom:-0.5rem'><strong class='petro'><span class='pink'>R$</span> ".number_format($fields['remuneracao'], 2, ',','.')."</strong></p>";
                            echo "<p class='escala0'><strong class='petro'>Valor da NF-e</strong></p>"; 
                            echo "<p class='escala-1'>Competências : R$".number_format($fields['onions_de_competencias']*$fields['valor_do_onion'], 2, ',','.')."</p>";
                            echo "<p class='escala-1'>Papéis : R$".number_format($fields['onions_de_envolvimento']*$fields['valor_do_onion'], 2, ',','.')."</p>" ;                echo "<p class='escala-1'>Descontos : R$".number_format($fields['onions_descontados']*$fields['valor_do_onion'], 2, ',','.')."</p>" ; 
                            echo "<p class='escala-1'>Reembolsos : R$".str_replace( '-','',number_format($fields['valor_reembolsos'], 2, ',','.'))."</p>" ; 
                            
                            echo "<div class='espacador-pp'></div>";

                            $primeiro = false;
                        }

                    } 
                } 
            echo "</div>";
        echo "</div>";
    echo "</div>";

    /*********************** PAPEIS ***************************    */
    echo "<div class='filterDiv inicial show  papeis cell large-13' style='margin-bottom:2em;' >";
        if ( $pagamentos->have_posts() ) {
            $pulses_evidencia = puxa_board_por_titulo($Contents, "Evidências | ".$curauth->data->display_name);
                        
            while ( $pagamentos->have_posts() ) { 
                $pagamentos->the_post();
                $titulo_completo = get_the_title();
                $data_string = explode( " | ", $titulo_completo);
                $data_pagamento = strtotime( $data_string[1]);
                $data_extenso = date_i18n("F Y", $data_pagamento);
                $id = get_the_ID();
                $fields = get_fields($id);
                if($data_pagamento_string == $data_string[1]){
                echo "<div class='grid-x grid-margin-x  ' >";
                    echo "<div class=' cell large-12 '>";
                        echo "<div class='grid-x grid-padding-x grid-margin-x align-top'>";
                            echo "<div class='cell large-18 card'>";
                                echo "<div class='grid-x grid-padding-x grid-margin-x'>";
                                    echo "<h3 class='escala2 cell large-18'> Papéis </h3>";
                                    echo "<div class=' cell large-9  '>";                   
                                        echo "<p class='escala0 tira-entrelinha' style='margin-top:2rem'><strong class='pink'>Guardas</strong></p>";
                                        echo "<hr>";
                                        if ($fields['guardas_explicacao']){
                                            foreach ($fields['guardas_explicacao'] as $guarda) {
                                                echo "<p class='escala0 tira-entrelinha ' '>".$guarda['projeto']."</p>";
                                            }
                                        }
                                    echo "</div>";
                                    echo "<div class=' cell large-9  '>";
                                        echo "<p class='escala0 tira-entrelinha' style='margin-top:2rem'><strong class='pink'>Mãos direitas</strong></p>";          
                                        echo "<hr>";
                                    
                                    if ($fields['projetos_mao_direita']){
                                        foreach ($fields['projetos_mao_direita'] as $mao_direita) {
                                            echo "<p class='escala0 tira-entrelinha' '>".$mao_direita['projeto_mao_direita']."</p>";
                                        }
                                    }
                                    echo "</div>";
                                    echo "<div class='espacador_pp cell large-18'></div>";
                                echo "</div>"; 
                            echo "</div>";       
                        echo "</div>";

                     
                            echo "<div class='grid-x grid-padding-x grid-margin-x align-top'>";
                                echo "<div class='cell large-18 card'>";
                                    echo "<div class='grid-x grid-padding-x grid-margin-x' >";
                                        echo "<h3 class='cell large-18 escala2 '> Competências </h3>";
                                        echo "<div class='cell large-18' style='column-count: 2; column-gap: 4em;'>";
                                            
                                            if($fields['competencias']){
                                                foreach($fields['competencias'] as $competencia){
                   
                                                   
                                                    if($comp != $competencia['esfera'] && $comp !== NULL){
                                                        echo "</div>";
                                    
                                                    }
                        
                                                    if($comp != $competencia['esfera'] || $comp == NULL){
                                                        
                                                    echo "<div class=' ' style='break-inside: avoid; padding-top: 2em;'>";
                                
                                                        echo "<p class='escala0 tira-entrelinha'><strong class='pink'>".$competencia['esfera']."</strong></p>";
                                                        echo "<hr>";
                                                
                                                        }
                                                
                                                        echo "<div class='grid-x  '>";
                                                            echo  "<p class='escala0 tira-entrelinha cell large-10'>".$competencia['competencia']."</p>";
                                                            echo "<div class='cell large-8'>";
                                                                for ($i=1; $i <= 5 ; $i++) { 
                                                                    if($i <= $competencia['nivel'] ){
                                                                        echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal feita-back'></p>";  
                                                                    }else{
                                                                        echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal background_grey'></p>";
                                                                    }
                                                                    
                                                                }
                                                            echo "</div>";
                                                        echo "</div>";
                                                
                                                    
                                                    $comp = $competencia['esfera'];
                                                    
                                                }
                                            }else{
                                                echo "<div class='cell large-9 '>";
                                                    echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                                        echo "<p class='escala0 tira-entrelinha cell large-18' style='margin-top:2rem'><strong class='pink'>As competências desse mês não foram preenchidas no monday </strong></p>";                               
                                                    echo "</div>";
                                                echo "</div>";
                                            }
                                            echo "</div>";
                                            echo "<div class=' cell large-18 espacador_pp'></div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            $primeiro = false;
                        }
                    } 
                } 
        echo "</div>";


        echo "<div class=' cell large-6 card '>";
            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                echo "<h3 class='escala2 cell large-18'> Metaprograma </h3>";
                $metaprograma = get_fields('user_'. $curauth->data->ID );
            echo "</div>";


            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                echo "<p class='escala0 tira-entrelinha cell large-18' style='margin-top:2rem'><strong class='pink'>Motivação</strong></p>";
            echo "</div>";
            echo "<hr>";

            echo "<div class='grid-x grid-padding-x grid-margin-x '>";             

                echo "<div class=' cell large-18 '>";
                    echo "<p class='escala0 tira-entrelinha '>".$metaprograma['motivacao1']."</p>";
                echo "</div>";

                echo "<div class=' cell large-18 '>";
                    echo "<p class='escala0 tira-entrelinha '>".$metaprograma['motivacao2']."</p>";
                echo "</div>";

                echo "<div class=' cell large-18 '>";
                    echo "<p class='escala0 tira-entrelinha '>".$metaprograma['motivacao3']."</p>";
                echo "</div>";

            echo "</div>";

            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                echo "<p class='escala0 tira-entrelinha cell large-18' style='margin-top:2rem'><strong class='pink'>Convencimento</strong></p>";
            echo "</div>";
            echo "<hr>";

            echo "<div class='grid-x grid-padding-x grid-margin-x '>";             

                echo "<div class=' cell large-18 '>";
                    echo "<p class='escala0 tira-entrelinha '>".$metaprograma['convencimento1']."</p>";
                echo "</div>";

                echo "<div class=' cell large-18 '>";
                    echo "<p class='escala0 tira-entrelinha '>".$metaprograma['convencimento2']."</p>";
                echo "</div>";

     

            echo "</div>";
            
            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                echo "<p class='escala0 tira-entrelinha cell large-18' style='margin-top:2rem'><strong class='pink'>Decisão</strong></p>";
            echo "</div>";
            echo "<hr>";
            echo "<div class='espacador_ppp'></div>";
            echo "<div class='grid-x grid-padding-x grid-margin-x '>";             
                $decisao1 =  round((float)$metaprograma['decisao1'] * 100 ) . '%';
                echo "<div class=' cell large-18 '>";
                    echo "<div class='grid-x grid-margin-x '>";
                        echo "<span class='cell large-4'>Proativo</span>";
                        echo "<div class='meta-bar  large-10'>";
                            echo "<div class='andamento' style='width:".$decisao1.";  background-color: #ed1843; '></div>" ;
                        echo "</div>";
                        echo "<span class='cell large-4'>Reativo</span>";
                    echo "</div>";
                echo "</div>";
                $decisao2 =  round((float)$metaprograma['decisao2'] * 100 ) . '%';
                echo "<div class=' cell large-18 '>";
                    echo "<div class='grid-x grid-margin-x ' style='margin-top: 1em;'>";
                        echo "<span class='cell large-4'>Mesmo</span>";
                        echo "<div class='meta-bar  large-10'>";
                            echo "<div class='andamento' style='width:".$decisao2.";  background-color: #ed1843; '></div>" ;
                        echo "</div>";
                        echo "<span class='cell large-4'>Diferente</span>";
                    echo "</div>";
                echo "</div>";
                $decisao3 =  round((float)$metaprograma['decisao3'] * 100 ) . '%';
                echo "<div class=' cell large-18 '>";
                    echo "<div class='grid-x grid-margin-x ' style='margin-top: 1em;'>";
                        echo "<span class='cell large-4'>Opções</span>";
                        echo "<div class='meta-bar  large-10'>";
                            echo "<div class='andamento' style='width:".$decisao3.";  background-color: #ed1843; '></div>" ;
                        echo "</div>";
                        echo "<span class='cell large-4'>Procedimento</span>";
                    echo "</div>";
                echo "</div>";
                echo "<div class=' cell large-18 '>";
                    echo "<div class='grid-x grid-margin-x '  style='margin-top: 1em;'>";
                    $decisaoespecifico =  10-$metaprograma['decisao-especifico'] . '0%';
                        echo "<span class='cell large-4' style='text-align:center;'>";
                        echo "<div class='column-bar  large-18' style='background-color: #ed1843;'>";
                            echo "<div style='height:".$decisaoespecifico.";  background-color: #f1f1f1; '></div>" ;
                        echo "</div>";
                        echo "Especifico</span>";

                        $decisaoespecificoglobal =  10-$metaprograma['decisao-especifico-global'] . '0%';
                        echo "<span class='cell large-5' style='text-align:center;'>";
                        echo "<div class='column-bar  large-18' style='background-color: #ed1843;'>";
                            echo "<div style='height:".$decisaoespecificoglobal.";  background-color: #f1f1f1; '></div>" ;
                        echo "</div>";
                        echo "Específico Global</span>";

                        $decisaoglobalespecifico =  10-$metaprograma['decisao-global-especifico'] . '0%';
                        echo "<span class='cell large-5' style='text-align:center;'>";
                        echo "<div class='column-bar  large-18' style='background-color: #ed1843;'>";
                            echo "<div style='height:".$decisaoglobalespecifico.";  background-color: #f1f1f1; '></div>" ;
                        echo "</div>";
                        echo "Global Específico</span>";

                        $decisaoglobal =  10-$metaprograma['decisao-global'] . '0%';
                        echo "<span class='cell large-4' style='text-align:center;'>";
                        echo "<div class='column-bar  large-18' style='background-color: #ed1843;'>";
                            echo "<div style='height:".$decisaoglobal.";  background-color: #f1f1f1; '></div>" ;
                        echo "</div>";
                        echo "Global</span>";
                    
                    echo "</div>";
                echo "</div>";
            echo "</div>";
            echo "<div class='espacador_ppp'></div>";
        echo "</div>";
    echo "</div>";
    echo "</div>";

    /*********************** EVOLUCAO ***************************    */
    $equivalencia_evidencias = array(
        "Sim" => 'feita-back',
        "Não" => 'nao_feita-back',
        "Onion up+" => 'onion_up-back',
        "Precisa de mais info" => 'mais_info-back',
    
    );
    

    $evidencias = array();
    echo "<div class='filterDiv show  evolucao  cell large-13' style='margin-bottom:2em;' >";
        echo "<div class='grid-x  grid-margin-x ' style='align-items:flex-start'>";
            if ( $pagamentos->have_posts() ) {
            
                while ( $pagamentos->have_posts() ) { 
                    $evidencia_sim = 0;
                    $evidencia_nao = 0;
                    $evidencia_up = 0;
                    $pagamentos->the_post();
                    $titulo_completo = get_the_title();
                    $data_string = explode( " | ", $titulo_completo);
                    $data_pagamento = strtotime( $data_string[1]);
                    $data_extenso = date_i18n("F Y", $data_pagamento);
                    $id = get_the_ID();
                    $fields = get_fields($id); 
                    if($data_pagamento_string == $data_string[1]){
                        echo "<div class=' cell large-12  '>";
                            foreach($pulses_evidencia as $evidencia){
                                if($evidencia['column_values'][4]['text'] == "Onion up+" && substr($evidencia['column_values'][1]['text'], 0, -3) == $data_pagamento_string){
                                    echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                        echo "<div class='card cell large-18 '>";
                                            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                                echo "<div class=' cell large-3 '>";
                                                    echo "<img style='width:128px; height:128x;max-width: inherit !important; ' src='https://bi.oni.com.br/wp-content/themes/oni/img/beaming_face_with_smiling_eyes.gif'/>";
                                                echo "</div>";
                                                echo "<div class=' cell large-15 '>";
                                                    echo "<p class='escala2 tira-entrelinha'><strong class='petro'>Parabéns</strong> </p>";
                                                    $id_nivel = array_search($evidencia['column_values'][0]['text'], array_column($fields['competencias'], 'competencia'));
                                                    echo "<p class='escala0 aumenta-entrelinha'>Você evoluiu na trilha de <span class='pink bold'>".$evidencia['column_values'][0]['text']."</span>, alcançando o <span class='pink bold'> nível ".$fields['competencias'][$id_nivel]['nivel']."</span> da competência! Continue assim e vamos trabalhar muito tempo juntos! </p>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";   
                                    echo "</div>";    
                                }           
                            };
                            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                echo "<div  class='cell large-18 card' >";  
                                    echo "<h3 class='escala2'> Histórico de evidências </h3>";
                                     echo "<div id='historico-evidencias'  style='position: relative; height:350px;'></div>";
                                     echo "<div class='espacador_pp'></div>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                echo "<div  class='cell large-18 card'>";  
                                    echo "<h3 class='escala2'> Histórico de onions </h3>";
                                    echo "<div id='historico'  style='position: relative; height:350px;'></div>";
                                    echo "<div class='espacador_pp'></div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        

                        echo "<div class=' cell large-6 card '>";
                            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                echo "<h3 class='escala2 cell large-18'> Evidências de ".$data_pagamento_string." </h3>";
                            echo "</div>";

                        foreach($fields['competencias'] as $competencia){
          
                            if($comp != $competencia['esfera']){
                            $comp = $competencia['esfera'];
                            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                echo "<p class='escala0 tira-entrelinha cell large-18' style='margin-top:2rem'><strong class='pink'>".$competencia['esfera']."</strong></p>";
                                
                            echo "</div>";
                            echo "<hr>";
                            }
                            echo "<div class='grid-x grid-padding-x grid-margin-x '>";
                                echo  "<p class='escala0 tira-entrelinha cell large-10'>".$competencia['competencia']."</p>";
                                echo "<div class='cell large-8'>";
                                $conta_evidencias = 0;
                                foreach($pulses_evidencia as $evidencia){

                                    if($evidencia['column_values'][0]['text'] == $competencia['competencia'] && substr($evidencia['column_values'][1]['text'], 0, -3) == $fields['data'] ){
                
                                        $evidencias[$competencia['esfera']][$evidencia['id']] = array(
                                            'competencia' => $competencia['competencia'],
                                            'status' => $evidencia['column_values'][4]['text']
                                        );
                                
                                        
                                        if($evidencias[$competencia['esfera']][$evidencia['id']]['status'] ){
                                
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_evidencias[$evidencias[$competencia['esfera']][$evidencia['id']]['status']]."'></p>";
                                            if($evidencias[$competencia['esfera']][$evidencia['id']]['status'] == "Sim"){
                                                $evidencia_sim++;
                                            }elseif($evidencias[$competencia['esfera']][$evidencia['id']]['status'] == "Não"){
                                                $evidencia_nao++;
                                            }elseif($evidencias[$competencia['esfera']][$evidencia['id']]['status'] == "Onion up+"){
                                                $evidencia_up++;
                                            }elseif($evidencias[$competencia['esfera']][$evidencia['id']]['status'] == "Onion down-"){
                                                $evidencia_down++;
                                            }
                                     
                                            
                                        }else{
                                            echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal background_grey'></p>";
                                        }
                                        $conta_evidencias++;
                                    }elseif($evidencia['column_values'][0]['text'] == $competencia['esfera'] && substr($evidencia['column_values'][1]['text'], 0, -3) == $fields['data'] ){
                                        echo "<p style='float:left;' class='escala-1 tira-entrelinha sinal ".$equivalencia_evidencias[$evidencia['column_values'][4]['text']]."'></p>";
                                        if($evidencia['column_values'][4]['text'] == "Sim"){
                                            $evidencia_sim++;
                                        }elseif($evidencia['column_values'][4]['text'] == "Não"){
                                            $evidencia_nao++;
                                        }elseif($evidencia['column_values'][4]['text'] == "Onion up+"){
                                            $evidencia_up++;
                                        }elseif($evidencias[$competencia['esfera']][$evidencia['id']]['status'] == "Onion down-"){
                                            $evidencia_down++;
                                        }  
                                        $conta_evidencias++; 
                                    }
                                    
                                };
                                
                                if($conta_evidencias == 0  ){
                                    echo "<p style='float:left;' class='escala-1 bold'>—</p>";
                                }
                               
                                    
                           
                                echo "</div>";
                            echo "</div>";
                            
                        }
                        echo "<div class='espacador_pp'></div>";
                        
                        echo "</div>";
                        $historico_evidencias_up[] = array("label" => $fields['data'], "y"=>$evidencia_up);
                        $historico_evidencias_sim[] = array("label" => $fields['data'], "y"=>$evidencia_sim);
                        $historico_evidencias_nao[] = array("label" => $fields['data'], "y"=>$evidencia_nao);
                    }else{
                        $conta_evidencias = 0;
                        
                        foreach($pulses_evidencia as $evidencia){
                        
                            if(substr($evidencia['column_values'][1]['text'], 0, -3) == $fields['data']){
                                
                                
                                if($evidencia['column_values'][4]['text'] ){
                                    if($evidencia['column_values'][4]['text'] == "Sim"){
                                        $evidencia_sim++;
                                    }elseif($evidencia['column_values'][4]['text'] == "Não"){
                                        $evidencia_nao++;
                                    }elseif($evidencia['column_values'][4]['text'] == "Onion up+"){
                                        $evidencia_up++;
                                    }
                                $conta_evidencias++;
                                }
                            }
                        }
                        $historico_evidencias_up[] = array("label" => $fields['data'], "y"=>$evidencia_up);
                        $historico_evidencias_sim[] = array("label" => $fields['data'], "y"=>$evidencia_sim);
                        $historico_evidencias_nao[] = array("label" => $fields['data'], "y"=>$evidencia_nao);
                    }

                    




                    $historico_onions[] = array( "label" => $fields['data'], "y"=>$fields['total_de_onions'], "markerType" => 'none', 'indexLabel' => null); 
                    $historico_competencias[] = array( "label" => $fields['data'], "y"=>$fields['onions_de_competencias'], "markerType" => 'none', 'indexLabel' => null ); 
                    $historico_envolvimento[] = array( "label" => $fields['data'], "y"=>$fields['onions_de_envolvimento'], "markerType" => 'none', 'indexLabel' => null ); 

                } 
            
            } 
        

    echo "</div>";
    echo "</div>";
    
    };
echo "</div>";

$historico_onions[current(array_keys($historico_onions))]['markerType'] = 'circle';
$historico_onions[current(array_keys($historico_onions))]['indexLabel'] = '{y}';
$historico_competencias[current(array_keys($historico_competencias))]['markerType'] = 'circle';
$historico_competencias[current(array_keys($historico_competencias))]['indexLabel'] = '{y}';
$historico_envolvimento[current(array_keys($historico_envolvimento))]['markerType'] = 'circle';
$historico_envolvimento[current(array_keys($historico_envolvimento))]['indexLabel'] = '{y}';


?>


<script>

window.addEventListener('load',function () {
   
var historico = new CanvasJS.Chart('historico', {
animationEnabled: true,
theme: "light2", // "light1", "light2", "dark1", "dark2"
options: {
    maintainAspectRatio: true,
},
title: {

},
axisX:{
    labelAngle: 0,
    interval: 1,
    intervalType: "month",
    
},
axisY: {
    //title: "Onions",
    maximum: 100,
    includeZero: true,

    
},
data: [{
    type: "spline",
    name: "Total de Onions",
    showInLegend: true, 
    color: "rgba(200,200,200,.7)",
    toolTipContent: "{name}: <strong>{y}</strong> ",   
    //indexLabel: " {y}",
    dataPoints: <?php echo json_encode(array_reverse($historico_onions), JSON_NUMERIC_CHECK); ?>
},

{
    type: "spline",
    name: "Onions de competências",
    showInLegend: true, 
    toolTipContent: " {name}: <strong>{y}</strong>",   
    //indexLabel: " {y}",
    dataPoints: <?php echo json_encode(array_reverse($historico_competencias), JSON_NUMERIC_CHECK); ?>
},
{
    type: "spline",
    name: "Onions de envolvimento",
    
    showInLegend: true, 
    toolTipContent: " {name}: <strong>{y}</strong> ",   
    //indexLabel: " {y}",
    dataPoints: <?php echo json_encode(array_reverse($historico_envolvimento), JSON_NUMERIC_CHECK); ?>
}]

});
historico.render();


var historicoevidencia = new CanvasJS.Chart('historico-evidencias', {
animationEnabled: true,
theme: "light2", // "light1", "light2", "dark1", "dark2"
dataPointWidth: 40,
options: {
    maintainAspectRatio: false,
    
},
title: {

},
axisX:{
    labelAngle: 0,
    interval: 1,
    intervalType: "month",
},
axisY: {
    //title: "Onions",
    maximum: 15,
    includeZero: true,

    
},
data: [{
    type: "column",
    name: "Onion up",
    showInLegend: true, 
    color: "#ff5ac4",
    toolTipContent: "{name}: <strong>{y}</strong> ",   
    //indexLabel: " {y}",
    dataPoints: <?php echo json_encode(array_reverse($historico_evidencias_up), JSON_NUMERIC_CHECK); ?>
},

{
    type: "column",
    name: "Sim",
    cornerRadius: 4,
    showInLegend: true, 
    color: "#00c875",
    toolTipContent: " {name}: <strong>{y}</strong>",   
    //indexLabel: " {y}",
    dataPoints: <?php echo json_encode(array_reverse($historico_evidencias_sim), JSON_NUMERIC_CHECK); ?>
},
{
    type: "column",
    name: "Não",
    
    showInLegend: true, 
    color: "#e2445c",
    toolTipContent: " {name}: <strong>{y}</strong> ",   
    //indexLabel: " {y}",
    dataPoints: <?php echo json_encode(array_reverse($historico_evidencias_nao), JSON_NUMERIC_CHECK); ?>
}]

});
historicoevidencia.render();


var x, i;

x = document.getElementsByClassName("filterDiv");

  for (i = 0; i < x.length; i++) {
    if (x[i].className.indexOf('inicial') > -1) {
    }else{
        w3RemoveClass(x[i], "show");  
    }

}


});
</script>


<script>





function filterSelection(c,z) {
    console.log(c);
  var x, i;
  if (c == "all") c = "";
  x = document.getElementsByClassName("filterDiv");
  if (z.className.indexOf('active') > -1) {
    
    for (i = 0; i < x.length; i++) {
        w3AddClass(x[i], "show");
    }
    w3RemoveClass(z, "active");  
  }else{
    for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
    }
    var btns = document.getElementsByClassName("btn");
    for (b = 0; b < btns.length; b++) {     
        w3RemoveClass(btns[b], "active");
    }
    w3AddClass(z, "active");  
  }
  

}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<?php get_footer(); ?>