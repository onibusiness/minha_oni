<?php
/*
* Processa evidências
* Traz operações de processamento, exibição e análise de evidências
*
*/

class processa_evidencias{
    public $evidencias;//todas as evidencias
    public $evidencias_filtradas;//evidências de acordo com so parametros de url setados
    public $onis_status_evidencias;//status de evidências por oni

    //Iniciando a classe
    public function __construct(){
        $this->pegaEvidenciasCadastradas();
        $this->filtraEvidencias();
        $this->geraStatusPorOni();
    }

    /**
    * Busca todas as evidências
    *
    * @return Query com os posts  
    */
    public function pegaEvidenciasCadastradas(){

        $args = array(  
            'post_type' => 'evidencias' ,
            'post_status' => array('pending','publish'),
            'posts_per_page' => -1,
        );
        $evidencias_cadastradas = new WP_Query( $args ); 
        $this->evidencias = $evidencias_cadastradas;
    }

    /**
    * Busca os posts de acordo com o parâmetro de url
    *
    * @return Query com os posts  
    */
    public function filtraEvidencias(){
        //Setando os parâmetros da requisição das evidências    
        
        # FILTRAR DEPOIS PELO PERFIL DE ACESSO, SE FOR O GESTOR PEGAR AS EVIDÊNCIAS RELACIONADAS AOS SEUS PROJETOS, SÓCIO VÊ TUDO
        $meta_query[] = 
        array(
        ); 
        if($_GET['oni']){
        $meta_query[] =
        array(
            'key' => 'oni',
            'value' => $_GET['oni'],
            'compare' => '=='
        );
        };

        $args = array(  
            'post_type' => 'evidencias' ,
            'post_status' => array('pending','publish'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        );
        $evidencias_filtradas = new WP_Query( $args ); 
        $this->evidencias_filtradas = $evidencias_filtradas;
    }

    /**
    * Busca todas as evidências
    *
    * @return Array $this->onis_status_evidencias   
    *   [$user->display_name]
    *       [
    *       'sem_parecer'    => (int) Total de evidências sem pareceder dado
    *       'gestor_avaliar'    => (int) Evidências sem o feedback do gestor    
    *       'socio_avaliar'    => (int) Evidências sem o feedback dos sócios
    *       ]
    */
    public function geraStatusPorOni(){
        $users_wordpress = get_users();
        foreach($users_wordpress as $user){
            while ( $this->evidencias->have_posts() ) : $this->evidencias->the_post(); 
                $campos = get_fields();
       
                if($campos['oni'] == $user){
                    if($campos['parecer']== 'sem_parecer'){
                        $this->onis_status_evidencias[$user->user_nicename]['sem_parecer']++;
                        if($campos['feedback_do_gestor'] == ''){
                            $this->onis_status_evidencias[$user->user_nicename]['gestor_avaliar']++;
                        }
                        if($campos['feedback_dos_socios'] == ''){
                            $this->onis_status_evidencias[$user->user_nicename]['socio_avaliar']++;
                        }
                    }
                    
                }
            endwhile;
        }

    }
   /**
    * Busca evidencias do mesmo oni e da mesma competência
    *
    * @return Array com os IDS das evidencias  
    * @param Obj $competencia
    * @param Obj $competencia  
    * @param Array $evidencias
    *
    */
    public function maisEvidenciasCompetencia($oni, $competencia, $evidencias){
        $evidencias_da_competencia = array();

       while ( $evidencias->evidencias->have_posts() ) : $evidencias->evidencias->the_post(); 
            $id = get_the_id();
            $campos = get_fields();


            if($campos['oni'] == $oni && $campos['competencia'] == $competencia ){
                $evidencias_da_competencia[] = $id;
            }
            
       endwhile;
        return $evidencias_da_competencia;

    }


}
?>