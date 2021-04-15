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
       endwhile;endif;

        foreach($frentes as $frente){
            $nome_da_frente = $frente['data']['table_record']['record_fields'][4]['value'];
            $data_de_inicio = $frente['data']['table_record']['record_fields'][1]['value'];
            $data_de_fim = $frente['data']['table_record']['record_fields'][0]['value'];
            $horas = $frente['data']['table_record']['record_fields'][3]['value'];
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
            //Se tiver a frente ele altera
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();

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
                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_fim', $data_de_fim, $post_id);
                update_field('horas', $horas, $post_id);
            endif; 
            wp_reset_query();
        }
    } 
}

//Criando o objeto
$processa_frentes = new processa_frentes;


?>