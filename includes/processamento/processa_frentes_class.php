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
        //Setando o array que será retornado
        $frentes_cadastradas=array();
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
            //Busca a key dos record fields e retorna o nome da frente
            $key_nome_frente = array_search('Nome da frente', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_da_frente = $frente['data']['table_record']['record_fields'][$key_nome_frente]['value'];
            //Busca a key dos record fields e retorna a data de inicio
            $key_data_de_inicio = array_search('Data de início', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_inicio = $frente['data']['table_record']['record_fields'][$key_data_de_inicio]['value'];
            $data_de_inicio_ymd =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
            //Busca a key dos record fields e retorna a data de término
            $key_data_de_fim = array_search('Data de término', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_fim = $frente['data']['table_record']['record_fields'][$key_data_de_fim]['value'];
            $data_de_fim_ymd =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");
            //Busca a key dos record fields e retorna as horas
            $key_horas = array_search('Horas', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $horas = $frente['data']['table_record']['record_fields'][$key_horas]['value'];
            //Busca a key dos record fields e retorna o guardiao de método
            $key_guardiao = array_search('Guardião de método', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $guardiao =   $frente['data']['table_record']['record_fields'][$key_guardiao]['value'];
            //Pega o ID da frente
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];
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
                //processa_papeis::atualizaPapelMetodo($nome_projeto,$nome_da_frente,$id_da_frente_pipefy,$guardiao, $data_de_inicio, $data_de_fim);
            endwhile;
            //Se não tiver frente ele cria uma nova
            else:
                $my_post = array(
                    'post_title' => $nome_projeto.' | '.$nome_da_frente,
                    'post_status' => 'publish',
                    'post_type' => 'frentes',
                    'post_author' => 1
                );
                
                $post_id = wp_insert_post($my_post);              
                //update_post_meta( $post_id, 'projeto', $id_projeto_wordpress );
                update_field('field_6076de315f6c9', $id_projeto_wordpress, $post_id);
                update_field('nome_da_frente', $nome_da_frente, $post_id);
                update_field('id_da_frente_pipefy', $id_da_frente_pipefy, $post_id);
                update_field('data_de_inicio', $data_de_inicio_ymd, $post_id);
                update_field('data_de_fim', $data_de_fim_ymd, $post_id);
                update_field('horas', $horas, $post_id);
                //Processando as datas
                $data_de_inicio_obj = DateTimeImmutable::createFromFormat('d/m/Y', $data_de_inicio);
                $data_de_inicio_ts = $data_de_inicio_obj->getTimestamp();
                $data_de_fim_obj = DateTimeImmutable::createFromFormat('d/m/Y', $data_de_fim);
                $data_de_fim_ts = $data_de_fim_obj->getTimestamp();
                $frente_id_clickup = clickup::clickCriaList($nome_da_frente,$data_de_inicio_ts,$data_de_fim_ts,$guardiao, $horas,$projeto_id_clickup);

                update_field('id_da_frente_clickup', $frente_id_clickup, $post_id);
                
                $frentes_cadastradas[] = array(
                    $id_projeto_wordpress,$frente_id_clickup, $data_de_inicio_obj,$data_de_fim_obj, $guardiao
               );
  

            endif; 
            wp_reset_query();
        }
        set_transient('criamissoes',$frentes_cadastradas);
        return $frentes_cadastradas;
    } 


      /**
    * Altera as frentes vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function alteraFrente($frentes,$id_projeto){
   
        //Setando o array que será retornado
        $frentes_alteradas=array();
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
            //Busca a key dos record fields e retorna o nome da frente
            $key_nome_frente = array_search('Nome da frente', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_da_frente = $frente['data']['table_record']['record_fields'][$key_nome_frente]['value'];
            //Busca a key dos record fields e retorna a data de inicio
            $key_data_de_inicio = array_search('Data de início', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_inicio = $frente['data']['table_record']['record_fields'][$key_data_de_inicio]['value'];
            $data_de_inicio_ymd =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
            $data_de_inicio_obj =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio );
            //Busca a key dos record fields e retorna a data de término
            $key_data_de_fim = array_search('Data de término', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_fim = $frente['data']['table_record']['record_fields'][$key_data_de_fim]['value'];
            $data_de_fim_ymd =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");
            $data_de_fim_obj =  DateTime::createFromFormat('d/m/Y',  $data_de_fim );
            //Busca a key dos record fields e retorna as horas
            $key_horas = array_search('Horas', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $horas = $frente['data']['table_record']['record_fields'][$key_horas]['value'];
            //Busca a key dos record fields e retorna o guardiao de método
            $key_guardiao = array_search('Guardião de método', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $guardiao =   $frente['data']['table_record']['record_fields'][$key_guardiao]['value'];
            //Pega o ID da frente
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];
            //Pega o status da frente
            $status_da_frente =  $frente['data']['table_record']['status']['name'];
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
            //Se tiver a frente ele altera
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $frente_id_clickup = get_field('id_da_frente_clickup');
                $post_id = get_the_ID();
                $hoje_obj =  new DateTime('NOW');
                // Se a frente estiver desativada no pipefy e ainda não estiver começado ele deleta a frente no wp
                if($status_da_frente == "Concluído" && $data_de_inicio_obj > $hoje_obj){
                    wp_delete_post($post_id);
                }else{
                //Se a frente já tiver começado ele faz a atualização normal, independente de estar concluída ou não
                    update_field('nome_da_frente', $nome_da_frente, $post_id);
                    update_field('data_de_inicio', $data_de_inicio_ymd, $post_id);
                    update_field('data_de_fim', $data_de_fim_ymd, $post_id);
                    update_field('horas', $horas, $post_id);
                }

            endwhile;
            //Se não tiver frente ele cria uma nova
            else:
                if($status_da_frente == "Concluído"){
                }else{
                    $my_post = array(
                        'post_title' => $nome_projeto.' | '.$nome_da_frente,
                        'post_status' => 'publish',
                        'post_type' => 'frentes',
                        'post_author' => 1
                    );
                    
                    $post_id = wp_insert_post($my_post);              
                    //update_post_meta( $post_id, 'projeto', $id_projeto_wordpress );
                    update_field('field_6076de315f6c9', $id_projeto_wordpress, $post_id);
                    update_field('nome_da_frente', $nome_da_frente, $post_id);
                    update_field('id_da_frente_pipefy', $id_da_frente_pipefy, $post_id);
                    update_field('data_de_inicio', $data_de_inicio_ymd, $post_id);
                    update_field('data_de_fim', $data_de_fim_ymd, $post_id);
                    update_field('horas', $horas, $post_id);
                    //Processando as datas
                    $data_de_fim_obj = DateTimeImmutable::createFromFormat('d/m/Y', $data_de_fim);
                    $data_de_fim_ts = $data_de_fim_obj->getTimestamp();
                    $data_de_inicio_obj = DateTimeImmutable::createFromFormat('d/m/Y', $data_de_inicio);
                    $data_de_inicio_ts = $data_de_inicio_obj->getTimestamp();
                    $frente_id_clickup = clickup::clickCriaList($nome_da_frente,$data_de_inicio_ts,$data_de_fim_ts,$guardiao, $horas,$projeto_id_clickup);
                    //Fazer um altera list futuramente

                    update_field('id_da_frente_clickup', $frente_id_clickup, $post_id);
                }
            endif; 
            $frentes_alteradas[] = array(
                $id_projeto_wordpress, $frente_id_clickup, $data_de_inicio_obj, $data_de_fim_obj,$status_da_frente
           );
            wp_reset_query();
        }
        set_transient('alteramissoes',$frentes_alteradas);
        return $frentes_alteradas;
    } 
}

//Criando o objeto
$processa_frentes = new processa_frentes;


?>