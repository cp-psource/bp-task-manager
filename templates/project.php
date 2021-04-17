<?php
/**
 * This file is part of the PSourceProjektManager WordPress Plugin package.
 *
 * (c) Joseph Gabito <joseph@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package PSourceProjektManager\PSourceProjektManagerCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
?>

<?php $__post = PSourceProjektManager::get_post(); ?>

<?php $core = new PSourceProjektManagerCore(); ?>

<?php $template = new PSourceProjektManagerTemplate(); ?>

<div id="task_breaker-preloader">

	<div class="la-ball-clip-rotate la-sm">

		<div></div>

	</div>

</div>

<div class="active task_breaker-project-tab-content-item" 
data-content="task_breaker-project-dashboard" id="task_breaker-project-dashboard-context">

	<div id="task_breaker-dashboard-about">

		<h3><?php esc_html_e( 'Projektbeschreibung', 'bp-projekt-manager' ); ?></h3>

			<?php echo wp_kses_post( wpautop( do_shortcode( $__post->post_content ), true ) ); ?>

		<div class="clearfix"></div>

	</div><!--#task_breaker-dashboard-about-->

	<div id="task_breaker-dashboard-at-a-glance">
	
		<?php
		// Total tasks.
		$total     = intval( $core->count_tasks( $__post->ID ) );
		// Completed tasks.
		$completed = intval( $core->count_tasks( $__post->ID, $type = 'completed' ) );
		// Remaining Tasks.
		$remaining = absint( $total - $completed );
		?>
		<h3>
			<?php _e( 'Auf einen Blick', 'bp-projekt-manager' ); ?>
		</h3>
		<ul>
			<li>
				<div class="task_breaker-dashboard-at-a-glance-box">
					<h4>
						<span id="task_breaker-total-tasks-count" class="task_breaker-total-tasks">
							<?php printf( '%d', $total ); ?>
						</span>
					</h4>
					<p>
						<?php _e( 'Aufgaben insgesamt', 'bp-projekt-manager' ); ?>
					</p>
				</div>
			</li>

			<li>
				<a href="#tasks" class="task_breaker-dashboard-at-a-glance-box">
					<h4>
						<span id="task_breaker-remaining-tasks-count" class="task_breaker-remaining-tasks-count">
							<?php printf( '%d', $remaining ); ?>
						</span>
					</h4>
					<p><?php _e( 'Aufgabe(n) verbleibend', 'bp-projekt-manager' ); ?></p>
				</a>
			</li>

			<li>
				<a href="#tasks/completed" class="task_breaker-dashboard-at-a-glance-box">
					<h4>
						<span id="task-progress-completed-count" class="task-progress-completed">
							<?php printf( '%d', $completed ); ?>
						</span>
					</h4>
					<p><?php _e( 'Aufgabe(n) abgeschlossen', 'bp-projekt-manager' ); ?></p>
				</a>
			</li>

		</ul>

		<div class="clearfix"></div>

	</div><!--#task_breaker-dashboard-at-a-glance-->
</div>

<div class="task_breaker-project-tab-content-item" data-content="task_breaker-project-tasks" id="task_breaker-project-tasks-context">
	<?php
		$args = array(
			'project_id' => $__post->ID,
			'orderby' => 'priority',
			'order' => 'desc',
		);
	?>

	<?php $template->task_filters(); ?>

	<?php echo $template->render_tasks( $args ); ?>

</div><!--#task_breaker-project-tasks-context-->

<div class="task_breaker-project-tab-content-item" data-content="task_breaker-project-settings" id="task_breaker-project-settings-context">
	<?php $template->project_settings(); ?>
</div>

<div class="task_breaker-project-tab-content-item" data-content="task_breaker-project-add-new" id="task_breaker-project-add-new-context">
	<?php $template->task_add_form(); ?>
</div>

<div class="task_breaker-project-tab-content-item" id="task_breaker-project-edit-context">
	<?php $template->task_edit_form(); ?>
</div>

<script>
var task_breakerProjectSettings = {
	project_id: '<?php echo absint( $__post->ID ); ?>',
	nonce: '<?php echo wp_create_nonce( 'task_breaker-transaction-request' ); ?>',
	current_group_id: '<?php echo absint( get_post_meta( $__post->ID, 'task_breaker_project_group_id', true ) ); ?>',
	max_file_size: '<?php echo absint( wp_max_upload_size() ); ?>'
};
</script>
