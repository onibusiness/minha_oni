<?php if ( ! defined( 'ABSPATH' ) ) exit;

$unique_hash = substr( md5( $args['form_id'] ), 10, 5 ); ?>
<?php
	wp_nav_menu( array(
		'theme_location' => 'menu-onis', 
		'container' => 'ul', 
		'menu_class' => 'navbar-nav w-100  flex-row  p-0 py-4 mb-4',
	));
	?>


<script type="text/template" id="tmpl-um-member-grid-<?php echo esc_attr( $unique_hash ) ?>">
	<div class="atomic_card background_white py-4"> 
		<p class="escala1 bold onipink  mb-0"> Nossos onis </p>
		<p class="escala-1 mb-4">Clique para ver o perfil</p>
		<div class="row directory mt-4">
	

			<# if ( data.length > 0 ) { #>
				<# _.each( data, function( user, key, list ) {  #>
				
					<div id="um-member-{{{user.card_anchor}}}-<?php echo esc_attr( $unique_hash ) ?>" class="mb-4 text-center col-1 um-role-{{{user.role}}} {{{user.account_status}}} <?php if ( $cover_photos ) { echo 'with-cover'; } ?>">
					
			

						<?php 

						if ( $profile_photo ) { ?>
							<div class=" radius-<?php echo esc_attr( UM()->options()->get( 'profile_photocorner' ) ); ?>">
								<a href="{{{user.profile_url}}}" title="{{{user.display_name}}}">
									{{{user.avatar}}}
									<?php do_action( 'um_members_in_profile_photo_tmpl', $args ); ?>
								</a>
							</div>
						<?php } ?>

					
						<div class="um-member-card <?php if ( ! $profile_photo ) { echo 'no-photo'; } ?>">
							<?php if ( $show_name ) { ?>
								<div class="um-member-name mb-4 escala0 bold">
									<a class="escala0" href="{{{user.profile_url}}}" title="{{{user.display_name}}}">
										{{{user.display_name_html}}}
						
									</a>
								</div>
							<?php }

							// please use for buttons priority > 100
							do_action( 'um_members_just_after_name_tmpl', $args ); ?>
							{{{user.hook_just_after_name}}}


							<# if ( user.can_edit ) { #>
			
							<# } #>


							<?php do_action( 'um_members_after_user_name_tmpl', $args ); ?>
							{{{user.hook_after_user_name}}}


							<?php if ( $show_tagline && ! empty( $tagline_fields ) && is_array( $tagline_fields ) ) {
								foreach ( $tagline_fields as $key ) {
									if ( empty( $key ) ) {
										continue;
									} ?>

									<# if ( typeof user['<?php echo $key; ?>'] !== 'undefined' ) { #>
										<div class="um-member-tagline um-member-tagline-<?php echo esc_attr( $key ); ?>"
											data-key="<?php echo esc_attr( $key ); ?>">
											{{{user['<?php echo $key; ?>']}}}
										</div>
									<# } #>

								<?php }
							}

							if ( $show_userinfo ) { ?>

								<# var $show_block = false; #>

								<?php foreach ( $reveal_fields as $k => $key ) {
									if ( empty( $key ) ) {
										unset( $reveal_fields[ $k ] );
									} ?>
									<# if ( typeof user['<?php echo $key; ?>'] !== 'undefined' ) {
										$show_block = true;
									} #>
								<?php }

								if ( $show_social ) { ?>
									<# if ( ! $show_block ) { #>
										<# $show_block = user.social_urls #>
									<# } #>
								<?php } ?>

								<# if ( $show_block ) { #>
									<div class="um-member-meta-main">

										<?php if ( $userinfo_animate ) { ?>
											<div class="um-member-more">
												<a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a>
											</div>
										<?php } ?>

										<div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

											<?php foreach ( $reveal_fields as $key ) { ?>

												<# if ( typeof user['<?php echo $key; ?>'] !== 'undefined' ) { #>
													<div class="um-member-metaline um-member-metaline-<?php echo $key; ?>">
														<strong>{{{user['label_<?php echo $key;?>']}}}:</strong> {{{user['<?php echo $key;?>']}}}
													</div>
												<# } #>

											<?php }

											if ( $show_social ) { ?>
												<div class="um-member-connect">
													{{{user.social_urls}}}
												</div>
											<?php } ?>
										</div>

										<?php if ( $userinfo_animate ) { ?>
											<div class="um-member-less">
												<a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a>
											</div>
										<?php } ?>
									</div>
								<# } #>
							<?php } ?>

						</div>
					</div>

				<# }); #>
			<# } else { #>

				<div class="um-members-none">
					<p><?php echo $no_users; ?></p>
				</div>

			<# } #>

			<div class="um-clear"></div>
			</div>	</div>
	</div>
</script>
