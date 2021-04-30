<?php
/*
* Processa Papeis
* Função de papéis filtrados por oni
*/

class processa_papeis{
    /**
    * Busca os posts de acordo com o usuário
    *
    * @return Query com os posts  
    */
    public function filtraPapeis($current_user){       
        $meta_query[] = 
        array(
        ); 
 
        $meta_query[] =
        array(
            'key' => 'oni',
            'value' => $current_user,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'papeis' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query,
            'meta_key' => 'data_de_inicio',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );
        $papeis_filtrados = new WP_Query( $args ); 

        
        return $papeis_filtrados;
    }

     /**
    * Busca os posts de acordo com o projeto
    *
    * @return Query com os posts  
    */
    public function pegaPapeisProjeto($projeto){       
        $meta_query[] = 
        array(
        ); 
 
        $meta_query[] =
        array(
            'key' => 'projeto',
            'value' => $projeto->ID,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'papeis' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        );
        $papeis_filtrados = new WP_Query( $args ); 

        
        return $papeis_filtrados;
    }

    /**
    * Cadastra os papeis de visão e time vindo o pipefy
    *
    * @param Array com o projeto cadastrado
    *     
    */
    public function cadastraPapelVisaoETime($projeto,$id_projeto){
        //Busca a key dos record fields e retorna o nome do projeto
        $key_nome_projeto = array_search('Nome do projeto', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $nome_projeto = $projeto[0]['data']['table_record']['record_fields'][$key_nome_projeto]['value'];
        //Busca a key dos record fields e retorna o guardião de visão
        $key_guardiao_visao = array_search('Guardião de visão', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $guardiao_visao = $projeto[0]['data']['table_record']['record_fields'][$key_guardiao_visao]['value'];
        //Busca a key dos record fields e retorna o guardião de time
        $key_guardiao_time = array_search('Guardião de time', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $guardiao_time = $projeto[0]['data']['table_record']['record_fields'][$key_guardiao_time]['value'];
        //Busca a key dos record fields e retorna a data de início
        $key_data_inicio = array_search('Data de início', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $data_de_inicio = $projeto[0]['data']['table_record']['record_fields'][$key_data_inicio]['value'];
        $data_de_inicio =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
        //Busca a key dos record fields e retorna a data de fim
        $key_data_fim = array_search('Data de término', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $data_de_fim = $projeto[0]['data']['table_record']['record_fields'][$key_data_fim]['value'];   
        $data_de_fim =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");  
        //Pegando o usuário do guardiao de visao
        if($guardiao_visao){
            $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_visao,2,-2) ) );
            $authors = $user_query->get_results();
            foreach ($authors as $author)
            {   
                $obj_guardiao_visao = $author;
            }
            
        }
        wp_reset_query();
        //Pegando o usuário do guardião de time
        if($guardiao_time){
            $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_time,2,-2) ) );
            $authors = $user_query->get_results();
            foreach ($authors as $author)
            {   
                $obj_guardiao_time = $author;
            }
            
        }
        wp_reset_query();
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
        set_transient("id_projeto",$id_projeto_wordpress);
        wp_reset_query();

