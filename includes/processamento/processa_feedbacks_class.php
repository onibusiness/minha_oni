<?php
/*
* Processa feedbacks
* Traz operações de processamento, exibição e análise dos feedbacks de projeto
*
*/

class processa_feedbacks{
    public $feedbacks_cliente;//todos os feedbacks dos clientes
    public $feedbacks_time;//todos os feedbacks do time
    public $feedbacks_por_projeto;//feedbacks organizados por projeto


    //Iniciando a classe
    public function __construct(){
        $this->pegaFeedbacksCliente();
        $this->pegaFeedbacksTime();
        $this->organizaFeedbackPorProjeto();
    }

    /**
    * Busca todos os feedbacks pde clientes
    *
    * @return Query com os posts  
    */
    public function pegaFeedbacksCliente(){

        $args = array(  
            'post_type' => 'feedbacks_cliente' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
        );
        $feedbacks_cliente = new WP_Query( $args ); 
        $this->feedbacks_cliente = $feedbacks_cliente;

    }

    /**
    * Busca todos os feedbacks de time
    *
    * @return Query com os posts  
    */
    public function pegaFeedbacksTime(){

        $args = array(  
            'post_type' => 'feedback_time' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
        );
        $feedbacks_time = new WP_Query( $args ); 
        $this->feedbacks_time = $feedbacks_time;

    }

    
    /**
    * Organiza todos os feedbacks por projeto
    *
    * @return Array com os projetos, frentes e feedbacks  
    *   [id do projeto] => 
    *       [id da frente] =>
    *           [feedback_cliente] => 
    *               [Questão] => valor
    *           [feedback_time] =>
    *               [Questão] => valor
    */
    public function organizaFeedbackPorProjeto(){
        //Setando o array que vai ser retornado
        $feedbacks_por_projeto = array();
        //Fazendo a requisição de todas as frentes
        $args = array(  
            'post_type' => 'frentes' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
        );
        $the_query = new WP_Query( $args ); 
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            //Pegando o id do projeto daquela frente
            $obj_projeto = get_field('projeto');
            $id_projeto = $obj_projeto->ID;
            //Pegando o id da frente
            $id_frente = get_the_ID();
            //Setando o array com valor vazio
            $feedbacks_por_projeto[$id_projeto][$id_frente] = null;
            //Fazendo o loop pelos feedbacks do cliente para ver se tem feedback
            if ( $this->feedbacks_cliente->have_posts() ) : while ( $this->feedbacks_cliente->have_posts() ) : $this->feedbacks_cliente->the_post();
                //Pegando o id da frente do feedback
                $obj_frente_feedback_cliente = get_field('frente');
                $id_frente_feedback_cliente = $obj_frente_feedback_cliente->ID;
                //Pegando todos os fields de resposta
                $fields_feedback_cliente = get_fields();
                //Confere se o feedback do cliente é relacionado aquela frente
                if($id_frente == $id_frente_feedback_cliente){
                    $feedbacks_por_projeto[$id_projeto][$id_frente]['feedback_cliente'] = $fields_feedback_cliente;
                }
            endwhile;endif;
            //Fazendo o loop pelos feedbacks do time para ver se tem feedback
            if ( $this->feedbacks_time->have_posts() ) : while ( $this->feedbacks_time->have_posts() ) : $this->feedbacks_time->the_post();
                //Pegando o id da frente do feedback
                $obj_frente_feedback_time = get_field('frente');
                $id_frente_feedback_time = $obj_frente_feedback_time->ID;
                //Pegando todos os fields de resposta
                $fields_feedback_time = get_fields();
                //Confere se o feedback do time é relacionado aquela frente
                if($id_frente == $id_frente_feedback_time){
                    $feedbacks_por_projeto[$id_projeto][$id_frente]['feedback_time'] = $fields_feedback_time;
                }
            endwhile;endif;
            
        endwhile;endif;

    }
}
?>