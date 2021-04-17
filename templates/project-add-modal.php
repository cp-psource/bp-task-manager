<?php $template = new PSourceProjektManagerTemplate(); ?>

<?php $template->display_new_project_modal_button(); ?>

<div class="clearfix"></div>

<div id="task_breaker-new-project-modal">

	<div id="task_breaker-modal-content">

		<div id="task_breaker-modal-heading">

			<h5 class="alignleft">

				<?php _e( 'Neues Projekt hinzufügen', 'bp-projekt-manager' ); ?>

			</h5>

			<span id="task_breaker-modal-close" class="alignright">
				&times;
			</span>

			<div class="clearfix"></div>

		</div>

		<div id="task_breaker-modal-body">

			<?php $template->display_new_project_form( $group_id ); ?>

		</div>

		<div id="task_breaker-modal-footer">

			<small>

				<?php _e( "Tipp: Drücke die Taste <em>'Escape'</em> auf Deiner Tastatur, um dieses Formular auszublenden", 'bp-projekt-manager' ); ?>

			</small>

		</div>

	</div>

</div>
