<?php
/*
* missao_nao_preenchida
* Classe que escuta os não preenchimentos de missões e gerencia as advertencias e avisos
*/

class missao_nao_preenchida{
    
    public $mensagem_clickup;//mensagem de email do clickup
    public $id_advertencia;//id da advertencia no wordpress
    public $link_da_task;//link para a task no clickup
    public $id_da_task;//id da task no clickup
    public $task_click;//objeto com a task do clickup
    public $oni_id;//id do wordpress de quem cometeu a falha
    public $oni_email;//email do usuário que cometeu a falha

    function __construct(){
        add_action('save_post_advertencias', array($this,'ouveCadastroAdvertencia')); 
    }

    /**
    * 
    * Para ouvir o cadastro do post
    * 
    */
    function ouveCadastroAdvertencia($post_id){
        $this->id_advertencia = $post_id;
        $this->mensagem_clickup = get_post_field('post_content',$post_id);
        //Transformando o email em objeto DOM
        $dom = new DomDocument();
        @ $dom->loadHTML($this->mensagem_clickup );
        //Pegando só as tags de link
        $links = $dom->getElementsByTagName('a');
        //Filtra tags pra achar a que tem o link da missão
        foreach($links as $link) {
            $url = $link->getAttribute('href');
            $parsed_url = parse_url($url);
            if( isset($parsed_url['host']) && $parsed_url['host'] === 'app.clickup.com' ) {
                $this->link_da_task = $url;
                $this->id_da_task =  end((explode('/', $url)));
            }
        }
        update_field('explicacao', $this->id_da_task, $this->id_advertencia); 
        update_field('desconta_onion', 'nao', $this->id_advertencia); 
        //Buscando a missão no clickup
        $this->task_click = clickup::clickupPegaTask($this->id_da_task);
        $explicacao = 
        "Você não preencheu uma missão no clickup depois da deadline ter chegado. Missão: ".$this->task_click->name.". Projeto: ".$this->task_click->project->name.". Link da missão: ".$this->link_da_task;
        update_field('explicacao', $explicacao, $this->id_advertencia); 
        //Pegando os usuários e registrando o id e email do oni
        $authors = get_users();
        foreach ($authors as $author)
        {      
            $id_clickup = get_field('informacoes_gerais', 'user_'. $author->ID);
            $id_clickup = $id_clickup['id_do_clickup'];      
            if($id_clickup == $this->task_click->assignees[0]->id){
                $this->oni_id = $author->ID;
                $this->oni_email = $author->user_email;
            }
        }
        $data = get_the_date('Ymd',$this->id_advertencia);
        set_transient('email_user',$this->oni_email);
        update_field('oni', $this->oni_id, $this->id_advertencia); 
        update_post_meta( $this->id_advertencia, 'oni', $this->oni_id);
        update_field('field_5fb3cc7608aad', $data, $this->id_advertencia); 

        /* PUXAR O DISPARO DE EMAIL A PARTIR DESSA OCORRÊNCIA AQUI */
        $to = $this->oni_email;
        $subject = 'Ei, você podia ter perdido um onion';
        ob_start();
        include(get_template_directory().'/includes/email/template_email_bot.php');
        $body = ob_get_contents();
        ob_end_clean();
        $headers = array('Content-Type: text/html; charset=UTF-8','From: minha.oni <minha@oni.com.br>');
        
        wp_mail( $to, $subject, $body, $headers );
    }
}
 
$missao_nao_preenchida = new missao_nao_preenchida;