<?php

final class PSourceProjektManagerActions {

	/**
	 * Attach all WordPress action hooks to the following class methods listed in __construct.
	 *
	 * @return  void.
	 */
	public function __construct() {

		add_action( 'before_delete_post', array( $this, 'project_delete_garbage_collection') );

	}

	/**
	 * Deletes all the task attachments inside a specific project
	 *
	 * @return void
	 */
	public function project_delete_garbage_collection( $project_id ) {

		if ( empty ( $project_id ) ) {
			return;
		}

		$set_upload_dir = false;

		$dbase = PSourceProjektManager::wpdb();

		$dbase_prefix = PSourceProjektManager::bp_core_get_table_prefix();

		$fs = new PSourceProjektManagerFileAttachment( $set_upload_dir );

		$task_table = $dbase_prefix . 'task_breaker_tasks';

		$task_meta_table = $dbase_prefix . 'task_breaker_task_meta';

		$task_comments_table = $dbase_prefix . 'task_breaker_comments';

		$task_user_assignment_table = $dbase_prefix . 'task_breaker_tasks_user_assignment';

		$stmt = $dbase->prepare("SELECT * FROM {$task_table} WHERE project_id = %d", $project_id, OBJECT );

		$project_tasks = $dbase->get_results( $stmt );

		if ( ! empty ( $project_tasks ) ) {

			// Delete all the tasks under the project.
			if ( $dbase->delete( $task_table, array( 'project_id' => absint( $project_id ) ), array( '%d' ) ) ) {

				foreach ( $project_tasks as $task ) {

					// Delete all task attachments under the task inside a specific project.
					if ( $fs->delete_task_attachments( $task->id ) ) {

						// Delete attachments "meta" after succesfully removing all the tasks attachments in the directory.
						if ( FALSE !== $dbase->delete( $task_meta_table, array( 'task_id' => $task->id ), array( '%d' ) ) ) {

							// Delete all task comments as well.
							if ( FALSE !== $dbase->delete( $task_comments_table, array( 'ticket_id' => $task->id ), array( '%d' ) )  ) {

								// Delete all user assignments.
								if ( $dbase->delete( $task_user_assignment_table, array( 'task_id' => $task->id ), array( '%d' ) ) === FALSE  ) {

									PSourceProjektManager::stop(__('Benutzerzuweisungen können nicht gelöscht werden. Bei der Datenbankabfrage ist ein Fehler aufgetreten.','bp-projekt-manager'));

								}

							} else {

								PSourceProjektManager::stop(__('Aufgabenkommentare können nicht gelöscht werden. Bei der Datenbankabfrage ist ein Fehler aufgetreten.', 'bp-projekt-manager'));

							}

						// End task meta deletion.
						} else {

							PSourceProjektManager::stop(__('Meta-Anhänge können nicht gelöscht werden. Bei der Datenbankabfrage ist ein Fehler aufgetreten.', 'bp-projekt-manager'));

						}
					// End Delete all task attachments under the task inside a specific project.
					} else {

						PSourceProjektManager::stop(__('Anhänge können nicht gelöscht werden. Bei der Datenbankabfrage ist ein Fehler aufgetreten.','bp-projekt-manager'));

					}

				} // End foreach.

			// End Delete all the tasks under the project.
			} else {

				PSourceProjektManager::stop(__('Aufgaben können nicht gelöscht werden. Bei der Datenbankabfrage ist ein Fehler aufgetreten. ','bp-projekt-manager'));

			}
		} // End not empty.

		return;

	} // End method.
}

new PSourceProjektManagerActions();
