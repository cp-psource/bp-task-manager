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

if ( ! function_exists('bp_is_active') ) {
	echo '<div id="message" class="info">';
		esc_html_e( 'Bitte installiere und aktiviere BuddyPress, um diese Funktion zu nutzen.', 'bp-projekt-manager' );
	echo '</div>';
	return;
}
?>

<?php if ( bp_is_active( 'groups' ) ) { ?>

<?php $user_access = PSourceProjektManagerCT::get_instance(); ?>

<?php $__post = PSourceProjektManager::get_post(); ?>

<?php $core = new PSourceProjektManagerCore(); ?>

	<div id="task_breaker-project">

		<?php if ( $user_access->can_view_project( $args->ID ) ) { ?>

			<?php include $core->get_template_directory() . '/project-heading.php'; ?>
			
			<div class="task_breaker-project-tabs">

				<ul id="task_breaker-project-tab-li">
					<li class="task_breaker-project-tab-li-item active">
						<a data-content="task_breaker-project-dashboard" class="task_breaker-project-tab-li-item-a" href="#tasks/dashboard">
							<?php esc_html_e( 'Dashboard', 'bp-projekt-manager' ); ?>
						</a>
					</li>
					<li class="task_breaker-project-tab-li-item">
						<a data-content="task_breaker-project-tasks" class="task_breaker-project-tab-li-item-a" href="#tasks">
							<?php esc_html_e( 'Aufgaben', 'bp-projekt-manager' ); ?>
						</a>
					</li>
					<li class="task_breaker-project-tab-li-item">
						<a data-content="task_breaker-project-add-new" id="task_breaker-project-add-new" class="task_breaker-project-tab-li-item-a" href="#tasks/add">
							<?php esc_html_e( 'Neues hinzufügen', 'bp-projekt-manager' ); ?>
						</a>
					</li>
					<li class="task_breaker-project-tab-li-item">
						<a data-content="task_breaker-project-edit" id="task_breaker-project-edit-tab" class="task_breaker-project-tab-li-item-a" href="#">
							<?php esc_html_e( 'Bearbeiten', 'bp-projekt-manager' ); ?>
						</a>
					</li>
					<?php if ( $user_access->can_edit_project( $__post->ID ) ) { ?>
						<li class="task_breaker-project-tab-li-item">
							<a data-content="task_breaker-project-settings" class="task_breaker-project-tab-li-item-a" href="#tasks/settings">
								<?php esc_html_e( 'Einstellungen', 'bp-projekt-manager' ); ?>
							</a>
						</li>
					<?php } ?>
				</ul>

			</div><!--.task_breaker-project-tabs-->
			<div id="task_breaker-project-tab-content">
				<?php
					if ( $__post->post_type === 'project' ) {
						include $core->get_template_directory() . '/project.php';
					}
				?>
			</div>

		<?php } else { ?>

			<div id="task-breaker-access-project-not-allowed" class="row">
				<div class="col-xs-12">
					<div class="task-breaker-message info">
						<?php esc_attr_e( 'Auf dieses Projekt können nur Gruppenmitglieder zugreifen. Verwende die Schaltfläche unten, um der Gruppe beizutreten und Zugriff auf dieses Projekt zu erhalten.', 'bp-projekt-manager' ); ?>
					</div>
				</div>
			</div>

			<?php $group_id = absint( get_post_meta( $args->ID, 'task_breaker_project_group_id', true ) ); ?>

			<?php $group = groups_get_group( array( 'link_class' => 'button', 'group_id' => $group_id ) ); ?>

			<?php $join_link = wp_nonce_url( bp_get_group_permalink( $group ) . 'join', 'groups_join_group' ); ?>

			<a class="button" href="<?php echo esc_url( $join_link ); ?>" title="<?php esc_attr_e( 'Gruppe beitreten', 'bp-projekt-manager' ); ?>">
				<?php esc_attr_e( 'Gruppe beitreten', 'bp-projekt-manager' ); ?>
			</a>

		<?php } ?>
	</div><!--#task_breaker-project-->
<?php } else { ?>
	<p id="message" class="info">
		<?php _e( 'Bitte aktiviere BuddyPress Gruppenkomponenten.', 'bp-projekt-manager' ); ?>
	</p>
<?php } ?>
