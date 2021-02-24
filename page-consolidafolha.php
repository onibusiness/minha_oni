<?php
    $consolida_folha = get_stylesheet_directory() . '/includes/fechamento_mensal/consolida_folha_class.php';
    include($consolida_folha);
    
    wp_redirect(admin_url( '/edit.php?post_type=pagamentos' ));
    exit;

    ?>