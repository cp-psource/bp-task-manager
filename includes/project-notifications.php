<?php
/**
 * This file contains the PSourceProjektManagerNotifications
 * which is responsible for our project notifications
 *
 * @since      1.0
 * @package    PSourceProjektManager\PSourceProjektManagerNotifications
 * @author     DerN3rd
 */

/**
 * PSourceProjektManagerNotifications handles the project notifications.
 *
 * @since      1.0
 * @package    PSourceProjektManager\PSourceProjektManagerNotifications
 * @author     DerN3rd
 */
final class PSourceProjektManagerNotifications {

	/**
	 * Class constructor.
	 *
	 * @return  void
	 */
	public function __construct() {

		add_filter( 'bp_notifications_get_registered_components', array( $this, 'tb_add_new_notification_component' ) );
		add_filter( 'bp_notifications_get_notifications_for_user', array( $this, 'tb_new_task_notification_text' ), 8, 5 );
		add_filter( 'task_breaker_new_task', array( $this, 'bp_custom_add_notification' ), 99, 2 );

		return;
	}

	/**
	 * Create callback function for 'bp_notifications_get_registered_components' filter in-order for us to register a new shortcode.
	 *
	 * @param array $component_names the existing components inside BuddyPress.
	 */
	function tb_add_new_notification_component( $component_names = array() ) {

		// Return safely if the parameter $component_names data type is not array.
		if ( ! is_array( $component_names ) ) {
			return;
		}

		// Push the 'task_breaker_ua_notifications_name' to components collection.
		array_push( $component_names, 'task_breaker_ua_notifications_name' );

		// Return the new $component_names collection with 'task_breaker_ua_notifications_name' already pushed inside the BuddyPress components collection.
		return $component_names;
	}

	/**
	 * The callback function for 'bp_notifications_get_notifications_for_user'.
	 *
	 * @param  mixed   $action            The notification action.
	 * @param  integer $item_id           The item ID.
	 * @param  integer $secondary_item_id The secondary item ID. Probably Groug ID.
	 * @param  integer $total_items       The total items.
	 * @param  string  $format            The format.
	 * @return string                      The notifcation output.
	 */
	function tb_new_task_notification_text( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

		$core = new PSourceProjektManagerCore();

		// New task_breaker_ua_notifications_name notifications.
		if ( 'task_breaker_ua_action' === $action ) {

            // Removed the bbp_format_buddypress_notifications() function
            // from the bp_notifications_get_notifications_for_user() filter
            // when the tb_new_task_notification_text() function is present.
            // To fix the PSourceProjektManager BuddyPress Notification Issue with bbPress
            remove_filter( 'bp_notifications_get_notifications_for_user', 'bbp_format_buddypress_notifications', 10, 5 );

			$task = $core->get_task( $item_id );

			if ( empty ( $task ) ) {
				$text = esc_html__('Dir wurde eine neue Aufgabe zugewiesen, die jedoch gelöscht wurde. Du kannst diese Benachrichtigung ignorieren.', 'bp-projekt-manager');
				$out = sprintf( '<a href="#" title="%1$s">%1$s</a>', $text );
				return $out;
			}

			$secondary_item_user = get_user_by( 'id', absint( $secondary_item_id ) );
			$secondary_item_user_name = $secondary_item_user->display_name;
			$project_id = absint( $task->project_id );

			// Customized notification title for new task.
			$notification_text = sprintf(
				'%s %s %s',
				esc_attr( $secondary_item_user_name ),
				__( ' hat Dir eine neue Aufgabe zugewiesen &mdash; ', 'bp-projekt-manager' ),
				esc_html( $task->title )
			);

			// Customized notification text for new task.
			$notification_title = sprintf(
				'%s %s %s',
				__( ' Du hast eine neue Aufgabe welche auf Dich wartet unter ', 'bp-projekt-manager' ),
				get_the_title( $project_id ),
				__( ' Projekt', 'bp-projekt-manager' )
			);

			// The link of the task.
			$notification_link  = trailingslashit( get_permalink( $project_id ) ) . '#tasks/view/' . $item_id;

			// WordPress Toolbar.
			if ( 'string' === $format ) {
				$out = apply_filters( 'custom_filter', '<a href="' . esc_url( $notification_link ) . '" title="' . esc_attr( $notification_title ) . '">' . esc_html( $notification_text ) . '</a>', $notification_text, $notification_link );
				// Deprecated BuddyBar.
			} else {
				$out = apply_filters(
					'custom_filter', array(
						'text' => $notification_text,
						'link' => $notification_link,
					), $notification_link, (int) $total_items, $notification_text, $notification_title
				);
			}

			return $out;

		}

	}
}

$taskbreaker_notifications = new PSourceProjektManagerNotifications();
