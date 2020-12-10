<?php get_header();?>
<style>
    .etapa{
        /*height:100%;*/
        font-size: 0.8rem;
        color: white !important;
    }
</style>
<div class="row">

<div class='col'>
    <p class='escala-1 petro bold mb-0'>Filtrar por gestor:</p>
    <a onclick='filterSelection("visao", this)' href="#" class="filtro-gestor bold badge badge-warning" >Visão</a>

    <a onclick='filterSelection("time", this)' href="#" class="filtro-gestor bold badge badge-info" >Time</a>

    <a onclick='filterSelection("metodo", this)' href="#" class="filtro-gestor bold badge badge-success" >Método</a>

    <a onclick='filterSelection("todos", this)' href="#" class="filtro-gestor bold badge badge-light" >Ver tudo</a>
</div>
</div>
<div class="row my-4"> 
    <p class="col-8 escala4 lightgrey bold mb-0">Gestão do projeto</p>
    <div class="col-4"> 


    </div>
    <div class="col-2">
        <p class="escala1 bold under_lightgrey">Setup</p>
        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center  mb-2" type="button" >Organização geral do projeto</a>
            </div>
        </div>
    </div>

    <div class="col">
        <p class="escala1 bold under_lightgrey">Start do projeto</p>
        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center visao time mb-2" type="button" >Alinhamento interno sobre o que foi vendido </a>
              
            </div>
           
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center visao time mb-2" type="button" >Project evisioning</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center visao time mb-2" type="button" >Planejamento inicial de projeto</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center visao time mb-2" type="button" >Análise de risco</a>
            </div>
        </div>
    </div>

    <div class="col">
        <p class="escala1 bold under_lightgrey">Fechamento de projeto</p>
        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center mb-2 visao" type="button" >Debrief com cliente</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center mb-2 visao time" type="button" >Empacotamentos</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-secondary d-flex align-items-center mb-2 time metodo" type="button" >Gestão de informação</a>
            </div>

        </div>
    </div> 
</div>
<div class="row my-4"> 
    <p class="col-12 escala4 lightgrey bold mb-0">Gestão das frentes</p>
    <div class="col">
        <p class="escala1 bold under_lightgrey">Start da frente</p>
        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2 visao time" type="button" >Revisitar riscos</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2 visao time metodo" type="button" >Planejamento da frente</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2 visao" type="button" >Requisitos de frente</a>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2 time" type="button" >Planejamento de missões</a>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2 metodo" type="button" >Abordagem metodológica</a>
            </div>

        </div>
    </div> 

    <div class="col">
        <p class="escala1 bold under_lightgrey">Sprints semanais</p>
        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2  visao time metodo" type="button" >Acompanhamento de missões</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2  visao time metodo" type="button" >Ajustes e falhas realtime</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2  visao time metodo" type="button" >Entrega</a>
            </div>

        </div>
    </div> 

    <div class="col">
        <p class="escala1 bold under_lightgrey">Fechamento de frente</p>
        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2 visao time metodo" type="button" >Retrô de resultados</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2  visao time metodo" type="button" >Avaliação e feedbacks</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-danger d-flex align-items-center mb-2  visao time metodo" type="button" >Documentação</a>
            </div>

        </div>
    </div> 
</div>

<div class="row my-4"> 
<p class="col-12 escala4 lightgrey bold mb-0">Assíncrono</p>
        <div class="col">

        <div class='row'>
            <div class='col'>
                <a href="#" class=" etapa btn btn-dark d-flex align-items-center visao" type="button" >Atrasos e pagamentos</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-dark d-flex align-items-center visao" type="button" >Alterações de dados ou pagamento</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-dark d-flex align-items-center visao time" type="button" >Aquisições e compras para o projeto</a>
            </div>
            <div class='col'>
                <a href="#" class=" etapa btn btn-dark d-flex align-items-center  visao time metodo" type="button" >Deslizes dos onis</a>
            </div>
        </div>
    </div>
</div>
<script>
    
function filterSelection(c,z) {
  var x, i, a;
  a = document.getElementsByClassName('etapa');
  var btns = document.getElementsByClassName("badge");
  for (b = 0; b < btns.length; b++) {     
        w3RemoveClass(btns[b], "badge-active");
        for (i = 0; i < a.length; i++) { 
        w3RemoveClass(a[i], "half-opacity");
        w3RemoveClass(a[i], "border-visao");
        w3RemoveClass(a[i], "border-metodo");
        w3RemoveClass(a[i], "border-time");
        }
    }
  if (z.className.indexOf('badge-active') > -1) {

  }else{
    if(c !== "todos"){
        w3AddClass(z, "badge-active");  
        for (i = 0; i < a.length; i++) { 
            if (a[i].className.indexOf(c) > -1){
                w3AddClass(a[i], "border-"+c);
            }else{
                w3AddClass(a[i], "half-opacity");
            
            }
        }  
    }
 
  }
 
   

}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}
</script>

<?php get_footer();?>