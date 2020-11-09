<?php
/************************ CRIANDO SUPORTE PARA THUMNS **************************************/
add_theme_support( 'post-thumbnails' );



/************************ PUXANDO JQUERY *************************************/
function custom_jquery() {
    wp_deregister_script( 'wp-embed' );
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'custom_jquery');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Conta os dias úteis entre duas datas.
 *
 * @return Int  com o número de dias
 */
function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
  if (!defined('SATURDAY')) define('SATURDAY', 6);
  if (!defined('SUNDAY')) define('SUNDAY', 0);
  if ($patron) {
    $publicHolidays[] = $patron;
  }
  $start =  $date1;
  $end   =  $date2;
  $ano = date('Y', $start);
  $pascoa = easter_date($ano);
  $dia_pascoa = date('j', $pascoa);
  $mes_pascoa = date('n', $pascoa);
  $carnaval1 = mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano);//2ºferia Carnaval
  $carnaval2 =  mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano);//3ºferia Carnaval	
  $carnaval3 =  mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 46,  $ano);//4ºferia Carnaval	
  $sexta_santa = mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano);//6ºfeira Santa  
  $corpus = mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano);//Corpus Cirist
  $data_pascoa = date('m-d', $pascoa);
  $data_carnaval1 = date('m-d', $carnaval1);
  $data_carnaval2 = date('m-d', $carnaval2);
  $data_carnaval3 = date('m-d', $carnaval3);
  $data_sexta_santa = date('m-d', $sexta_santa);
  $data_corpus = date('m-d', $corpus);
  $halfdays = array($data_carnaval3);
  $publicHolidays = array('01-01', '04-21', '05-01', '09-07','10-12','11-02','11-15', '12-25', $data_pascoa, $data_carnaval1, $data_carnaval2, $data_sexta_santa, $data_sexta_santa);
  $workdays = 0;
  for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
    $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
    $mmgg = date('m-d', $i);

    if ($day != SUNDAY &&
      !in_array($mmgg, $publicHolidays) &&
      !($day == SATURDAY && $workSat == FALSE)) {
        if(in_array($mmgg, $halfdays)){
            $workdays += 0.5;
        }else{
            $workdays++;
        }     
    }
  }
  return round( $workdays, 2);
}

/**
 * Retorna o post type sendo carregado no archive
 *
 * @return String  com o slug do Custom post Type
 */
function get_archive_post_type() {
  return is_archive() ? get_queried_object()->name : false;
}


/************************ CRIANDO OS POST TYPES *************************************/
//Tutoriais
$tutoriais = get_stylesheet_directory() . '/includes/tutoriais/tutoriais_class.php';
include($tutoriais);

//Competencias e Esferas
$competencias = get_stylesheet_directory() . '/includes/competencias/competencias_class.php';
include($competencias);

//Evidências e evolução
$evidencias = get_stylesheet_directory() . '/includes/evidencias/evidencias_class.php';
include($evidencias);

//Ferramentas e equipamentos
$ferramentas = get_stylesheet_directory() . '/includes/ferramentas/ferramentas_class.php';
include($ferramentas);

//Fechamento mensal e pagamento
$fechamento_mensal = get_stylesheet_directory() . '/includes/fechamento_mensal/fechamento_mensal_class.php';
include($fechamento_mensal);

//Férias
$ferias = get_stylesheet_directory() . '/includes/ferias/ferias_class.php';
include($ferias);

//Papeis
$papeis = get_stylesheet_directory() . '/includes/papeis/papeis_class.php';
include($papeis);




/************************ CRIANDO AS CATEGORIAS *************************************/
 



add_action( 'after_setup_theme', 'declare_sensei_support' );
function declare_sensei_support() {
    add_theme_support( 'sensei' );
}





/************************ INTEGRANDO O ACFFORM COM O BOOTSTRAP *************************************/

