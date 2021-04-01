<?php
/*
* Fazendo todas as intervenções no acf
* 
*/

class customizaacf{

    //disparando a classe
    public function __construct(){
        add_action('acf/init',  array($this,'desativaAutorACFext'));
        add_filter('acf/validate_form', array($this,'acf_form_bootstrap_styles'));
        add_filter('acf/prepare_field', array($this,'acf_form_fields_bootstrap_styles'));
        add_filter('acf/get_field_label',  array($this,'acf_form_fields_required_bootstrap_styles'));
        add_filter('acf/prepare_field/name=oni',  array($this,'only_show_oni_in_admin'));
        add_filter('acf/update_value/name=oni',  array($this,'update_oni_field'));
        add_action('acf/save_post',  array($this,'acf_review_before_save_post'),20);
        add_filter('acf/prepare_field/key=field_603e7bbc27729',  array($this,'preencher_projeto'));
        add_filter('acf/prepare_field/key=field_603e7bbc27729',  array($this,'only_show_oni_in_admin'));

        add_filter('acf/prepare_field/key=field_603e7bd5c94ca',  array($this,'preencher_frente'));
        add_filter('acf/prepare_field/key=field_603e7bd5c94ca',  array($this,'only_show_oni_in_admin'));

        add_filter('acf/prepare_field/key=field_60636ca0e8e97',  array($this,'preencher_oni_avaliado'));
        add_filter('acf/prepare_field/key=field_60636ca0e8e97',  array($this,'only_show_oni_in_admin'));

        add_filter('acf/prepare_field/key=field_60636ca7e8e98', array($this,'preencher_oni_avaliador'));
        add_filter('acf/prepare_field/key=field_60636ca7e8e98',  array($this,'only_show_oni_in_admin'));


    }

    // Desativando o módulo de autor do ACFext
    public function desativaAutorACFext(){
        acf_update_setting('acfe/modules/author', false);     
    }
    
    // Criando os estilos do bootstrap em cima do ACF form
    public function acf_form_bootstrap_styles($args){
        
        // Before ACF Form
        if(!$args['html_before_fields'])
            $args['html_before_fields'] = '<div class="row">'; // May be .form-row
        
        // After ACF Form
        if(!$args['html_after_fields'])
            $args['html_after_fields'] = '</div>';
        
        // Success Message
        if($args['html_updated_message'] == '<div id="message" class="updated"><p>%s</p></div>')
            $args['html_updated_message'] = '<div id="message" class="updated alert alert-success">%s</div>';
        
        // Submit button
        if($args['html_submit_button'] == '<input type="submit" class="acf-button button button-primary button-large" value="%s" />')
            $args['html_submit_button'] = '<input type="submit" class="acf-button button button-primary button-large btn btn-primary" value="%s" />';
        
        return $args;
        
    }
    
    // Criando os estilos do bootstrap em cima dos campos ACF form
    public function acf_form_fields_bootstrap_styles($field){
        
        // Target ACF Form Front only
        if(is_admin() && !wp_doing_ajax()){
            return $field;
        };
        

        // Add .form-group & .col-12 fallback on fields wrappers
        $field['wrapper']['class'] .= ' form-group col-12';
        // Add .form-control on fields
        if ($field['type'] !== 'radio') {
            $field['class'] .= ' form-control';
        }else{
            $field['class'] .= ' form-check-inline';
        }
       
        
        
        return $field;
        
    }


    
    public function acf_form_fields_required_bootstrap_styles($label){
        
        // Target ACF Form Front only
        if(is_admin() && !wp_doing_ajax())
            return $label;
        
        // Add .text-danger
        $label = str_replace('<span class="acf-required">*</span>', '<span class="acf-required text-danger">*</span>', $label);
        
        return $label;
        
    }



    /************************ PREENCHENDO O CAMPO DE ONI COM OS DADOS DO USUÁRIO LOGADO *************************************/
    
    public function only_show_oni_in_admin($field) {
    /* Deixando o admin editar o rolê no front e no back */
    if (is_admin() || current_user_can('edit_users') ) {
        return $field;
    }else{
        $field['wrapper']['class'] .= ' d-none';
    }
    return $field;
    }


    
    public function update_oni_field($value) {
    /* Deixando o admin editar o rolê no front e no back */
    if (is_admin() || current_user_can('edit_users') ) {
        return $value;
    }else{
        $value = get_current_user_id();
        return $value;
    }
    }

    function preencher_projeto($field) {
        // only on front end
        if (is_admin()) {
          return $field;
        }
        if (isset($_GET['projeto'])) {
          $field['value'] = $_GET['projeto'];
        }
        return $field;
    }
    function preencher_frente($field) {
        // only on front end
        if (is_admin()) {
          return $field;
        }
        if (isset($_GET['frente'])) {
          $field['value'] = $_GET['frente'];
        }
        return $field;
    }

    function preencher_oni_avaliador($field) {
        // only on front end
        if (is_admin()) {
          return $field;
        }
       
        $field['value'] = get_current_user_id();
       
        return $field;
    }

    function preencher_oni_avaliado($field) {
        // only on front end
        if (is_admin()) {
          return $field;
        }
        if (isset($_GET['oni_avaliado'])) {
          $field['value'] = $_GET['oni_avaliado'];
        }
        return $field;
    }

    /************************ MONTANDO O TÍTULO DOS POSTS CRIADOS NO FRONT *************************************/
    public function acf_review_before_save_post($post_id) {
        if(!is_admin() && !current_user_can('edit_users')){
            $user_atual = wp_get_current_user();
            $post_type_atual =  is_archive() ? get_queried_object()->name : false;
            $new_title = $post_type_atual." | ".$user_atual->display_name;
            
            $new_post = array(
                'ID'           => $post_id,
                'post_title'   => $new_title,
            );
            
            // Remove the hook to avoid infinite loop. Please make sure that it has
            // the same priority (20)
            remove_action('acf/save_post', 'my_save_post', 20);
            
            // Update the post
            wp_update_post( $new_post );
            
            // Add the hook back
            add_action('acf/save_post', 'my_save_post', 20);
        }

        
    }


    /**
    * Puxa o gestor de evidencia dentro de um loop de evidencias
    *
    * @return Int ID do gestor
    */
    public function puxaGestorEvidencia(){

        $projeto = get_field( 'projeto');

        //pegando os gestores do projeto
        $gestores = papeis::pegaPapeisProjeto($projeto);

        while ( $gestores->have_posts() ) : $gestores->the_post(); 
            $fields = get_fields();
            //Checando se o nome do campo "feedback_guardiao_x" contem o papel do gestor "guardiao_x"
            if(strpos($field['_name'], $fields['papel'])){
                //Se quiser filtar por data é o $fields['data_de_inicio'] e $fields['data_de_terminio']
                $id_gestor = $fields['oni']['ID'];

            }
        
        endwhile;

        return $id_gestor;
    }


    /**
    * Só mostra os campos de feedback para os gestores NÃO UTILIZADO
    *
    * @return acf_form filtrado
    */
    public function filtraGestorEvidencia($field){

        $id_gestor = $this->puxaGestorEvidencia();
        if (is_admin() || current_user_can('administrator') || get_current_user_id() == $id_gestor ) {
    
        }else{
            $field['wrapper']['class'] .= ' d-none';
        }
        return $field;
    }


}

//Criando o objeto
$customizaacf = new customizaacf;
?>