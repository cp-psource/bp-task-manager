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
<?php $tb_post = PSourceProjektManager::get_post(); ?>

<?php $template = new PSourceProjektManagerTemplate(); ?>

<div id="task_breaker-single-project-group-details">

	<div id="task_breaker-intranet-projects">

		<ul id="task_breaker-projects-lists">

			<li class="type-project">

				<?php $template->display_project_user( $tb_post->post_author, $tb_post->ID ); ?>

				<div class="task_breaker-project-meta">

					<?php $template->the_project_meta( get_the_ID() ); ?>

				</div>

			</li>

		</ul>

	</div>

</div><!--#task_breaker-single-project-group-details-->
