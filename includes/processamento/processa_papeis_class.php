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
    * Cadastra o método vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function cadastraPapelMetodo($frentes){
        foreach($frentes as $frente){
            $nome_da_frente = $frente['data']['table_record']['record_fields'][4]['value'];
            $data_de_inicio = $frente['data']['table_record']['record_fields'][1]['value'];
            $data_de_fim = $frente['data']['table_record']['record_fields'][0]['value'];
            $guardiao_metodo = $frente['data']['table_record']['record_fields'][2]['value'];
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];
            if($guardiao_metodo){
                $user_query = new WP_User_Query( array( 'search' => $guardiao_metodo ) );
                $authors = $user_query->get_results();
                foreach ($authors as $author)
                {   
                    $obj_guardiao_metodo = $author;
                }
                
            }
 
            $nome_projeto = $frente['data']['table_record']['record_fields'][5]['value'];
            $id_projeto = $frente['data']['table_record']['record_fields'][5]['array_value'][0];

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
                        'key' => 'projeto',
                        'value' => $id_projeto_wordpress->ID,
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
                wp_reset_postdata();
            endif;
        }
           
    }

    /**
    * Altera o guardião de método vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function atualizaPapelMetodo($nome_projeto,$nome_da_frente,$id_da_frente_pipefy, $guardiao, $data_de_inicio, $data_de_fim){
        $hoje = date("d/m/Y");     
        // Pegando o objeto do guardião de método
        $user_query = new WP_User_Query( array( 'search' => $guardiao ) );
        $authors = $user_query->get_results();
        foreach ($authors as $author)
        {   
            $obj_guardiao_metodo = $author;
        }
    
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

       //pegando os papeis de método daquela frente
        $args = array(
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'frente',
                    'value' => $id_frente_wordpress,
                    'compare' => '='
                ),
        
                array(
                    'key' => 'papel',
                    'value' => 'guardiao_metodo',
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $guardiao_atual = get_field('guardiao_metodo');
            $post_id = get_the_ID();
            //se for o mesmo guardião ele vai atualizar apenas a data de fim
            if($guardiao_atual['display_name'] == $guardiao){
                update_field('data_de_terminio', $data_de_fim, $post_id);  
            }else{
            //Se for outro guardião ele encerra a guarda com o dia de hoje e cria uma nova
                update_field('data_de_terminio', $hoje, $post_id);  
                $my_post = array(
                    'post_title' => substr($nome_projeto,2,-2).' - Método '.$nome_da_frente.' - '.$obj_guardiao_metodo->user_nicename,
                    'post_status' => 'publish',
                    'post_type' => 'papeis',
                );
                
                $post_id = wp_insert_post($my_post);
                update_post_meta( $post_id, 'oni', $obj_guardiao_metodo->ID );
                update_field('frente', $nome_da_frente, $post_id);
                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_terminio', $data_de_fim, $post_id);        
                update_field('papel', 'guardiao_metodo', $post_id);
                update_field('projeto', $id_projeto_wordpress, $post_id);
                wp_reset_postdata();
            }

       endwhile;endif; 
    }
}

//Criando o objeto
$processa_papeis = new processa_papeis;


?>