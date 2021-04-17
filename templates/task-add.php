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

<div class="form-wrap">

	<?php if ( $user_access->can_add_task( $__post->ID ) ) { ?>

		<div id="task_breaker-add-task-message" class="task_breaker-notifier"></div>

		<!-- Task Title -->
		<div class="task_breaker-form-field">

			<input placeholder="<?php esc_attr_e( 'Zusammenfassung', 'bp-projekt-manager' ); ?>" type="text" id="task_breakerTaskTitle" maxlength="160" name="title"/>

		</div>

		<!-- Task Deadline -->
		<div class="task_breaker-form-field">
			<input id="js-add-taskbreaker-deadline-field" name="deadline" type="text" placeholder="<?php esc_attr_e('Deadline', 'bp-projekt-manager'); ?>" class="js-taskbreaker-task-deadline">
		</div>

		<!-- Task User Assigned -->
		<div class="task_breaker-form-field">
			<select multiple id="task-user-assigned" class="task-breaker-select2"></select>
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

		<?php echo wp_editor( $content = null, $editor_id = 'task_breakerTaskDescription', $args ); ?>

		</div>

		<!-- priority -->
		<div class="task_breaker-form-field">
			<label for="task_breaker-task-priority-select">
				<strong>
					<?php _e( 'Priorität:', 'bp-projekt-manager' ); ?>
				</strong>
				<?php $core->task_priority_select(); ?>
			</label>
		</div>
		<!--end priority-->
		<!--file attachments-->
		<div class="task_breaker-form-field" id="taskbreaker-file-attachment-add">
			<div class="taskbreaker-task-file-attachment">
				<div class="task-breaker-form-file-attachment">
					<input type="file" name="file" id="task-breaker-form-file-attachment-field" />
					<label for="task-breaker-form-file-attachment-field">
						<strong class="tasbreaker-file-attached">
							<?php esc_html_e( 'Keine Datei ausgewählt', 'bp-projekt-manager' ); ?>
						</strong>
						<div class="taskbreaker-task-attached-file"></div>
						<?php esc_html_e('Klicke hier, um eine Datei anzuhängen', 'bp-projekt-manager'); ?>
						<?php echo sprintf( __('(maximale Dateigröße: %d MB)', 'bp-projekt-manager'), absint( $core->get_wp_max_upload_size() ) ); ?>
					</label>
				</div>
				<div class="tb-file-attachment-progress-wrap">
					<div class="tb-file-attachment-progress-text">
						<?php esc_html_e('Hochladen', 'bp-projekt-manager'); ?>&hellip;<span class="taskbreaker-upload-progress-value">(0%)</span>
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
			</div>
			<input type="hidden" name="taskbreaker-file-attachment-field" class="taskbreaker-file-attachment-field" value="" />
		</div>

		<!--[if lte IE 9]>
			<div class="task_breaker-form-field ie-fallback ie-10">
				<label for="task_breaker-task-priority-select">
					<?php esc_html_e('Der Dateianhang ist für diesen Browser deaktiviert. Bitte aktualisiere auf die neueste Version', 'bp-projekt-manager'); ?>
				</label>
			</div>
		<![endif]-->
		<!-- end file attachments -->

		<div class="task_breaker-form-field">
			<button id="task_breaker-submit-btn" class="button button-primary button-large" style="float:right">
				<?php _e( 'Aufgabe speichern', 'dunhakdis' ); ?>
			</button>
			<div style="clear:both"></div>
		</div>
	<?php } else { ?>
		<div class="task-breaker-message danger">
			<?php esc_html_e( 'Ops! Nur Gruppenadministratoren oder Gruppenmoderatoren können diesem Gruppenprojekt Aufgaben hinzufügen.', 'bp-projekt-manager' ); ?>
		</div>
	<?php } ?>
</div>
