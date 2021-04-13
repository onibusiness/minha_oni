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
                //BUG - PQ ESSE CAMPO NÃO SALVA O ONI AO RECEBER O ID? o.O
              
                update_post_meta( $post_id, 'oni', $obj_guardiao_metodo->ID );
                update_field('frente', $nome_da_frente, $post_id);
                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_terminio', $data_de_fim, $post_id);        
                update_field('papel', 'guardiao_metodo', $post_id);
                update_field('projeto', $id_projeto_wordpress, $post_id);
                wp_reset_postdata();
            endif;
        }
           
    }
}

//Criando o objeto
$processa_papeis = new processa_papeis;


?>