<?php
/*
* Processa Frentes
* Função de processamento de dados de frentes
*/

class processa_frentes{
    /**
    * Cadastra a frente vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function cadastraFrente($frentes,$id_projeto){
         // Puxando o id projeto no wordpress 
         $args = array(
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'post_type'		=> 'integracoes',
            'post_status'   => 'publish',
            'meta_key'		=> 'projeto_id_pipefy',
            'meta_value'	=> $id_projeto
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $id_projeto_wordpress = get_field('projeto_id_wordpress');
            $projeto_id_clickup = get_field('projeto_id_clickup');
            $nome_projeto = get_the_title($id_projeto_wordpress);
       endwhile;endif;
       wp_reset_query();
        foreach($frentes as $frente){
            $nome_da_frente = $frente['data']['table_record']['record_fields'][4]['value'];
            $data_de_inicio = $frente['data']['table_record']['record_fields'][1]['value'];
            $data_de_fim = $frente['data']['table_record']['record_fields'][0]['value'];
            $horas = $frente['data']['table_record']['record_fields'][3]['value'];
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];
            $guardiao =   $frente['data']['table_record']['record_fields'][2]['value'];
            // Vendo se já existe uma frente cadastrada com a id
            $args = array(
                'posts_per_page' => -1,
                'no_found_rows' => true,
                'post_type'		=> 'frentes',
                'post_status'   => 'publish',
                'meta_key'		=> 'id_da_frente_pipefy',
                'meta_value'	=> $id_da_frente_pipefy
            );
            $the_query = new WP_Query( $args );
            //Se tiver a frente ele altera em outra função
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                processa_papeis::atualizaPapelMetodo($nome_projeto,$nome_da_frente,$id_da_frente_pipefy,$guardiao, $data_de_inicio, $data_de_fim);
            endwhile;
            //Se não tiver frente ele cria uma nova
            else:
                $my_post = array(
                    'post_title' => $nome_da_frente,
                    'post_status' => 'publish',
                    'post_type' => 'frentes',
                );
                
                $post_id = wp_insert_post($my_post);              
                update_post_meta( $post_id, 'projeto', $id_projeto_wordpress );
                update_field('nome_da_frente', $nome_da_frente, $post_id);
                update_field('id_da_frente_pipefy', $id_da_frente_pipefy, $post_id);
                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_fim', $data_de_fim, $post_id);
                update_field('horas', $horas, $post_id);
                //Implementar função para pegar o id do usuário do clickup
                $guardiao = '3107782';
                //Processando as datas
                $data_de_inicio_obj = DateTime::createFromFormat('d/m/Y', $data_de_inicio);
                $data_de_inicio_ts = $data_de_inicio_obj->getTimestamp();
                $data_de_fim = DateTime::createFromFormat('d/m/Y', $data_de_fim);
                $data_de_fim = $data_de_fim->getTimestamp();
                $frente_id_clickup = clickup::clickCriaList($nome_da_frente,$data_de_inicio_ts,$data_de_fim,$guardiao, $projeto_id_clickup);
                update_field('id_da_frente_clickup', $frente_id_clickup, $post_id);
                set_transient('criamissoes',
                array(
                    $frente_id_clickup, $data_de_inicio_obj, $guardiao
                ));
                //Cria as missões de gestão NAO TESTADO
                clickup::clickMissoesGestao($frente_id_clickup, $data_de_inicio_obj, $guardiao);

            endif; 
            wp_reset_query();
        }
    } 
}

//Criando o objeto
$processa_frentes = new processa_frentes;


?>