        //Fazendo o loop de cadastro de visão
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'oni',
                    'value' => $obj_guardiao_visao->ID,
                    'compare' => '='
                ),
        
                array(
                    'key' => 'projeto',
                    'value' => $id_projeto_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ($the_query->have_posts() ) :
        else:
            $my_post = array(
                'post_title' => $nome_projeto.' - Visão '.$nome_da_frente.' - '.$obj_guardiao_visao->user_nicename,
                'post_status' => 'publish',
                'post_type' => 'papeis',
            );
            
            $post_id = wp_insert_post($my_post);
            update_post_meta( $post_id, 'oni', $obj_guardiao_visao->ID );
             update_field('data_de_inicio', $data_de_inicio, $post_id);
            update_field('data_de_terminio', $data_de_fim, $post_id);        
            update_field('papel', 'guardiao_visao', $post_id);
            update_field('projeto', $id_projeto_wordpress, $post_id);
        endif;
        wp_reset_postdata();
        
        //Fazendo o loop de cadastro de time
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'oni',
                    'value' => $obj_guardiao_time->ID,
                    'compare' => '='
                ),
        
                array(
                    'key' => 'projeto',
                    'value' => $id_projeto_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ($the_query->have_posts() ) :
        else:
            $my_post = array(
                'post_title' => $nome_projeto.' - Time '.$nome_da_frente.' - '.$obj_guardiao_time->user_nicename,
                'post_status' => 'publish',
                'post_type' => 'papeis',
            );
            
            $post_id = wp_insert_post($my_post);
            update_post_meta( $post_id, 'oni', $obj_guardiao_time->ID );
             update_field('data_de_inicio', $data_de_inicio, $post_id);
            update_field('data_de_terminio', $data_de_fim, $post_id);        
            update_field('papel', 'guardiao_time', $post_id);
            update_field('projeto', $id_projeto_wordpress, $post_id);
        endif;
        wp_reset_postdata();

    }


    /**
    * Altera os papeis de visão e time vindo o pipefy
    *
    * @param Array com o projeto alterado
    *     
    */
    public function alteraPapelVisaoETime($projeto,$id_projeto){
        //Busca a key dos record fields e retorna o nome do projeto
        $key_nome_projeto = array_search('Nome do projeto', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $nome_projeto = $projeto[0]['data']['table_record']['record_fields'][$key_nome_projeto]['value'];
        //Busca a key dos record fields e retorna o guardião de visão
        $key_guardiao_visao = array_search('Guardião de visão', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $guardiao_visao = $projeto[0]['data']['table_record']['record_fields'][$key_guardiao_visao]['value'];
        //Busca a key dos record fields e retorna o guardião de time
        $key_guardiao_time = array_search('Guardião de time', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $guardiao_time = $projeto[0]['data']['table_record']['record_fields'][$key_guardiao_time]['value'];
        //Busca a key dos record fields e retorna a data de início
        $key_data_inicio = array_search('Data de início', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $data_de_inicio = $projeto[0]['data']['table_record']['record_fields'][$key_data_inicio]['value'];
        $data_de_inicio =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
        //Busca a key dos record fields e retorna a data de fim
        $key_data_fim = array_search('Data de término', array_column($projeto[0]['data']['table_record']['record_fields'], 'name'));
        $data_de_fim = $projeto[0]['data']['table_record']['record_fields'][$key_data_fim]['value'];   
        $data_de_fim =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");  
        //Pegando o usuário do guardiao de visao
        if($guardiao_visao){
            $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_visao,2,-2) ) );
            $authors = $user_query->get_results();
            foreach ($authors as $author)
            {   
                $obj_guardiao_visao = $author;
            }
            
        }
        wp_reset_query();
        //Pegando o usuário do guardião de time
        if($guardiao_time){
            $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_time,2,-2) ) );
            $authors = $user_query->get_results();
            foreach ($authors as $author)
            {   
                $obj_guardiao_time = $author;
            }
            
        }
        wp_reset_query();
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
        set_transient("id_projeto",$id_projeto_wordpress);
        wp_reset_query();

        //Fazendo o loop de cadastro de visão
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'oni',
                    'value' => $obj_guardiao_visao->ID,
                    'compare' => '='
                ),
        
                array(
                    'key' => 'projeto',
                    'value' => $id_projeto_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $post_id = get_the_ID();
            update_post_meta( $post_id, 'oni', $obj_guardiao_visao->ID );
            update_field('data_de_inicio', $data_de_inicio, $post_id);
            update_field('data_de_terminio', $data_de_fim, $post_id);        
            update_field('papel', 'guardiao_visao', $post_id);
            update_field('projeto', $id_projeto_wordpress, $post_id);
        endwhile;endif;
        wp_reset_postdata();
        
        //Fazendo o loop de cadastro de time
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'oni',
                    'value' => $obj_guardiao_time->ID,
                    'compare' => '='
                ),
        
                array(
                    'key' => 'projeto',
                    'value' => $id_projeto_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $post_id = get_the_ID();
            update_post_meta( $post_id, 'oni', $obj_guardiao_time->ID );
            update_field('data_de_inicio', $data_de_inicio, $post_id);
            update_field('data_de_terminio', $data_de_fim, $post_id);        
            update_field('papel', 'guardiao_time', $post_id);
            update_field('projeto', $id_projeto_wordpress, $post_id);
        endwhile;endif;
        wp_reset_postdata();

    }

   
    /**
    * Cadastra o método vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function cadastraPapelMetodo($frentes){
        foreach($frentes as $frente){
            //Busca a key dos record fields e retorna o nome da frente
            $key_nome_frente = array_search('Nome da frente', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_da_frente = $frente['data']['table_record']['record_fields'][$key_nome_frente]['value'];
            //Busca a key dos record fields e retorna a data de inicio
            $key_data_de_inicio = array_search('Data de início', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_inicio = $frente['data']['table_record']['record_fields'][$key_data_de_inicio]['value'];
            $data_de_inicio =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
            //Busca a key dos record fields e retorna a data de término
            $key_data_de_fim = array_search('Data de término', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_fim = $frente['data']['table_record']['record_fields'][$key_data_de_fim]['value'];
            $data_de_fim =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");
            //Busca a key dos record fields e retorna as horas
            $key_horas = array_search('Horas', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $horas = $frente['data']['table_record']['record_fields'][$key_horas]['value'];
            //Busca a key dos record fields e retorna o guardiao de método
            $key_guardiao_metodo = array_search('Guardião de método', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $guardiao_metodo =   $frente['data']['table_record']['record_fields'][$key_guardiao_metodo]['value'];
            //Pega o ID da frente
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];

            if($guardiao_metodo){
                $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_metodo,2,-2) ) );
                $authors = $user_query->get_results();
                foreach ($authors as $author)
                {   
                    $obj_guardiao_metodo = $author;
                }
                
            }
            //Busca a key dos record fields e retorna o projeto
            $key_projeto = array_search('Projeto', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_projeto = $frente['data']['table_record']['record_fields'][$key_projeto]['value'];
            $id_projeto = $frente['data']['table_record']['record_fields'][$key_projeto]['array_value'][0];

             // Puxando o id da frente no wordpress 
                $args = array(
                    'posts_per_page' => -1,
                    'no_found_rows' => true,
                    'post_type'		=> 'frentes',
                    'post_status'   => 'publish',
                    'meta_key'		=> 'id_da_frente_pipefy',
                    'meta_value'	=> $id_da_frente_pipefy
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                    $id_frente_wordpress = get_the_ID();
                    
            endwhile;endif; 
            wp_reset_postdata();

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
           set_transient("id_projeto",$id_projeto_wordpress);
           wp_reset_query();

           //Fazendo uma query de papés já existentes
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'papeis',
                'post_status'   => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'oni',
                        'value' => $obj_guardiao_metodo->ID,
                        'compare' => '='
                    ),
            
                    array(
                        'key' => 'frente',
                        'value' => $id_frente_wordpress,
                        'compare' => '='
                    )
                )
            );
            $the_query = new WP_Query( $args );
            
   
            if ($the_query->have_posts() ) :
            else:
                $my_post = array(
                    'post_title' => substr($nome_projeto,2,-2).' - Método '.$nome_da_frente.' - '.$obj_guardiao_metodo->user_nicename,
                    'post_status' => 'publish',
                    'post_type' => 'papeis',
                );
                
                $post_id = wp_insert_post($my_post);
                update_post_meta( $post_id, 'oni', $obj_guardiao_metodo->ID );
                update_post_meta( $post_id, 'frente', $id_frente_wordpress );

                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_terminio', $data_de_fim, $post_id);        
                update_field('papel', 'guardiao_metodo', $post_id);
                update_field('projeto', $id_projeto_wordpress, $post_id);
            endif;
            wp_reset_postdata();
        }
           
    }

    /**
    * Altera o guardião de método vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function alteraPapelMetodo($frentes){
        $frente_e_guardioes_metodo = array();
        foreach($frentes as $frente){
            //Busca a key dos record fields e retorna o nome da frente
            $key_nome_frente = array_search('Nome da frente', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_da_frente = $frente['data']['table_record']['record_fields'][$key_nome_frente]['value'];
            //Busca a key dos record fields e retorna a data de inicio
            $key_data_de_inicio = array_search('Data de início', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_inicio = $frente['data']['table_record']['record_fields'][$key_data_de_inicio]['value'];
            $data_de_inicio_obj =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio );
            $data_de_inicio =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
            //Busca a key dos record fields e retorna a data de término
            $key_data_de_fim = array_search('Data de término', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_fim = $frente['data']['table_record']['record_fields'][$key_data_de_fim]['value'];
            $data_de_fim =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");
            //Busca a key dos record fields e retorna as horas
            $key_horas = array_search('Horas', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $horas = $frente['data']['table_record']['record_fields'][$key_horas]['value'];
            //Busca a key dos record fields e retorna o guardiao de método
            $key_guardiao_metodo = array_search('Guardião de método', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $guardiao_metodo =   $frente['data']['table_record']['record_fields'][$key_guardiao_metodo]['value'];
            //Pega o ID da frente
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];
            //Pega o status da frente
            $status_da_frente =  $frente['data']['table_record']['status']['name'];
            if($guardiao_metodo){
                $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_metodo,2,-2) ) );
                $authors = $user_query->get_results();
                foreach ($authors as $author)
                {   
                    $obj_guardiao_metodo = $author;
                }
                
            }
            //Busca a key dos record fields e retorna o projeto
            $key_projeto = array_search('Projeto', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_projeto = $frente['data']['table_record']['record_fields'][$key_projeto]['value'];
            $id_projeto = $frente['data']['table_record']['record_fields'][$key_projeto]['array_value'][0];

             // Puxando o id da frente no wordpress 
                $args = array(
                    'posts_per_page' => -1,
                    'no_found_rows' => true,
                    'post_type'		=> 'frentes',
                    'post_status'   => 'publish',
                    'meta_key'		=> 'id_da_frente_pipefy',
                    'meta_value'	=> $id_da_frente_pipefy
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                    $id_frente_wordpress = get_the_ID();
                    
            endwhile;endif; 
            wp_reset_postdata();
           
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
           wp_reset_query();

           //Fazendo uma query de papés já existentes
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'papeis',
                'post_status'   => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'frente',
                        'value' => $id_frente_wordpress,
                        'compare' => '='
                    )
                )
            );
            $the_query = new WP_Query( $args );
            if ($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $oni = get_field('oni');
                $informacoes_oni = get_field('informacoes_gerais', 'user_'.$oni['ID']);
                $guardiao_antigo = $informacoes_oni['id_do_clickup'];
                $post_id = get_the_ID();
                $hoje_obj =  new DateTime('NOW');
                // Se a frente estiver desativada no pipefy e ainda não estiver começado ele deleta a frente no wp
                if($status_da_frente == "Concluído" && $data_de_inicio_obj > $hoje_obj){
                    wp_delete_post($post_id);
                }else{
                //Se a frente já tiver começado ele faz a atualização normal, independente de estar concluída ou não
                    update_post_meta( $post_id, 'oni', $obj_guardiao_metodo->ID );
                    update_post_meta( $post_id, 'frente', $id_frente_wordpress );
                    update_field('data_de_inicio', $data_de_inicio, $post_id);
                    update_field('data_de_terminio', $data_de_fim, $post_id);        
                    update_field('papel', 'guardiao_metodo', $post_id);
                    update_field('projeto', $id_projeto_wordpress, $post_id);
                }
            endwhile; else:
                $my_post = array(
                    'post_title' => substr($nome_projeto,2,-2).' - Método '.$nome_da_frente.' - '.$obj_guardiao_metodo->user_nicename,
                    'post_status' => 'publish',
                    'post_type' => 'papeis',
                );
                
                $post_id = wp_insert_post($my_post);
                update_post_meta( $post_id, 'oni', $obj_guardiao_metodo->ID );
                update_post_meta( $post_id, 'frente', $id_frente_wordpress );

                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_terminio', $data_de_fim, $post_id);        
                update_field('papel', 'guardiao_metodo', $post_id);
                update_field('projeto', $id_projeto_wordpress, $post_id);
            endif;
            wp_reset_postdata();
            //Criei esse array para conseguir puxar na atualização das missões de gestão e substituir o assignee antigo pelo novo.
            $frente_e_guardioes_metodo[$id_frente_wordpress] = $guardiao_antigo;
        }
         
    }
}

//Criando o objeto
$processa_papeis = new processa_papeis;


?>