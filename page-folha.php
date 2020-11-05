<?php
/*
Template Name: Folha
*/ 
?>
<?php get_header();?>

<?php include_once( 'template-parts/variaveis_datas.php' );?>

<div class="row py-5">
    <div class="col-12 ">
        <form method="post" action="" class='card '>
            <p>Data inicial:
                <input type="date" name="data_inicial" value="<?php echo $p_dia ?>">
            </p>
            <p>Data final:
                <input type="date" name="data_final" value="<?php echo $u_dia ?>">
            </p>
            <input name="form_action[Filtrar]" type="submit" value="Filtrar">
        
            <input name="form_action[Salvar]" type="submit" value="Salvar"  onclick="return confirm('Você quer consolidar a folha??');">
            
        </form> 
    </div>
</div>
<div class="container-fluid">
    <?php get_template_part( 'template-parts/puxagranatum' );?>
 

    <div class="row py-5">
        <div class="col-12 ">
         
        </div>
    </div>
</div>

<?php get_footer(); ?>