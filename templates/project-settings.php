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

<?php $template = new PSourceProjektManagerTemplate(); ?>

<?php if ( $user_access->can_edit_project( $__post->ID ) ) { ?>

<div id="task_breaker-project-settings">

    <input type="hidden" name="task_breaker-project-id" id="task_breaker-project-id" value="<?php echo absint( $__post->ID ); ?>" />

    <div class="task_breaker-form-field">

        <?php $placeholder = __( 'Gib den neuen Titel für dieses Projekt ein', 'bp-projekt-manager' ); ?>

        <?php $title = $__post->post_title; ?>

        <input value="<?php echo esc_attr( $title ); ?>" placeholder="<?php echo $placeholder; ?>" type="text" name="task_breaker-project-name" id="task_breaker-project-name" />

    </div>

    <div class="task_breaker-form-field">

        <?php $template->display_settings_editor(); ?>

        <span class="description">

            <?php esc_html_e( 'Erkläre worum es in diesem Projekt geht', 'bp-projekt-manager' ); ?>

		</span>

    </div>

    <div class="task_breaker-form-field">

        <label for="task_breaker-project-assigned-group">

            <?php esc_html_e( 'Gruppe zuordnen:', 'bp-projekt-manager' ); ?>

        </label>

        <?php $current_user_groups= $core->get_current_user_owned_groups(); ?>

        <?php $current_project_group= intval( get_post_meta( $__post->ID, 'task_breaker_project_group_id', true ) ); ?>

        <?php if ( ! empty( $current_user_groups ) ) { ?>

        <select name="task_breaker-project-assigned-group" id="task_breaker-project-assigned-group">

            <?php foreach ( $current_user_groups as $group ) { ?>

           		<?php $selected = absint( $group->group_id ) == $current_project_group ? 'selected' : '';?>

	            <option <?php echo $selected; ?> value="<?php echo absint( $group->group_id ); ?>">

	                <?php echo esc_html( $group->group_name ); ?>

	            </option>

            <?php } ?>

        </select>

        <?php } ?>

    </div>

    <div class="task_breaker-form-field">

        <div class="alignright">

            <button id="task_breakerUpdateProjectBtn" type="button" class="button">
                <?php esc_html_e( 'Projekt aktualisieren', 'bp-projekt-manager' ); ?>
            </button>

            <?php if ( $user_access->can_delete_project( $__post->ID ) ) { ?>

                <button id="task_breakerDeleteProjectBtn" type="button" class="button button-danger">
                    <?php esc_html_e( 'Löschen', 'bp-projekt-manager' ); ?>
                </button>

            <?php } ?>

        </div>

        <div class="clearfix"></div>

    </div>
</div>

<?php } else { ?>

<p id="message" class="danger task-breaker-message">
    <?php esc_html_e( 'Du kannst nicht auf diese Seite mit den Gruppenprojekteinstellungen zugreifen. Nur die Administratoren und Moderatoren dieser Gruppe dürfen darauf zugreifen.', 'bp-projekt-manager' ); ?>
</p>

<?php } ?>
