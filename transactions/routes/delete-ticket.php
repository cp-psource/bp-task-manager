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

if ( ! is_user_logged_in() ) {
	return;
}

$ticket_id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

$project_id = filter_input( INPUT_POST, 'project_id', FILTER_VALIDATE_INT );

$task = PSourceProjektManagerTasksController::get_instance();

$delete_task = $task->deleteTask( $ticket_id, $project_id );

if ( $delete_task ) {

	$this->task_breaker_api_message(
		array(
			'message' => 'success',
			'response' => array(
				'id' => absint( $ticket_id ),
			),
			'stats' => $task->getTaskStatistics( absint( $project_id ) ),
		)
	);

} else {

	$this->task_breaker_api_message(
		array(
			'message' => 'fail',
			'type'    => 'unauthorized',
			'response' => array(
				'id' => absint( $ticket_id ),
			),
			'message_text' => esc_html__( 'Du darfst diese Aufgabe nicht löschen. Es sind nur Gruppenadministratoren oder Gruppenmoderatoren zulässig.', 'bp-projekt-manager' ),
			'stats' => $task->getTaskStatistics( absint( $project_id ) ),
		)
	);

}
