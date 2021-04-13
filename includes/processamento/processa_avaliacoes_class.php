<?php
/*
* Processa avaliações
* Traz operações de processamento, exibição e análise de avaliações entre os onis
*
*/

class processa_avaliacoes{
    public $avaliacoes;//todas as avaliacoes
    public $avaliacoes_filtradas;//avaliacoes cadastradas pelo oni logado

    //Iniciando a classe
    public function __construct(){
        $this->pegaAvaliacoesCadastradas();
        $this->pegaAvaliacoesOni();
    }

    /**
    * Busca todas as evidências
    *
    * @return Query com os posts  
    */
    public function pegaAvaliacoesCadastradas(){

        $args = array(  
            'post_type' => 'avaliacoes' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
        );
        $avaliacoes_cadastradas = new WP_Query( $args ); 
        $this->avaliacoes = $avaliacoes_cadastradas;

    }

    /**
    * Busca os posts de acordo com o usuário logado
    *
    * @return Query com os posts  
    */
    public function pegaAvaliacoesOni(){
        $user_atual = wp_get_current_user();
        //Setando os parâmetros da requisição das evidências    
        $meta_query[] =
            array(
                'key' => 'oni_avaliador',
                'value' =>  $user_atual->ID,
                'compare' => '=='
            );      
    
        $args = array(  
            'post_type' => 'avaliacoes' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
            'date_query' => array(
                array(
                    'after' => '2 months ago'
                )
            ),
            'meta_query' => $meta_query
        );
        $avaliacoes_filtradas = new WP_Query( $args ); 
        $this->avaliacoes_filtradas = $avaliacoes_filtradas;

    }

    /**
    * Puxa as avaliacoes do usuário atual
    *
    * @return Query com os posts  
    */
    public function filtraAvaliacoes($current_user){
        $meta_query[] =
            array(
                'key' => 'oni_avaliado',
                'value' =>  $current_user->ID,
                'compare' => '=='
            );      
    
        $args = array(  
            'post_type' => 'avaliacoes' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
            'date_query' => array(
                array(
                    'after' => '2 months ago'
                )
            ),
            'meta_query' => $meta_query
        );
        $avaliacoes_do_oni = new WP_Query( $args ); 
        return $avaliacoes_do_oni;

    }

}
?>