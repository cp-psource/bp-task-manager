<div class="task-progress">

    <div class="task-progress-bar">
        <div class="task-progress-percentage" style="width:<?php echo absint( $args['tasks_progress'] ); ?>%;">
			<div class="task-progress-task-count-wrap">
				<div class="task-progress-task-count">
					<?php
						printf( _n( '%s Aufgabe', '%s Aufgaben', $args['tasks_total'], 'bp-projekt-manager' ), '<span class="task_breaker-total-tasks">' . $args['tasks_total'] . '</span>' );
					?>
				</div>
			</div>
			<div class="task-progress-percentage-label">
				<span>
					<?php echo absint( $args['tasks_progress'] ); ?>%
					<?php _e( 'Abgeschlossen', 'bp-projekt-manager' ); ?>
				</span>
			</div>
		</div>
	</div>
</div>