add_action('wp_enqueue_scripts', 'acf_form_deregister_styles');
function acf_form_deregister_styles(){
    
    // Deregister ACF Form style
    wp_deregister_style('acf-global');
    wp_deregister_style('acf-input');
    
    // Avoid dependency conflict
    wp_register_style('acf-global', false);
    wp_register_style('acf-input', false);
    
}

add_filter('acf/validate_form', 'acf_form_bootstrap_styles');
function acf_form_bootstrap_styles($args){
    
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
add_filter('acf/prepare_field', 'acf_form_fields_bootstrap_styles');
function acf_form_fields_bootstrap_styles($field){
    
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


add_filter('acf/get_field_label', 'acf_form_fields_required_bootstrap_styles');
function acf_form_fields_required_bootstrap_styles($label){
    
    // Target ACF Form Front only
    if(is_admin() && !wp_doing_ajax())
        return $label;
    
    // Add .text-danger
    $label = str_replace('<span class="acf-required">*</span>', '<span class="acf-required text-danger">*</span>', $label);
    
    return $label;
    
}

/************************ DESATIVANDO O MÓDULO DE AUTOR DO ACFext *************************************/
add_action('acf/init', 'my_acfe_modules');
function my_acfe_modules(){
    acf_update_setting('acfe/modules/author', false);
    
}

/************************ PREENCHENDO O CAMPO DE ONI COM OS DADOS DO USUÁRIO LOGADO *************************************/
add_filter('acf/prepare_field/name=oni', 'only_show_oni_in_admin', 1, 1);
function only_show_oni_in_admin($field) {
  /* Deixando o admin editar o rolê no front e no back */
  if (is_admin() || current_user_can('administrator') ) {
 
  }else{
    $field['wrapper']['class'] .= ' d-none';
  }
  return $field;
}


add_filter('acf/update_value/name=oni', 'update_oni_field', 10, 3);
function update_oni_field($value, $post_id, $field ) {
  /* Deixando o admin editar o rolê no front e no back */
  if (is_admin() || current_user_can('administrator') ) {
    return $value;
  }else{
    $value = get_current_user_id();
    return $value;
  }
}

/************************ MONTANDO O TÍTULO DO POST *************************************/
function acf_review_before_save_post($post_id) {
	if (empty($_POST['acf']))
    return;
  $user_atual = wp_get_current_user();
  $post_type_atual = get_archive_post_type();
  $_POST['acf']['_post_title'] = $post_type_atual." do ".$user_atual->display_name;

  return $post_id;
}
add_action('acf/pre_save_post', 'acf_review_before_save_post', -1);

/**
 * Consolida uma evidência em evolução de uma competência
 *
 * @return New_Post_Evolucao  com o preenchimento da evidência
 */
function acf_consolidar_onion_up($post_id){
  $post_type_atual = get_post_type($post_id);
  $data = get_field('data',$post_id);
  $parecer = get_field('parecer',$post_id);
  $oni = get_field('oni',$post_id);
  $competencia = get_field('competencia',$post_id);
  if($post_type_atual == 'evidencias' && $parecer == 'onion_up' ){
    $args = array(
      'numberposts'	=> -1,
      'post_type'		=> 'evolucoes',
      'meta_key'		=> 'evidencia',
      'meta_value'	=> $post_id
    );
    $the_query = new WP_Query( $args );
    if( $the_query->have_posts() ){
      wp_reset_query();
      return;
    }else{
      $my_post = array(
        'post_title' => $oni->user_nicename." | ".$data,
        'post_status' => 'publish',
        'post_type' => 'evolucoes',
      );
      $nova_evolucao = wp_insert_post($my_post);
      update_field('data', $data, $nova_evolucao);
      update_field('competencia', $competencia, $nova_evolucao);
      update_field('oni', $oni, $nova_evolucao);
      update_field('evidencia', $post_id, $nova_evolucao);
    }


  }
}
add_action('acf/save_post', 'acf_consolidar_onion_up');