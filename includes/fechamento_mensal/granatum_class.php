<?php

/*
* Faz a requisição ao granatum
*
*/
class granatum{
    
    private $chave_granatum;//chave de acesso API
    private $headers;//headers de conexão CURL
    public $p_dia;//primeiro dia da requisição
    public $u_dia;//ultimo dia da requisicao
    public $h_dia;//ultimo dia do mês seguinte à requisição (para lidar com vencimentos)
    public $dias_uteis;//dias_uteis da requisição 

    public $contas;//contas do granatum
    public $centros_custo_lucro;//centros de custo e lucro
    public $categorias;//categorias
    public $n_lancamentos_cartao;//número de lancamentos no cartão
    public $n_lancamentos_conta;//número de lancamentos no cartão
    public $n_lancamentos;//número total de lancamentos
    public $lancamentos_cartao;//lançamentos do cartão
    public $lancamentos_conta;//lançamentos da conta


    public function __construct(){
        //Setando a chave do granatum
        $this->pegaChaveGranatum();
        //Setando os headers
        $this->setaHeaders();
        //Setando as datas
        $this->setaDatas();

        //Pegando as contas
        $this->puxaContas();
        //Pegando os centros de custo e lucro
        $this->puxaCentrosCustoLucro();
        //Pegando as categorias
        $this->puxaCategorias();
        //contando os lançamentos do cartão
        $this->contaLancamentosCartao();
        //contando os lançamentos da conta
        $this->contaLancamentosConta();

        //consolida o número total de lancamentos
        $this->somaLancamentos();

        //Puxa lançamentos do cartão
        $this->puxaLancamentosCartao();
        //Puxa lançamentos da conta
        $this->puxaLancamentosConta();
    }
    //Pegando a chave do granatum da página de opções
    public function pegaChaveGranatum(){
        $this->chave_granatum = get_field('chave_granatum', 'option');
    }
    //Criando o header
    public function setaHeaders(){
        $this->headers = array('Content-Type: application/x-www-form-urlencoded');
    }
    //Seta as datas
    public function setaDatas(){
        $primeiro_dia_mes_passado = strtotime("first day of last month");
        $ultimo_dia_mes_passado = strtotime("last day of last month");
        $this->p_dia = date('Y-m-d', $primeiro_dia_mes_passado);
        $this->u_dia = date('Y-m-d', $ultimo_dia_mes_passado);

        if (($_POST['form_action']['Filtrar'])){
            $this->p_dia = $_POST['data_inicial'];
            $this->u_dia = $_POST['data_final'];
            $this->h_dia = $_POST['data_final'];
        } 
        $u_dia_date= strtotime($this->u_dia);
        $uu_dia = strtotime("last day of next month",$u_dia_date);
        $this->h_dia = date('Y-m-d', $uu_dia);  

        $this->dias_uteis = minha_oni::contaDiasUteis( strtotime($this->p_dia), strtotime($this->u_dia)); 

    }

    //soma os lançamentos
    public function somaLancamentos(){
        $this->n_lancamentos = $this->n_lancamentos_cartao[0] + $this->n_lancamentos_conta[0]; 

    }

    //puxando as contas
    public function puxaContas(){   
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/contas?access_token='.$this->chave_granatum);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $this->contas = json_decode($result, true);

        curl_close($ch);
    }

    //puxando os centros de custo e lucro
    public function puxaCentrosCustoLucro(){   
       
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/centros_custo_lucro?access_token='.$this->chave_granatum);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $this->centros_custo_lucro = json_decode($result, true);

        curl_close($ch);
    }

    //puxando as categorias
    public function puxaCategorias(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/categorias?access_token='.$this->chave_granatum);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $this->categorias = json_decode($result, true);
        curl_close($ch);

    }

    //conta os lancamentos do cartao
    public function contaLancamentosCartao(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$this->chave_granatum);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "conta_id=55632&data_inicio=".$this->p_dia."&data_fim=".$this->h_dia."&tipo_view=count");
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $this->n_lancamentos_cartao = json_decode($result, true);

        curl_close($ch);
    }

    //conta os lancamentos da conta
    public function contaLancamentosConta(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$this->chave_granatum);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "conta_id=39820&data_inicio=".$this->p_dia."&data_fim=".$this->h_dia."&tipo_view=count");
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $this->n_lancamentos_conta = json_decode($result, true);

        curl_close($ch);
    }

    //puxa os lancamentos do cartão
    public function puxaLancamentosCartao(){
        $n_paginas = ceil($this->n_lancamentos/50);

        $chs = [];
        $mh = curl_multi_init();
        $running = null;
        $i = 0;
        while($i <= $n_paginas):
            $chs[$i] = curl_init();
            curl_setopt($chs[$i], CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$this->chave_granatum);
            curl_setopt($chs[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chs[$i], CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($chs[$i], CURLOPT_POSTFIELDS, "conta_id=55632&data_inicio=".$this->p_dia."&data_fim=".$this->h_dia."&start=".$i*50);
            curl_setopt($chs[$i], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            

            curl_setopt($chs[$i], CURLOPT_HTTPHEADER, $this->headers);
        
            curl_multi_add_handle($mh, $chs[$i]);
        
            $i++;
        
        endwhile;
        
        
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while($running > 0);
        foreach ($chs as $key => $ch) {
            if (curl_errno($ch)) {
                $this->lancamentos_cartao[$key] = curl_error($ch);
            } else {
                $this->lancamentos_cartao[$key] =  curl_multi_getcontent($ch);
            }
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
    }

    //puxa os lancamentos da conta
    public function puxaLancamentosConta(){
        $n_paginas = ceil($this->n_lancamentos/50);


        $chs = [];
        $mh = curl_multi_init();
        $running = null;
        $i = 0;
        while($i <= $n_paginas):
            $chs[$i] = curl_init();
            curl_setopt($chs[$i], CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$this->chave_granatum);
            curl_setopt($chs[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chs[$i], CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($chs[$i], CURLOPT_POSTFIELDS, "conta_id=39820&data_inicio=".$this->p_dia."&data_fim=".$this->h_dia."&start=".$i*50);
            curl_setopt($chs[$i], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            
      
            curl_setopt($chs[$i], CURLOPT_HTTPHEADER, $this->headers);
        
            curl_multi_add_handle($mh, $chs[$i]);
        
            $i++;
        
        endwhile;
        
        
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while($running > 0);
        foreach ($chs as $key => $ch) {
            if (curl_errno($ch)) {
                $this->lancamentos_conta[$key] = curl_error($ch);
            } else {
                $this->lancamentos_conta[$key] =  curl_multi_getcontent($ch);
            }
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
    }



}
//Criando o objeto
$granatum = new granatum;


?>



