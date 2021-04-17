<?php
/**
 * This file is part of the PSourceProjektManager WordPress Plugin package.
 *
 * (c) Joseph G. <joseph@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package PSourceProjektManager\PSourceProjektManagerTransactions
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}


$task = PSourceProjektManagerTasksController::get_instance();

$user_access = PSourceProjektManagerCT::get_instance();

$task_id = $task->addTicket( $_POST );

if ( ! $user_access->can_add_task( (int) $_POST['project_id'] ) ) {
	$this->task_breaker_api_message(
		array(
			'message' => 'fail',
			'response' => __( 'Aufgaben können nicht hinzugefügt werden. Nur ein Gruppenadministrator oder ein Gruppenmoderator kann Aufgaben hinzufügen.', 'bp-projekt-manager' ),
		)
	);
}

if ( $task_id ) {

	do_action( 'taskbreaker_task_saved' );
	// Attach the file into the task.
	if ( !empty( $_POST['file_attachments'] ) ) {
		$taskbreaker_file_attachment = new PSourceProjektManagerFileAttachment();
		$taskbreaker_file_attachment->task_attach_file( $_POST['file_attachments'], $task_id );
	}

	$this->task_breaker_api_message(
		array(
			'message' => 'success',
			'response' => array(
					'id' => $task_id,
				),
			'stats' => $task->getTaskStatistics( (int) $_POST['project_id'] ),
		)
	);

} else {

	$this->task_breaker_api_message(
		array(
			'message' => 'fail',
			'response' => __(
				'Beim Versuch, diese Aufgabe hinzuzufügen, ist ein Fehler aufgetreten. Titel- und Beschreibungsfelder sind erforderlich oder es ist ein unerwarteter Fehler aufgetreten.', ' task_breaker'
			),
		)
	);
}
