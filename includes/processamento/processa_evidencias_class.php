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
    public $evidencias_por_gestor;//status de evidências por oni

    //Iniciando a classe
    public function __construct(){
        $this->pegaEvidenciasCadastradas();
        $this->filtraEvidencias();
        $this->geraStatusPorOni();
        $this->montaEvidenciasPorGestor();
    }

    /**
    * Busca todas as evidências
    *
    * @return Query com os posts  
    */
    public function pegaEvidenciasCadastradas(){

        $args = array(  
            'post_type' => 'evidencias' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
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
        global $template;
        if(basename($template) == "page-user.php"){
            $user_id =  um_profile_id();
            $meta_query[] =
            array(
                'key' => 'oni',
                'value' => $user_id,
                'compare' => '=='
            ); 
        }
        if(basename($template) == "archive-evidencias.php"){
            $user_id =  get_current_user_id();
            $meta_query[] =
            array(
                'key' => 'oni',
                'value' => $user_id,
                'compare' => '=='
            ); 
        }
        $args = array(  
            'post_type' => 'evidencias' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
            'meta_key'			=> 'data',
            'orderby'			=> 'meta_value',
            'order'				=> 'DESC',
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
            $this->onis_status_evidencias[$user->user_nicename]['gestor_avaliar'] = 0;
            while ( $this->evidencias->have_posts() ) : $this->evidencias->the_post(); 
                $campos = get_fields();
               
                if($campos['oni'] == $user){
                    
                    if(preg_match('(sim|nao|onion_up)', $campos['parecer']) === 0) {
                        
                        $this->onis_status_evidencias[$user->user_nicename]['sem_parecer'] += 1;
                        if($campos['feedback_guardiao_time'] == '' && $campos['feedback_guardiao_metodo'] == '' && $campos['feedback_guardiao_visao'] == ''){
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

    /**
    * Monta o filtro de evidencias por gestor
    *
    * @return Array os gestores e suas evidencais  
    *   [$user->display_name] nome do gestor
    *       [
    *       'evidencia'    => (int) ID da evidencia
    *       'oni'    => (int) ID da evidencia
    *       'papel'    => (string) Papel do gestor   
    *       ]
    */
    public function montaEvidenciasPorGestor(){
    
        while ( $this->evidencias->have_posts() ) : $this->evidencias->the_post(); 
      
            $id = get_the_id();
            $projeto = get_field( 'projeto');
            $oni = get_field('oni');
     
            //pegando os gestores do projeto
            $gestores = processa_papeis::pegaPapeisProjeto($projeto);
           
            while ( $gestores->have_posts() ) : $gestores->the_post(); 
                $fields = get_fields();
        
                $this->evidencias_por_gestor[$fields['oni']['ID']][] = array(
                    'evidencia' => $id,
                    'oni' => $oni->ID,
                    'papel' => $fields['papel'],
                );
          
            
            endwhile;
          
        endwhile;
    
    }


}
?>