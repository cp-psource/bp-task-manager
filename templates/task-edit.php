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

<?php $user_access = PSourceProjektManagerCT::get_instance(); ?>
<?php $__post = PSourceProjektManager::get_post(); ?>
<?php $core = new PSourceProjektManagerCore(); ?>

<div id="task-breaker-task-edit-form" class="form-wrap">

	<?php if ( $user_access->can_update_task( $__post->ID ) ) { ?>

		<div id="task_breaker-edit-task-message" class="task_breaker-notifier"></div>

		<input type="hidden" id="task_breakerTaskId" />

		<!-- Task Title -->
		<div class="task_breaker-form-field">
			<input placeholder="<?php esc_attr_e( 'Aufgabenübersicht', 'bp-projekt-manager' ); ?>" type="text" id="task_breakerTaskEditTitle" maxlength="160" name="title" class="widefat"/>
		</div>

		<!-- Task Deadline -->
		<div class="task_breaker-form-field">
			<input name="deadline" id="js-edit-taskbreaker-deadline-field" type="text" placeholder="<?php esc_attr_e('Deadline', 'bp-projekt-manager'); ?>" class="js-taskbreaker-task-deadline">
		</div>

		<!-- Task User Assigned -->
		<div class="task_breaker-form-field">
			<select multiple id="task-user-assigned-edit" class="task-breaker-select2"></select>
		</div>

		<!-- Task Description -->
		<div class="task_breaker-form-field">
			<?php
				$args = array(
					'teeny' => true,
					'editor_height' => 100,
					'media_buttons' => false,
					'quicktags' => false,
				);
			?>
			<?php echo wp_editor( $content = null, $editor_id = 'task_breakerTaskEditDescription', $args ); ?>
		</div>

		<!-- Task Priority -->
		<div class="task_breaker-form-field">
			<label for="task_breaker-task-priority-select">
				<strong>
					<?php _e( 'Priorität:', 'bp-projekt-manager' ); ?>
				</strong>
				<?php
					$core->task_priority_select( 1, 'task_breaker-task-edit-priority', 'task_breaker-task-edit-select-id' );
				?>
			</label>
		</div>

		<!--file attachments-->
		<div class="task_breaker-form-field" id="taskbreaker-file-attachment-edit">
			<div class="taskbreaker-task-file-attachment">
				<div class="task-breaker-form-file-attachment">
					<input disabled type="file" name="file" id="task-breaker-form-file-attachment-edit-field" />
					<label for="task-breaker-form-file-attachment-edit-field">
						<strong class="tasbreaker-file-attached">
							<?php esc_html_e( 'Laden angehängter Dateien ...', 'bp-projekt-manager' ); ?>
						</strong>
						<div class="taskbreaker-task-attached-file"></div>
						<?php esc_html_e('Klicke hier um den Dateianhang zu aktualisieren', 'bp-projekt-manager'); ?>
						<?php echo sprintf( __('(maximale Dateigröße: %d MB)', 'bp-projekt-manager'), absint( $core->get_wp_max_upload_size() ) ); ?>
					</label>

				</div>
				<div class="tb-file-attachment-progress-wrap">
					<div class="tb-file-attachment-progress-text">
						<?php esc_html_e('Uploading', 'bp-projekt-manager'); ?>&hellip;<span class="taskbreaker-upload-progress-value">(0%)</span>
						<span class="taskbreaker-upload-success-text-helper">
							<?php esc_html_e('. Datei erfolgreich angehängt.', 'bp-projekt-manager'); ?>
						</span>
						<span class="taskbreaker-upload-error-text-helper">
							<?php esc_html_e('. Der Upload wurde erfolgreich initiiert, aber der Server konnte ihn nicht verarbeiten. Siehe Nachricht unten.', 'bp-projekt-manager'); ?>
						</span>
					</div>
					<div class="tb-file-attachment-progress">
						<div class="tb-file-attachment-progress-movable"></div>
					</div>

				</div>
				<div id="taskbreaker-unlink-file-btn" role="button"></div>
			</div>

		</div>

		<!--[if lte IE 9]>
			<div class="task_breaker-form-field ie-fallback ie-10">
				<label for="task_breaker-task-priority-select">
					<?php esc_html_e('Der Dateianhang ist für diesen Browser deaktiviert. Bitte aktualisiere auf die neueste Version', 'bp-projekt-manager'); ?>
				</label>
			</div>
		<![endif]-->
		<!-- end file attachments -->

		<!-- Task Controls -->
		<div class="task_breaker-form-field">

			<button id="task_breaker-delete-btn" class="button button-primary button-large" style="float:right; margin-left: 10px;">
				<?php esc_attr_e( 'Löschen', 'bp-projekt-manager' ); ?>
			</button>

			<button id="task_breaker-edit-btn" class="button button-primary button-large" style="float:right">
				<?php esc_attr_e( 'Aufgabe aktualisieren', 'bp-projekt-manager' ); ?>
			</button>

			<div style="clear:both"></div>
		</div>

	<?php }  else { ?>
		<p class="task-breaker-message info">
			<?php echo sprintf( esc_html__('Ops! Sieht aus als ob Dich verirrt hast. %s', 'bp-projekt-manager'), '<a href="#tasks">'.__('Go back to tasks.', 'bp-projekt-manager').'</a>'); ?>
		</p>
	<?php } ?>

</div><!--#task-breaker-task-edit-form-->
