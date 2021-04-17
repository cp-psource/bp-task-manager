<?php
/**
 * Task Breaker CSS and Javascript Loader
 *
 * @since 0.0.1
 * @package PSourceProjektManager\PSourceProjektManagerEnqueue
 */

if ( ! defined( 'ABSPATH' ) ) { 
	return; 
}

/**
 * Enqueues and register all PSourceProjektManager Javascript and CSS.
 *
 * @package PSourceProjektManager\PSourceProjektManagerEnqueue
 */
final class PSourceProjektManagerEnqueue {

	/**
	 * This variable holds the current version of PSourceProjektManager.
	 *
	 * @var float The PSourceProjektManager Version.
	 */
	private $version = 1.0;

	/**
	 * Load front scripts and register our project configuration
	 *
	 * @return void
	 */
	public function __construct() {

		$this->version = TASK_BREAKER_VERSION;

		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
		add_action( 'wp_footer', array( $this, 'register_config' ) );

		return;
	}

	/**
	 * Register front-end styling and front-end js.
	 *
	 * @return void
	 */
	public function front_scripts() {

		// Front-end stylesheet.
		wp_enqueue_style( 'taskbreaker-stylesheet', TASK_BREAKER_ASSET_URL . '/css/style.css', array(), $this->version );

		// Administrator JS.
		if ( is_admin() ) {
			wp_enqueue_script(
				'task_breaker-admin',
				TASK_BREAKER_ASSET_URL . '/js/admin.js',
				array( 'jquery', 'backbone' ),
				$this->version, true
			);
		}

		// Front-end JS.
		if ( is_singular( TASK_BREAKER_PROJECT_SLUG ) ) {

			wp_enqueue_script(
				'task_breaker-js',
				TASK_BREAKER_ASSET_URL . 'js/task-breaker.min.js',
				array( 'jquery', 'backbone' ),
				$this->version, true
			);

			// Localize TB js strings.
			$translation_array = array(
				'file_error' => __( 'Beim Hochladen Deiner Datei ist ein Fehler aufgetreten. Die Dateigröße hat die zulässige Anzahl von Bytes pro Anforderung überschritten', 'bp-projekt-manager' ),
				'file_attachment_error' => __('Die Anwendung hat keine Antwort vom Server erhalten. Versuche kleinere Dateien hochzuladen.', 'bp-projekt-manager'),
				'tasks_not_found' => __('Keine Aufgaben gefunden. Probiere verschiedene Schlüsselwörter und Filter aus.','bp-projekt-manager'),
				'comment_confirm_delete' => __('Möchtest Du diesen Kommentar wirklich löschen? Diese Aktion ist irreversibel.', 'bp-projekt-manager'),
				'comment_error' => __('Transaktionsfehler: Beim Versuch, diesen Kommentar zu löschen, ist ein Fehler aufgetreten.', 'bp-projekt-manager'),
				'project_confirm_delete' => __('Möchtest Du dieses Projekt wirklich löschen? Alle Tickets im Rahmen dieses Projekts werden ebenfalls gelöscht. Diese Aktion kann nicht rückgängig gemacht werden.', 'bp-projekt-manager'),
				'project_error' => __('Beim Löschen dieses Beitrags ist ein Fehler aufgetreten. Versuche es später erneut.', 'bp-projekt-manager'),
				'project_label_btn_update' => __('Projekt aktualisieren', 'bp-projekt-manager'),
				'project_authentication_error' => __('Nur Gruppenadministratoren und Moderatoren können die Projekteinstellungen aktualisieren.', 'bp-projekt-manager'),
				'project_all_fields_required' => __('Beim Speichern des Projekts ist ein Fehler aufgetreten. Alle Felder sind erforderlich.', 'bp-projekt-manager'),
				'task_error_500' => __('Unerwarteter Fehler (500)', 'bp-projekt-manager'),
				'task_unexpected_error' => __('Unerwarteter Fehler bei der Anforderung', 'bp-projekt-manager'),
				'task_confirm_delete' => __('Möchtest Du diese Aufgabe wirklich löschen? Diese Aktion ist irreversibel', 'bp-projekt-manager'),
				'task_updated' => __('Aufgabe erfolgreich aktualisiert', 'bp-projekt-manager'),
				'task_view' => __('Ansehen', 'bp-projekt-manager'),
				'task_update_error' => __('Beim Aktualisieren der Aufgabe ist ein Fehler aufgetreten. Alle Felder sind erforderlich.', 'bp-projekt-manager'),
				'task_unauthorized_error' => __('Du darfst diese Aufgabe nicht ändern. Es sind nur Gruppenprojektadministratoren und Gruppenprojektmoderatoren zulässig.', 'bp-projekt-manager'),
				'file_attachment_delete' => __('Möchtest Du diesen Dateianhang wirklich löschen? Dieser Vorgang ist nicht umkehrbar.', 'bp-projekt-manager')
			);

			wp_localize_script( 'task_breaker-js', 'taskbreaker_strings', $translation_array );

			wp_enqueue_script(
				'task_breaker-select2',
				TASK_BREAKER_ASSET_URL . 'js/plugins/select2.min.js',
				array( 'jquery', 'backbone' ),
				$this->version, true
			);
			
			// jQuery IU Date Picker.
			wp_enqueue_script('jquery-ui-slider', array('jquery'));
			wp_enqueue_script('jquery-ui-datepicker', array('jquery'));

			wp_enqueue_style(
				'jquery-ui-style',
				TASK_BREAKER_ASSET_URL . 'css/jquery-ui.css',
				false, 
				'1.9.0'
			);

			// AddOn Time Picker
			wp_enqueue_style( 'jquery-ui-timepicker-style', 
				TASK_BREAKER_ASSET_URL . 'css/jquery-ui-timepicker-addon.min.css', 
				array(), 
				$this->version 
			);
			
			wp_enqueue_script('jquery-ui-timepicker', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', 
				array('jquery', 'jquery-ui-datepicker'),
				$this->version, true);
			
		}

		// Project Archive JS.
		wp_enqueue_script(
			'task_breaker-archive-js',
			TASK_BREAKER_ASSET_URL . 'js/archive.js', array( 'jquery', 'backbone' ),
			1.0, true
		);

		return;

	}

	/**
	 * Register the project configuration.
	 *
	 * @return void
	 */
	public function register_config() {

		if ( is_singular( TASK_BREAKER_PROJECT_SLUG ) ) { ?>
			<script>
				var task_breakerAjaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
				var task_breakerTaskConfig = {
		  			currentProjectId: '<?php echo absint( get_queried_object_id() ); ?>',
		  			currentUserId: '<?php echo absint( get_current_user_id() ); ?>',
				}
			</script>
		<?php
		}

		return;

	}

}
$taskbreaker_enqueue = new PSourceProjektManagerEnqueue();
?>
