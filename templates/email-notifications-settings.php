<table class="notification-settings" id="friends-notification-settings">
    <thead>
        <tr>
            <th class="icon"></th>
            <th class="title">
                <?php
                    esc_html_e( 'Projektmanagement', 'bp-projekt-manager' ); 
                 ?>
            </th>
            <th class="yes">
                <?php
                    esc_html_e( 'Ja', 'bp-projekt-manager' ); 
                ?>
            </th>
            <th class="no">
                <?php
                    esc_html_e( 'Nein', 'bp-projekt-manager' ); 
                ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr id="friends-notification-settings-request">
            <td></td>
            <td>
                <?php
                    esc_html_e( 'Ein Mitglied des Projekts unter derselben Aufgabe hat ein neues Update hinzugefügt', 'bp-projekt-manager' ); ?>
            </td>
            <?php
                $task_breaker_comment_new = bp_get_user_meta( bp_displayed_user_id(), 'task_breaker_comment_new', true ); ?>
            <?php if ( ! $task_breaker_comment_new ) { ?>
            <?php $task_breaker_comment_new = 'yes'; ?>
            <?php } ?>
            <td class="yes">
                <input type="radio" name="notifications[task_breaker_comment_new]" 
                    id="task-breaker-comment-new-yes" value="yes" <?php
                        checked( $task_breaker_comment_new, 'yes', true ) ?> />
                <label for="task-breaker-comment-new-yes" class="bp-screen-reader-text">
                <?php
                    esc_html_e( 'Ja, E-Mail senden', 'bp-projekt-manager' ); ?>
                </label>
            </td>
            <td class="no">
                <input type="radio" name="notifications[task_breaker_comment_new]" 
                    id="task-breaker-comment-new-no" value="no" <?php
                        checked( $task_breaker_comment_new, 'no', true ) ?> />
                <label for="task-breaker-comment-new-no" class="bp-screen-reader-text">
                <?php
                    esc_html_e( 'Nein, keine E-Mail senden', 'bp-projekt-manager' ); ?>
                </label>
            </td>
        </tr>
        <tr id="friends-notification-settings-accepted">
            <td></td>
            <td>
                <?php
                    esc_html_e( 'Eine neue Aufgabe wird mir zugewiesen', 'bp-projekt-manager' ); ?>
            </td>
            <?php
                $task_breaker_task_new = bp_get_user_meta( bp_displayed_user_id(), 'task_breaker_task_new', true ); ?>
            <?php if ( ! $task_breaker_task_new ) { ?>
            <?php $task_breaker_task_new = 'yes'; ?>
            <?php } ?>
            <td class="yes">
                <input type="radio" name="notifications[task_breaker_task_new]" 
                    id="task-breaker-task-new-yes" value="yes" <?php
                        checked( $task_breaker_task_new, 'yes', true ) ?> />
                <label for="task-breaker-task-new-yes" class="bp-screen-reader-text">
                <?php
                    esc_html_e( 'Ja, E-Mail senden', 'bp-projekt-manager' ); ?>
                </label>
            </td>
            <td class="no">
                <input type="radio" name="notifications[task_breaker_task_new]" 
                    id="task-breaker-task-new-no" value="no" <?php
                        checked( $task_breaker_task_new, 'no', true ) ?> />
                <label for="task-breaker-task-new-no" class="bp-screen-reader-text">
                <?php
                    esc_html_e( 'Nein, keine E-Mail senden', 'bp-projekt-manager' ); ?>
                </label>
            </td>
        </tr>
    </tbody>
</table>
