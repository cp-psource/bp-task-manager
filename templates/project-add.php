<?php if ( bp_is_active( 'groups' ) ) { ?>
<?php $core = new PSourceProjektManagerCore(); ?>

	<div id="task_breaker-project-add-new-form">

		<form id="task_breaker-project-add-new-form-form" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post">

			<?php wp_nonce_field( 'task_breaker-transaction-request', 'nonce' ); ?>

			<input type="hidden" name="method"  value="task_breaker_transactions_update_project" />

			<input type="hidden" name="action"  value="task_breaker_transactions_request" />

			<input type="hidden" name="no_json" value="yes" />

			<div class="task_breaker-form-field hide" id="project-add-modal-js-message"></div>

			<div class="task_breaker-form-field">

				<?php $placeholder = __( 'Gib den neuen Titel für dieses Projekt ein', 'bp-projekt-manager' ); ?>

				<label for="task_breaker-project-name">

					<?php esc_html_e( 'Projektname', 'bp-projekt-manager' ); ?>

				</label>

				<input required placeholder="<?php esc_attr_e( $placeholder ); ?>" type="text" name="title" id="task_breaker-project-name" />

			</div>

			<div class="task_breaker-form-field">

				<label for="task_breaker-project-content">

				<?php esc_html_e( 'Projekt Details', 'bp-projekt-manager' ); ?>

				</label>

				<textarea id="task_breaker-project-content" name="content" rows="5"
				placeholder="<?php esc_html_e( 'Beschreibe worum es in diesem Projekt geht. Du kannst dies später bearbeiten.', 'bp-projekt-manager' );?>" required ></textarea>

			</div>

			<?php $current_user_groups = $core->get_current_user_owned_groups(); ?>

			<?php $group_id = 0; ?>

			<?php if ( bp_is_group_single() ) { ?>

					<?php $group_id = bp_get_group_id(); ?>

			<?php } ?>

			<?php if ( ! empty( $current_user_groups ) ) { ?>

				<div class="task_breaker-form-field">

					<label for="task_breaker-project-assigned-group">

						<?php esc_html_e( 'Gruppe zuordnen:', 'bp-projekt-manager' ); ?>

					</label>

					<?php if ( ! empty( $current_user_groups ) ) { ?>

						<select name="group_id" id="task_breaker-project-assigned-group">

							<?php foreach ( $current_user_groups as $group ) { ?>

									<?php $selected = ''; ?>

									<?php if ( ! empty( $group_id ) ) { ?>

										<?php if ( absint( $group_id ) === absint( $group->group_id ) ) { ?>

											<?php $selected = 'selected'; ?>

										<?php } ?>

									<?php } ?>

									<option <?php echo esc_attr_e( $selected );?> value="<?php echo esc_attr_e( absint( $group->group_id ) ); ?>">

										<?php echo esc_html( wp_unslash( $group->group_name ) ); ?>

									</option>

						<?php } ?>

					</select>


			<?php } ?>
				<div class="field-description">
					<p class="task-breaker-message info">
						<?php
						esc_attr_e( 'Du kannst einer Gruppe nur Projekte hinzufügen, wenn Du entweder der Administrator oder einer der Moderatoren bist.', 'bp-projekt-manager' );
						?>
					</p>
				</div>

			</div><!--.task_breaker-form-field-->

			<div class="task_breaker-form-field">

				<div class="alignright">

					<button id="task_breakerSaveProjectBtn" type="submit" class="button">

						<?php esc_attr_e( 'Projekt speichern', 'bp-projekt-manager' ); ?>

					</button>

				</div>

				<div class="clearfix"></div>

			</div><!--.task_breaker-form-field-->

	<?php } else { ?>

			<p class="task-breaker-message info">
				<?php $groups_url = trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() ); ?>
				<?php echo sprintf(
					esc_html__(
						'Nur ein Gruppenmoderator oder ein Gruppenadministrator kann ein Gruppenprojekt erstellen.
						%1$s Erstelle Deinee Gruppe %2$s oder %3$s schließe Dich einer vorhandenen %4$s an, um an Projekten teilzunehmen.',
						'bp-projekt-manager'
					),
					'<a target="__blank" href="'.esc_url( $groups_url . 'create' ).'" title="'.__('Gruppe erstellen', 'bp-projekt-manager').'">',
					'</a>',
					'<a target="__blank" href="'.esc_url( $groups_url ).'" title="'.__('Besuche Gruppen', 'bp-projekt-manager').'">',
					'</a>'
				); ?>
			</p><!--#message-->
	<?php } ?>
	</form><!--#task_breaker-project-add-new-form-form-->
</div><!--task_breaker-project-add-new-form-->

<?php } else { ?>
	<p id="message" class="info">
		<?php esc_html_e( 'Bitte aktiviere die BuddyPress Gruppen-Komponente, um ein neues Projekt zu erstellen', 'bp-projekt-manager' ); ?>
	</p>
<?php } ?>
