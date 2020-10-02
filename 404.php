
<?php get_header(); ?>

<div id="intro" class="grid-container full " >
	<div class="grid-x espacador_p ">
	</div>

	<div class="grid-x grid-padding-x grid-margin-x align-bottom ">
		<div class="cell large-1 large-offset-3">
			<div id="assinatura" >
				<img alt="Oni Design de Negócios" class="b-lazy"
			 src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== data-src="<?php echo bloginfo('template_directory'); ?>/img/oni.svg" style="height:100%;"/>
			</div>
		</div>
	</div>

	<div class="grid-x espacador_p ">
	</div>

	<div class="grid-x  grid-padding-x grid-margin-x " >
		<div class="cell large-9 large-offset-3 " >
			<?php $chamada = get_field('chamada', $post->ID); ?>
			<h1 class="bold escala6 petro">Erro 404</h1>
			<h2 class="bold escala3 pink"> Desculpe mas a p&aacute;gina que voc&ecirc; est&aacute; procurando n&atilde;o foi encontrada. </h2>
		</div>
	</div>
</div>


<?php get_footer(); ?>
