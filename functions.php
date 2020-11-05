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
function custom_post_type() {
  /* TUTORIAIS */
  $labels = array(
    'name'                => _x( 'Tutoriais', 'Post Type General Name'),
    'singular_name'       => _x( 'Tutorial', 'Post Type Singular Name'),
    'menu_name'           => __( 'Tutoriais'),
    'all_items'           => __( 'Todos os Tutoriais'),
    'view_item'           => __( 'Ver tutorial'),
    'add_new_item'        => __( 'Adicionar novo tutorial'),
    'add_new'             => __( 'Novo tutorial'),
    'edit_item'           => __( 'Editar tutorial'),
    'update_item'         => __( 'Atualizar tutorial'),
    'search_items'        => __( 'Procurar tutorial'),
  );
  $args = array(
    'label'               => __( 'Tutoriais'),
    'description'         => __( 'Tutoriais'),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-welcome-learn-more',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'tutoriais', $args );  


  /* FECHAMENTO FINANCEIRO MENAL */
  $labels = array(
    'name'                => _x( 'Fechamentos mensais', 'Post Type General Name'),
    'singular_name'       => _x( 'Fechamento mensal', 'Post Type Singular Name'),
    'menu_name'           => __( 'Fechamentos mensais'),
    'all_items'           => __( 'Todos Fechamentos mensais'),
    'view_item'           => __( 'Ver fechamento mensal'),
    'add_new_item'        => __( 'Adicionar novo fechamento mensal'),
    'add_new'             => __( 'Adicionar novo'),
    'edit_item'           => __( 'Editar fechamento mensal'),
    'update_item'         => __( 'Atualizar fechamento mensal'),
    'search_items'        => __( 'Procurar fechamento mensal'),
  );     
  $args = array(
    'label'               => __( 'Fechamentos mensais'),
    'description'         => __( 'Fechamentos mensais financeiros'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-chart-area',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );   
  register_post_type( 'fechamento_mensal', $args );




  /* PAGAMENTOS */
  $labels = array(
    'name'                => _x( 'Pagamentos', 'Post Type General Name'),
    'singular_name'       => _x( 'Pagamento', 'Post Type Singular Name'),
    'menu_name'           => __( 'Pagamentos'),
    'all_items'           => __( 'Todos pagamentos'),
    'view_item'           => __( 'Ver pagamento'),
    'add_new_item'        => __( 'Adicionar novo pagamento'),
    'add_new'             => __( 'Adicionar novo'),
    'edit_item'           => __( 'Editar pagamento'),
    'update_item'         => __( 'Atualizar pagamento'),
    'search_items'        => __( 'Procurar pagamento'),
  );     
  $args = array(
    'label'               => __( 'pagamentos'),
    'description'         => __( 'Pagamentos dos Onis'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-chart-area',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );   
  register_post_type( 'pagamentos', $args );



  /* PAPÉIS */
  $labels = array(
    'name'                => _x( 'Papéis', 'Post Type General Name'),
    'singular_name'       => _x( 'Papel', 'Post Type Singular Name'),
    'menu_name'           => __( 'Papéis'),
    'all_items'           => __( 'Todos os Papéis'),
    'view_item'           => __( 'Ver papel'),
    'add_new_item'        => __( 'Adicionar novo papel'),
    'add_new'             => __( 'Adicionar novo'),
    'edit_item'           => __( 'Editar papel'),
    'update_item'         => __( 'Atualizar papel'),
    'search_items'        => __( 'Procurar papel'),
  );
  $args = array(
    'label'               => __( 'Papéis'),
    'description'         => __( 'Papéis'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-search',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'papeis', $args );  


  /* COMPETÊNCIAS */
  $labels = array(
    'name'                => _x( 'Competências', 'Post Type General Name'),
    'singular_name'       => _x( 'Competência', 'Post Type Singular Name'),
    'menu_name'           => __( 'Competências'),
    'all_items'           => __( 'Todas as competências'),
    'view_item'           => __( 'Ver competência'),
    'add_new_item'        => __( 'Adicionar nova competência'),
    'add_new'             => __( 'Adicionar nova'),
    'edit_item'           => __( 'Editar competência'),
    'update_item'         => __( 'Atualizar competência'),
    'search_items'        => __( 'Procurar competência'),
  );
  $args = array(
    'label'               => __( 'Competências'),
    'description'         => __( 'Competências'),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-awards',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
    'taxonomies'          => array( 'esfera' ),
    
  );
  register_post_type( 'competencias', $args );

  /* EVIDÊNCIAS */
  $labels = array(
    'name'                => _x( 'Evidências', 'Post Type General Name'),
    'singular_name'       => _x( 'Evidência', 'Post Type Singular Name'),
    'menu_name'           => __( 'Evidências'),
    'all_items'           => __( 'Todas as evidências'),
    'view_item'           => __( 'Ver evidência'),
    'add_new_item'        => __( 'Adicionar nova evidência'),
    'add_new'             => __( 'Adicionar nova'),
    'edit_item'           => __( 'Editar evidência'),
    'update_item'         => __( 'Atualizar evidência'),
    'search_items'        => __( 'Procurar evidência'),
  );
  $args = array(
    'label'               => __( 'Evidências'),
    'description'         => __( 'Evidências'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-search',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'evidencias', $args );  

  /* EVOLUÇÃO */
  $labels = array(
    'name'                => _x( 'Evoluções', 'Post Type General Name'),
    'singular_name'       => _x( 'Evolução', 'Post Type Singular Name'),
    'menu_name'           => __( 'Evoluções'),
    'all_items'           => __( 'Todas as Evoluções'),
    'view_item'           => __( 'Ver Evolução'),
    'add_new_item'        => __( 'Adicionar nova Evolução'),
    'add_new'             => __( 'Adicionar nova'),
    'edit_item'           => __( 'Editar Evolução'),
    'update_item'         => __( 'Atualizar Evolução'),
    'search_items'        => __( 'Procurar Evolução'),
  );
  $args = array(
    'label'               => __( 'Evoluções'),
    'description'         => __( 'Evoluções'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-search',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'evolucao', $args );  
  /* FÉRIAS */
  $labels = array(
    'name'                => _x( 'Férias', 'Post Type General Name'),
    'singular_name'       => _x( 'Férias', 'Post Type Singular Name'),
    'menu_name'           => __( 'Férias'),
    'all_items'           => __( 'Todas as Férias'),
    'view_item'           => __( 'Ver Férias'),
    'add_new_item'        => __( 'Adicionar nova Férias'),
    'add_new'             => __( 'Adicionar nova'),
    'edit_item'           => __( 'Editar Férias'),
    'update_item'         => __( 'Atualizar Férias'),
    'search_items'        => __( 'Procurar Férias'),
  );
  $args = array(
    'label'               => __( 'Férias'),
    'description'         => __( 'Férias'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-search',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'ferias', $args );  

  /* EQUIPAMENTOS */
  $labels = array(
    'name'                => _x( 'Equipamentos', 'Post Type General Name'),
    'singular_name'       => _x( 'Equipamento', 'Post Type Singular Name'),
    'menu_name'           => __( 'Equipamentos'),
    'all_items'           => __( 'Todos os Equipamentos'),
    'view_item'           => __( 'Ver Equipamentos'),
    'add_new_item'        => __( 'Adicionar novo Equipamentos'),
    'add_new'             => __( 'Adicionar nova'),
    'edit_item'           => __( 'Editar Equipamentos'),
    'update_item'         => __( 'Atualizar Equipamentos'),
    'search_items'        => __( 'Procurar Equipamentos'),
  );
  $args = array(
    'label'               => __( 'Equipamentos'),
    'description'         => __( 'Equipamentos'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-search',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'equipamentos', $args );  
  /* FERRAMENTAS */
  $labels = array(
    'name'                => _x( 'Ferramentas', 'Post Type General Name'),
    'singular_name'       => _x( 'Ferramenta', 'Post Type Singular Name'),
    'menu_name'           => __( 'Ferramentas'),
    'all_items'           => __( 'Todos os Ferramentas'),
    'view_item'           => __( 'Ver Ferramentas'),
    'add_new_item'        => __( 'Adicionar novo Ferramentas'),
    'add_new'             => __( 'Adicionar nova'),
    'edit_item'           => __( 'Editar Ferramentas'),
    'update_item'         => __( 'Atualizar Ferramentas'),
    'search_items'        => __( 'Procurar Ferramentas'),
  );
  $args = array(
    'label'               => __( 'Ferramentas'),
    'description'         => __( 'Ferramentas'),
    'labels'              => $labels,
    'supports'            => array( 'title',  'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon' => 'dashicons-search',
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capabilities' => array(
      'publish_posts' => 'manage_options',
      'edit_posts' => 'manage_options',
      'edit_others_posts' => 'manage_options',
      'delete_posts' => 'manage_options',
      'delete_others_posts' => 'manage_options',
      'read_private_posts' => 'manage_options',
      'edit_post' => 'manage_options',
      'delete_post' => 'manage_options',
      'read_post' => 'manage_options',
    ),
  );
  register_post_type( 'Ferramenta', $args );  
 
   
}
add_action( 'init', 'custom_post_type', 0 );



/************************ CRIANDO AS CATEGORIAS *************************************/
 
function custom_taxonomies() {
 
  $labels = array(
    'name' => _x( 'Esferas', 'taxonomy general name' ),
    'singular_name' => _x( 'Esfera', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Esferas' ),
    'all_items' => __( 'All Esferas' ),
    'parent_item' => __( 'Parent Esfera' ),
    'parent_item_colon' => __( 'Parent Esfera:' ),
    'edit_item' => __( 'Edit Esfera' ), 
    'update_item' => __( 'Update Esfera' ),
    'add_new_item' => __( 'Add New Esfera' ),
    'new_item_name' => __( 'New Esfera Name' ),
    'menu_name' => __( 'Esferas' ),
  );    
 
 
  register_taxonomy('esfera',array('competencias'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'esfera' ),
  ));
 
}

add_action( 'init', 'custom_taxonomies', 0 );


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
      'post_type'		=> 'evolucao',
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
        'post_type' => 'evolucao',
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