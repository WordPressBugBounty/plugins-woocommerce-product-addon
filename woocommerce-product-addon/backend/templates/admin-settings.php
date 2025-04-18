<?php
/**
 * Admin Settings Panel Template
 **/

/* 
**========== Block direct access =========== 
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$admin_url   = admin_url( 'admin-post.php' );
$migrate_url = add_query_arg(
	array(
		'action'       => $class_ins->get_config( 'id' ) . '_migrate_settings_panel',
		'old_settings' => 'yes',
	),
	$admin_url
);

$migrate_url = wp_nonce_url( $migrate_url, 'ppom_migrate_nonce_action', 'ppom_migrate_nonce' );

?>
<!--<div id="nmsf-page-loader">-->
<!--	<div class="nmsf-spinner"></div>-->
<!--</div>-->
<!--<div class="nmsf-wrapper" id="nmsf-page" style="display:none">-->
<div class="nmsf-wrapper" id="nmsf-page">
	<div class="nmsf-content">

		<?php if ( $class_ins->get_config( 'form_tag' ) ) { ?>
		<form class="nmsf-form-js">
			<?php
		} 
		?>


			<?php 
			// nonce field
			wp_nonce_field( 'ppom_settings_nonce_action', 'ppom_settings_nonce' );
			?>

			<input type="hidden" name="action"
				   value="<?php echo esc_attr( $class_ins->get_config( 'id' ) ); ?>_settings_panel_action"/>
			<input type="hidden" name="nmsf_version"
				   value="<?php echo esc_attr( $class_ins->get_config( 'version' ) ); ?>"/>


			<!--Tabs & Panel Sections-->
			<div class="row">
				<div class="nmsf-cols col-md-12">
					<div class="nmsf-panels-area">
                        <p class="submit">
                            <input type="submit" class="woocommerce-save-button components-button is-primary"
                                   value="<?php _e( 'Save changes', 'woocommerce-product-addon' ); ?>"/>
                        </p>
						<?php
						foreach ( $tabs as $tab_id => $tab_meta ) {
							$panel_meta = isset( $tab_meta['panels'] ) ? $tab_meta['panels'] : array();
							$classes    = isset( $tab_meta['classes'] ) ? $tab_meta['classes'] : array();
							?>

							<div class="<?php echo implode( ' ', $classes ); ?> nmsf-panels-content"
								 data-panel-id="<?php echo esc_attr( $tab_id ); ?>">

								<div class="nmsf-panels-content-inner">

									<?php
									foreach ( $panel_meta as $panel_id => $subtab_meta ) {

										$id          = isset( $subtab_meta['id'] ) ? $subtab_meta['id'] : '';
										$title       = isset( $subtab_meta['title'] ) ? $subtab_meta['title'] : '';
										$desc        = isset( $subtab_meta['desc'] ) ? $subtab_meta['desc'] : '';
										$is_available = isset( $subtab_meta['is_available'] ) ? $subtab_meta['is_available'] : true;
										$active      = isset( $subtab_meta['active'] ) ? $subtab_meta['active'] : '';
										$is_sabpanel = isset( $subtab_meta['is_sabpanel'] ) ? $subtab_meta['is_sabpanel'] : '';
										$params      = isset( $subtab_meta['settings'] ) ? $subtab_meta['settings'] : array();

										// Change the settings position
										$params = $class_ins::settings_position_controller( $params );

										$is_checked = '';
										if ( $active == 'yes' ) {
											$is_checked = 'checked';
										}

										if ( $is_sabpanel ) {
											?>
											<input type="radio" name="tab_<?php echo esc_attr( $tab_id ); ?>"
												   class="nmsf-panel-handler"
												   id="nmsf-<?php echo esc_attr( $panel_id ); ?>" <?php echo esc_attr( $is_checked ); ?>>
											<label for="nmsf-<?php echo esc_attr( $panel_id ); ?>"
												   class="nmsf-label <?php  echo ! $is_available ? 'ppom-is-locked-section' : ''; ?>">
												<?php if ( ! $is_available ): ?>
                                                    <span class="dashicons dashicons-lock"></span>
												<?php endif; ?>
                                                <?php  echo esc_html( $title ); ?></label>
											<div class="nmsf-panel-settings-area <?php  echo ! $is_available ? 'ppom-is-locked-panel' : ''; ?>">
                                                <?php if ( ! $is_available ): ?>
                                                    <div class="ppom-notice-upsell"><p>
                                                            <?php echo sprintf( 
																// translators: %1$s: the name of plugin feature, %2$s: the upgrade link.
																__( '%1$s customization is not available on your current plan. %2$s plan to unlock the ability to fully enable and customize this functionality.', 'woocommerce-product-addon' ),
																esc_html( $title ),
																sprintf(
																	'<a href="%s" target="_blank">%s</a>',
																	esc_url( tsdk_translate_link( tsdk_utmify( PPOM_UPGRADE_URL, $id ) ) ),
																	__( 'Upgrade to the Pro', 'woocommerce-product-addon' )
																)
															); ?>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
												<span class="nmsf-panel-desc"><?php echo esc_html( $desc ); ?></span>
												<table class="nmsf-panel-table form-table">
													<?php
													if ( ! empty( $params ) ) {
														foreach ( $params as $id => $input_meta ) {

															$type                   = isset( $input_meta['type'] ) ? $input_meta['type'] : '';
															$title                  = isset( $input_meta['title'] ) ? $input_meta['title'] : '';
															$desc                   = isset( $input_meta['desc'] ) ? $input_meta['desc'] : '';
															$tooltip                = isset( $input_meta['tooltip'] ) ? $input_meta['tooltip'] : false;
															$hint                   = isset( $input_meta['hint'] ) ? $input_meta['hint'] : '';
															$type                   = isset( $input_meta['type'] ) ? $input_meta['type'] : '';
															$conditions             = isset( $input_meta['conditions'] ) ? $input_meta['conditions'] : array();
															$reference              = isset( $input_meta['reference'] ) ? $input_meta['reference'] : array();
															$ref_title              = isset( $reference['ref_title'] ) ? $reference['ref_title'] : '';
															$ref_link               = isset( $reference['ref_link'] ) ? $reference['ref_link'] : '';
															$video_title            = isset( $reference['ref_video_title'] ) ? $reference['ref_video_title'] : '';
															$video_link             = isset( $reference['ref_video_link'] ) ? $reference['ref_video_link'] : '';
															$input_meta['input_id'] = $id;
															$condition_class = '';
															$is_input_available = isset( $input_meta['is_available'] ) ? $input_meta['is_available'] : $is_available;
															if ( ! $is_input_available ) {
																$condition_class .= 'ppom-is-locked-field';
																$input_meta['input_id'] = '_locked' . $input_meta['input_id'];
															}
															if ( ! empty( $conditions ) ) {
																$condition_class .= 'nmsf-panel-conditional-field';
															}

															?>

															<?php if ( $type == 'section' ) { ?>
																<tr
																		data-conditions="<?php echo esc_attr( json_encode( $conditions ) ); ?>"
																		class="<?php echo $condition_class; ?>"
																>
																	<td class="nmsf-section-type" colspan="2">
																		<?php if ( $is_available && !$is_input_available ): ?>
                                                                            <div class="ppom-notice-upsell"><p>
																					<?php echo sprintf(
																						// translators: %1$s: the name of plugin feature, %2$s: opening anchor tag.
																						__( '%1$s customization is not available on your current plan. %2$s plan to unlock the ability to fully enable and customize this functionality.', 'woocommerce-product-addon' ),
																						esc_html( $title ),
																						sprintf(
																							'<a href="%s" target="_blank">%s</a>',
																							esc_url( tsdk_translate_link( tsdk_utmify( PPOM_UPGRADE_URL, $id ) ) ),
																							__( 'Upgrade to the Pro', 'woocommerce-product-addon' )
																						)
																					); ?>
                                                                                </p>
                                                                            </div>
																		<?php endif; ?>
																		<h3>
																			<?php echo esc_html( $title ); ?>
																			<?php if ( ! empty( $desc ) ) { ?>
																				<span class="nmsf-field-desc"><?php echo $desc; ?></span>
																			<?php } ?>
																		</h3>
																	</td>
																</tr>
															<?php } else { ?>
																<tr
																		data-conditions="<?php echo esc_attr( json_encode( $conditions ) ); ?>"
																		class="<?php echo $condition_class; ?>"
																>
																	<th>
																		<label for=""><?php echo $title; ?></label>

																		<?php if ( $tooltip ) { ?>
																			<span class="nmsf-tooltip"
																				  title="<?php echo $desc; ?>">
																			<i class="dashicons dashicons-editor-help"></i>
																		</span>

																			<!--Tips Area-->
																			<?php if ( ! empty( $reference ) ) { ?>
																				<span class="nmsf-ref-area">
																				<?php if ( $ref_link != '' ) { ?>
																				<a href="<?php echo esc_url( $ref_link ); ?>"
																				   target="_blank">
																					<span class="dashicons dashicons-admin-links"></span>
																					<?php echo $ref_title; ?>
																				</a>
																			<?php } ?>

																					<?php if ( $video_link != '' ) { ?>
																						<a class="nmsf-ref-video-popup"
																						   video-url="<?php echo esc_url( $video_link ); ?>">
																					<span class="dashicons dashicons-video-alt2"></span>
																						<?php echo $video_title; ?>
																				</a>
																					<?php } ?>
																		</span>
																			<?php } ?>

																		<?php } else { ?>
																			<span class="nmsf-field-desc"><?php echo $desc; ?></span>

																			<?php if ( ! empty( $reference ) ) { ?>
																				<span class="nmsf-ref-area">
																				<?php if ( $ref_link != '' ) { ?>
																				<a href="<?php echo esc_url( $ref_link ); ?>"
																				   target="_blank">
																					<span class="dashicons dashicons-admin-links"></span>
																					<?php echo $ref_title; ?>
																				</a>
																			<?php } ?>

																					<?php if ( $video_link != '' ) { ?>
																						<a class="nmsf-ref-video-popup"
																						   video-url="<?php echo esc_url( $video_link ); ?>">
																					<span class="dashicons dashicons-video-alt2"></span>
																						<?php echo $video_title; ?>
																				</a>
																					<?php } ?>
																		</span>
																				<?php
																			}
																		}
																		?>
																	</th>
																	<td>
																		<?php $class_ins->load_inputs( $input_meta ); ?>

																		<?php if ( $hint != '' ) { ?>
																			<span class="nmsf-hint-area">
																			<span><?php echo _e( 'Hint: ', 'woocommerce-product-addon' ); ?></span>
																			<?php echo esc_html( $hint ); ?>
																		</span>
																		<?php } ?>
																	</td>
																</tr>
																<?php
															}
														}
													}
													?>
												</table>
											</div>
											<?php
										} else {
											?>
											<div class="nmsf-panel-settings-area">
												<span class="nmsf-panel-desc"><?php echo $desc; ?></span>
												<table class="nmsf-panel-table">
													<?php
													if ( ! empty( $params ) ) {

														foreach ( $params as $id => $input_meta ) {

															$type  = isset( $input_meta['type'] ) ? $input_meta['type'] : '';
															$title = isset( $input_meta['title'] ) ? $input_meta['title'] : '';
															$desc  = isset( $input_meta['desc'] ) ? $input_meta['desc'] : '';
															$type  = isset( $input_meta['type'] ) ? $input_meta['type'] : '';
															?>
															<tr>
																<th>
																	<label for=""><?php echo $title; ?></label>
																	<span class=""><?php echo $desc; ?></span>
																</th>
																<td><?php $class_ins->load_inputs( $input_meta ); ?></td>
															</tr>
															<?php
														}
													}
													?>
												</table>
											</div>
											<?php
										}
									}
									?>

								</div>
							</div>
							<?php
						}
						?>
                        <p class="submit">
                            <input type="submit" class="woocommerce-save-button components-button is-primary"
                                   value="<?php _e( 'Save changes', 'woocommerce-product-addon' ); ?>"/>
                        </p>
					</div>
				</div>
			</div>


			<?php if ( $class_ins->get_config( 'form_tag' ) ) { ?>
		</form>
	<?php } ?>

	</div>
</div>
