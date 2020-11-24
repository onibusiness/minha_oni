<?php
/*
* Processa competencias
* Traz operações de exibição de competênicas
*
*/

class processa_competencias{
    public $users_wordpress;//usuários do wordpress
    public $evolucoes;//Todas as evoluções cadastradas
    public $competencias;//Todas as competencias da oni
    public $competencias_por_oni;//Tree de competências do Oni (atualizada com a data )
    public $competencias_no_sistema;//Competências disponíveis no sistema
    

    //Iniciando a classe
    public function __construct(){
        $this->puxaUsuarios();
        $this->puxaEvolucoes();
        $this->puxaCompetencias();
        $this->competenciasPorOni();
        $this->competenciasNoSistema();
    }

    /**
    * Pega os usuários do Wordpress
    *
    * @return Array $this->users_wordpress com os objetos de usuários
    */
    public function puxaUsuarios(){
        $this->users_wordpress = get_users();
    }

    /**
    * Busca todas as evoluções
    *
    * @return Query com os posts de evoluções
    */
    public function puxaEvolucoes(){
        
        $args = array(  
            'post_type' => 'evolucoes',
            'post_status' => array('publish'),
            'posts_per_page' => -1,
        );
        $evolucoes = new WP_Query( $args ); 
        $this->evolucoes = $evolucoes;
    }

    /**
    * Busca todas as comepetências
    *
    * @return Query com os posts de competências
    */
    public function puxaCompetencias(){
        
        $args = array(  
            'post_type' => 'competencias',
            'post_status' => array('publish'),
            'posts_per_page' => -1,
        );
        $competencias = new WP_Query( $args ); 
        $this->competencias = $competencias;
    }

    /**
    * Processa todas as competências por oni
    *
    * @return Array $competencias_por_oni 
    *   ['user_nicename]
    *       ['nome_da_competencia'] => 'pontos' (int) 
    *
    */
    public function competenciasPorOni(){
        foreach($this->users_wordpress as $user){
            while ( $this->competencias->have_posts() ) : $this->competencias->the_post(); 
                $this->competencias_por_oni[$user->user_nicename][get_the_title()] = 0;
            endwhile;
            while ( $this->evolucoes->have_posts() ) : $this->evolucoes->the_post(); 
                $campos = get_fields();
                if($campos['oni'] == $user){
                    $this->competencias_por_oni[$user->user_nicename][$campos['competencia']->post_title]++;
                }
            endwhile;
        }

    }

    /**
    * Processa as competencias do sistema
    *
    * @return Array $competencias_no_sistema 
    *   
    *   ['nome_da_competencia'] 
    *       [1] => array(['user_nicename]),
    *       [2] => array(['user_nicename]),
    *       [3] => array(['user_nicename]),
    *       [4] => array(['user_nicename]),
    *       [5] => array(['user_nicename]),
    *
    */
    public function competenciasNoSistema(){
        while ( $this->competencias->have_posts() ) : $this->competencias->the_post(); 
            $competencia = get_the_title();
            for ($i=1; $i < 6 ; $i++) { 
                //Filtrando o array de competencia por oni pelo nível da competencia
                $onis_com_nivel =  array_filter( $this->competencias_por_oni, function($v, $k) use($i, $competencia){
                    return  key($v) == $competencia && reset($v) == $i;
                }, ARRAY_FILTER_USE_BOTH);
                //Pegando os nomes dos onis do filtro e jogando para a lista de nível de competencias
                foreach($onis_com_nivel as $oni_com_nivel => $descricao){
                    $this->competencias_no_sistema[$competencia][$i][] = $oni_com_nivel; 
                }
            }
          
        endwhile;
    }

}

?>