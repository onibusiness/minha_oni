<?php
/*
* Cria a classe com o motor de criacao dos custom post types
*/

class cpt{
    public function __construct(){
        add_action('init', array('cpt','adicionarCustomPostType'),10,3); 

    }

    //Adicionando o custom post type
    public static function adicionarCustomPostType($nome_singular,$nome_plural, $post_slug){
            $labels = array(
            'name'               => ucwords($nome_singular),
            'nome_singular'      => ucwords($nome_singular),
            'menu_name'          => ucwords($nome_plural),
            'name_admin_bar'     => ucwords($nome_singular),
            'add_new'            => ucwords($nome_singular),
            'add_new_item'       => 'Add New ' . ucwords($nome_singular),
            'new_item'           => 'New ' . ucwords($nome_singular),
            'edit_item'          => 'Edit ' . ucwords($nome_singular),
            'view_item'          => 'View ' . ucwords($nome_plural),
            'all_items'          => 'All ' . ucwords($nome_plural),
            'search_items'       => 'Search ' . ucwords($nome_plural),
            'parent_item_colon'  => 'Parent ' . ucwords($nome_plural) . ':', 
            'not_found'          => 'No ' . ucwords($nome_plural) . ' found.', 
            'not_found_in_trash' => 'No ' . ucwords($nome_plural) . ' found in Trash.',
        );
        
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true,
            'show_in_nav'       => true,
            'query_var'         => true,
            'hierarchical'      => false,
            'supports'          => array('title','editor','thumbnail'), 
            'has_archive'       => true,
            'menu_position'     => 20,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'dashicons-format-status'
        );
        
        register_post_type($post_slug, $args);      
        
        $has_been_flushed = get_option($post_slug . '_flush_rewrite_rules');
        //if we haven't flushed re-write rules, flush them (should be triggered only once)
        if($has_been_flushed != true){
            flush_rewrite_rules(true);
            update_option($post_slug . '_flush_rewrite_rules', true);
        }

    }


}
?>