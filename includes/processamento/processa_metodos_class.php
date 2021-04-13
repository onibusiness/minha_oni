<?php
/*
* Processa Métodos
* Função de metodos 
*/

class processa_metodos{
    
    /**
    * Busca todos os gestores de metodos
    *
    * @return Query com os posts  
    */
    public function pegaMetodos(){       


        $args = array(  
            'post_type' => 'metodo' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
        );
        $metodos = new WP_Query( $args ); 

        
        return $metodos;
    }
}

//Criando o objeto
$processa_metodos = new processa_metodos;


?>