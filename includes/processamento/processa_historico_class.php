<?php
/*
* Historico
* Classe para fazer os tratamentos dos dados historicos mês a mes
*/

class historico{
    public $seis_meses;//seis meses anteriores a esse

     //disparando a classe
     public function __construct(){
         $this->pegaSeisMeses();
     }
    
    /**
    * Construindo o array dos seis meses anteriores
    *
    * @return Array com o primeiro dia dos meses anteriores ordenado do mais antigo para o mais novo
    *  [
    *  'timestamp'    => (date) primeiro dia do mes
    *  'dia'  => (string) formato 'd-m-y' primeiro dia do mes
    *  'data'  => (string) formato 'M de Y 'mês e ano
    *  'classe'  => (string) formato 'MY 'mês e ano
    *  ] 
    */
    public function pegaSeisMeses(){
        $hoje = strtotime("today");
        for ($i=1; $i < 7 ; $i++) { 
            $expressao_data  = "first day of -".$i." month";
            $this->seis_meses[] = array(
                'timestamp' => strtotime($expressao_data),
                'dia' =>  date('d-m-y',strtotime($expressao_data)),
                'data'=>  date_i18n('M \\d\\e Y',strtotime($expressao_data)),
                'classe'=>  date_i18n('MY',strtotime($expressao_data))
             );
        }
        $this->seis_meses = array_reverse($this->seis_meses);

    }

    /**
    * Pegando os pagamentos do seis meses anteriores
    *
    * @return Array com os meses e os campos do pagamento do usuário
    * ['data'] => (data) formato MY 
    *     [
    *     'campos'    => (array) campos do ACF do pagamento do oni
    *     ] 
    */
    public function pegaHistoricoPagamento($current_user){
        $meta_query[] =
        array(
            'key' => 'oni',
            'value' => $current_user,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'pagamentos' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        );
        $pagamentos_filtrados = new WP_Query( $args ); 
       
        $historico_pagamentos = array();
        while ( $pagamentos_filtrados->have_posts() ) : $pagamentos_filtrados->the_post(); 
            $campos = get_fields();

            $data = str_replace('/', '-', $campos['data']);
            foreach($this->seis_meses as $mes){
                if(date_i18n('MY',strtotime($data))===$mes["classe"]){
                    $historico_pagamentos[$mes["classe"]] = $campos;
                    $grupo_campos = acf_get_fields('group_5dd567c6adaf9');
 
                    foreach ($grupo_campos as $campo) {
                        $historico_pagamentos[$mes["classe"]][$campo['name']] = get_field($campo['name']);
                    }
                }
            }
      
        endwhile;

        return $historico_pagamentos;

    }
}