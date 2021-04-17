<?php
/**
 * Fires at the top of the members directory template file.
 *
 * @since Task Breaker 1.0
 */
do_action( 'task_breaker_before_projects_directory' ); ?>

<?php $core = new PSourceProjektManagerCore(); ?>

<?php $template = new PSourceProjektManagerTemplate(); ?>

<div id="buddypress">

	<div id="task_breaker-intranet-projects">

	<?php if ( bp_is_active( 'groups' ) ) { ?>

		<?php $template->display_new_project_modal(); ?>

		<?php $template->display_project_loop(); ?>

	<?php } else { ?>

			<p id="message" class="info">

				<?php _e( 'Bitte aktiviere BuddyPress Gruppen Komponente, um auf die Projekte zuzugreifen.', 'bp-projekt-manager' ); ?>

			</p>

	<?php } ?>

	</div><!--#task_breaker-intranet-projects-->

</div><!-- #buddypress -->

<?php
do_action( 'task_breaker_after_projects_directory' );
