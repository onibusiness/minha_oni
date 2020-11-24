<?php
/*
* Minha Oni
* Classe que controla tudo que acontece no tema
*/

class minha_oni{

    //variaveis
    public $diretorio_tema = '';

    //disparando a classe
    public function __construct(){

        $this->setaDiretorioTema();

        //inserindo todos os custom post types      
        require_once($this->diretorio_tema.'/includes/comunicados/comunicados_class.php');  
        require_once($this->diretorio_tema.'/includes/tutoriais/tutoriais_class.php');
        require_once($this->diretorio_tema. '/includes/competencias/competencias_class.php');
        require_once($this->diretorio_tema.'/includes/evidencias/evidencias_class.php');
        require_once($this->diretorio_tema.'/includes/evidencias/processa_evidencias_class.php');
        require_once($this->diretorio_tema.'/includes/competencias/processa_competencias_class.php');
        require_once($this->diretorio_tema.'/includes/ferramentas/ferramentas_class.php');
        require_once($this->diretorio_tema.'/includes/fechamento_mensal/fechamento_mensal_class.php');
        require_once($this->diretorio_tema.'/includes/ferias/ferias_class.php');
        require_once($this->diretorio_tema.'/includes/papeis/papeis_class.php');
        require_once($this->diretorio_tema.'/includes/advertencias/advertencias_class.php');

        //Pegando as customizações do acf 
        require_once($this->diretorio_tema.'/includes/acf/acf_class.php');

        //funcionalidades que o tema suporta
        add_action('after_setup_theme', array($this,'suporteTema')); 

        //Ajustando o carregamento dos scripts e estilos
        add_action('wp_enqueue_scripts', array($this,'ajustaRequisicoes')); 

        //Removendo suporte a emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');



    }
    //Setando o diretório do tema
    public function setaDiretorioTema(){
        $this->diretorio_tema = get_stylesheet_directory();
    }

    //O que o tema suporta
    public function suporteTema(){
        add_theme_support( 'sensei' );

    }

    //Mexendo na ordem de requisição dos estilos e scripts
    public function ajustaRequisicoes(){
        wp_deregister_script( 'wp-embed' );
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);

        // Deregister ACF Form style
        wp_deregister_style('acf-global');
        wp_deregister_style('acf-input');
        // Avoid dependency conflict
        wp_register_style('acf-global', false);
        wp_register_style('acf-input', false);
    }



    
    /**
     * Conta os dias úteis entre duas datas.
     *
     * @param date $date1 Data inicial
     * @param date $date2 Data final
     * @param bol $workSat Trabalhar no sábado ou não
     * @return Int  com o número de dias
     */
    public function contaDiasUteis($date1, $date2, $workSat = FALSE) {
        if (!defined('SATURDAY')) define('SATURDAY', 6);
        if (!defined('SUNDAY')) define('SUNDAY', 0);
        $ano = date('Y', $date1);
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
        for ($i = $date1; $i <= $date2; $i = strtotime("+1 day", $i)) {
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




}

//Criando o objeto
$minha_oni = new minha_oni;
?>