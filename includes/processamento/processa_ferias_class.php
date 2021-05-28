<?php
/*
* Processa Férias
*/

class processa_ferias{
    /**
    * Pega férias a aprovar
    *
    * @return Query com os posts  
    */
    public function feriasPendentes(){       
        $args = array(  
            'post_type' => 'ferias' ,
            'post_status' => array('draft','pending'),
            'posts_per_page' => -1,
        );
        $ferias_pendentes = new WP_Query( $args ); 
        return $ferias_pendentes;
    }

    /**
    * Busca os posts de acordo com o usuário
    *
    * @return Query com os posts  
    */
    public function filtraFerias($current_user){       
        $meta_query[] = 
        array(
        ); 
 
        $meta_query[] =
        array(
            'key' => 'oni',
            'value' => $current_user->ID,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'ferias' ,
            'post_status' => array('publish','draft','pending'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        );
        $ferias_filtradas = new WP_Query( $args ); 
        return $ferias_filtradas;
    }

    /**
    * Busca e organiza as férias
    *
    * @return Array $ferias_da_oni com os posts  
    * ['atuais']   
    *   ['ID_oni']
    *   ['nome_oni']
    *   ['data_de_inicio_ferias']
    *   ['data_de_termino_ferias']
    *   ['dias_de_ferias]
    * ['proximas']   
    *   ['ID_oni']
    *   ['nome_oni']
    *   ['data_de_inicio_ferias']
    *   ['data_de_termino_ferias']
    *   ['dias_de_ferias]
    */
    public function feriasDaOni($hoje){       
        $args = array(  
            'post_type' => 'ferias' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
            'meta_key'			=> 'primeiro_dia_fora',
            'orderby'			=> 'meta_value',
            'order'				=> 'ASC'
        );
        $ferias = new WP_Query( $args ); 
        while ( $ferias->have_posts() ) : $ferias->the_post(); 
            $campos = get_fields();
            $data_de_inicio_ferias = str_replace('/', '-', $campos['primeiro_dia_fora']);
            $data_de_termino_ferias = str_replace('/', '-', $campos['ultimo_dia_fora']);
            $dias_de_ferias = minha_oni::contaDiasUteis(strtotime($data_de_inicio_ferias), strtotime($data_de_termino_ferias));

            if(strtotime($data_de_inicio_ferias) <= $hoje && strtotime($data_de_termino_ferias) >= $hoje  ){
                $ferias_da_oni['atuais'][] = array(
                    'ID_oni' => $campos['oni']->ID,
                    'nome_oni' => $campos['oni']->data->display_name,
                    'data_de_inicio_ferias' => $data_de_inicio_ferias,
                    'data_de_termino_ferias' => $data_de_termino_ferias,
                    'dias_de_ferias' => $dias_de_ferias
                );

            }
            if(strtotime($data_de_inicio_ferias) > $hoje ){
                $ferias_da_oni['proximas'][] = array(
                    'ID_oni' => $campos['oni']->ID,
                    'nome_oni' => $campos['oni']->data->display_name,
                    'data_de_inicio_ferias' => $data_de_inicio_ferias,
                    'data_de_termino_ferias' => $data_de_termino_ferias,
                    'dias_de_ferias' => $dias_de_ferias
                );
            }
        endwhile;
        return $ferias_da_oni;
    }

}

//Criando o objeto
$processa_ferias = new processa_ferias;
?>