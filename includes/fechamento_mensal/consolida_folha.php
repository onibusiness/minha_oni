<?php

/*
* Consolida a folha
*
*/
class consolida_folha{

    //disparando a classe
    public function __construct(){

    }

    

    /**
    * Consolida toda a folha
    *
    * @return Mixed Criando os posts de fechamento da Oni e de pagamento por oni
    *     
    */
    public function consolidaFolha($u_dia, $onis){
        if(count($this->alerts)< 0){
            # passar um alerta via Ajax de que existem problemas na folha
            echo "EXISTEM ALERTAS IMPEDINDO O FECHAMENTO";
            return;
        }else{
            if (!empty($_POST['form_action']['Salvar'])){              
                $ano_mes = substr($u_dia, 0 , 7);//setando o título do post
                //Fazendo a requisição dos pagametnos
                $args = array (
                    'post_type'              => array( 'pagamentos' ),
                    'post_status'            => array( 'publish' ),
                    'nopaging'               => true,
                    's' => $ano_mes
                );
                $pagamentos = new WP_Query( $args );
                //Se tiver posts salvos ele passa batido
                if ( $pagamentos->have_posts() ) {
                        #passar via Ajax
                        echo "já está salvo";
                } else {
                    foreach($onis as $nome_oni => $oni){
                        //Criando os posts pagamentos por Oni 
                        $my_post = array(
                            'post_title' => $nome_oni." | ".$ano_mes,
                            'post_status' => 'publish',
                            'post_type' => 'pagamentos',
                        );
                        
                        $post_id = wp_insert_post($my_post);
                        update_field('data', $ano_mes, $post_id);
                        update_field('oni', $oni['ID'], $post_id);
                        update_field('cargo', $oni['funcao'], $post_id);
                        update_field('competencias', $oni['competencias'], $post_id);
                        update_field('lentes', $oni['lentes'], $post_id);
                        update_field('guardas', $oni['guardas'], $post_id);
                        update_field('ferias_desconto_padrao', $oni['ferias_desconto_padrao'], $post_id);
                        update_field('ferias_desconto_total', $oni['ferias_desconto_total'], $post_id);
                        update_field('ferias_tres_meses', $oni['ferias_tres_meses'], $post_id);
                        update_field('advertencias', $oni['advertencias'], $post_id);
                        if(is_array($oni['explicacoes_advertencias'])){
                            update_field('explicacoes_advertencias', implode('</br>',$oni['explicacoes_advertencias']), $post_id);
                        }                        
                        update_field('onions_competencia', $oni['onions_competencia'], $post_id);
                        update_field('onions_lentes', $oni['onions_lentes'], $post_id);
                        update_field('onions_papeis', $oni['onions_papeis'], $post_id);
                        update_field('onions_ferias', $oni['onions_ferias'], $post_id);
                        update_field('onions', $oni['onions'], $post_id);
                        update_field('reembolsos', $oni['reembolsos'], $post_id);
                        if(is_array($oni['descricao_reembolsos'])){
                            update_field('descricao_reembolsos', implode('</br>',$oni['descricao_reembolsos']), $post_id);
                        }
                        update_field('remuneracao', $oni['remuneracao'], $post_id);
                        
                    }
                }
                echo "Folha consolidada";
                wp_reset_postdata();

                //Fazendo a requisição dos fechamentos mensais
                $args = array (
                    'post_type'              => array( 'fechamentos_mensais' ),
                    'post_status'            => array( 'publish' ),
                    'nopaging'               => true,
                    's' => $ano_mes
                );
                $pagamentos = new WP_Query( $args );
                //Se tiver posts salvos ele passa batido
                if ( $pagamentos->have_posts() ) {
                        #passar via Ajax
                        echo "já está salvo";
                } else {
                   
                    //Criando os posts pagamentos por Oni 
                    $my_post = array(
                        'post_title' => $ano_mes,
                        'post_status' => 'publish',
                        'post_type' => 'fechamentos_mensais',
                    );
                    
                    $post_id = wp_insert_post($my_post);
                    /*
                    update_field('data', $ano_mes, $post_id);
                    update_field('receitas', $this->receitas, $post_id);
                    update_field('despesas', $this->despesas, $post_id);
                    update_field('onions_competencia', $this->onions_competencia, $post_id);
                    update_field('onions_papeis', $this->onions_papeis, $post_id);
                    update_field('onions_ferias', $this->onions_ferias, $post_id);
                    update_field('onions_no_sistema', $this->onions_no_sistema, $post_id);
                    update_field('budget_folha', $this->budget_folha, $post_id);
                    update_field('valor_do_onion', $this->valor_do_onion, $post_id);
                    */
                    echo "Fechamento mensal consolidado";
                }
                
                wp_reset_postdata();
            } 
        }
    }

    
}

//Criando o objeto
$consolida_folha = new consolida_folha;

?>