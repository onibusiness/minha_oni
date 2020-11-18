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
        $field['class'] .= ' form-control';
        
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
    if (is_admin() || current_user_can('administrator') ) {
    
    }else{
        $field['wrapper']['class'] .= ' d-none';
    }
    return $field;
    }


    
    public function update_oni_field($value) {
    /* Deixando o admin editar o rolê no front e no back */
    if (is_admin() || current_user_can('administrator') ) {
        return $value;
    }else{
        $value = get_current_user_id();
        return $value;
    }
    }

    /************************ MONTANDO O TÍTULO DOS POSTS CRIADOS NO FRONT *************************************/
    public function acf_review_before_save_post($post_id) {

        $user_atual = wp_get_current_user();
        $post_type_atual =  is_archive() ? get_queried_object()->name : false;
        $new_title = $post_type_atual." do ".$user_atual->display_name;
        
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

//Criando o objeto
$customizaacf = new customizaacf;
?>