<?php
/**
 * Accredible Certificate administration panel
 *
 * @package WordPress
 * @subpackage Administration
 * @since 1.0.0
 */

$title = __( 'Accredible Credentials' );
global $wpdb;
$items = $wpdb->get_results("SELECT * FROM `wp_accrediblecertificate` order by id desc");

?>
<div class="wrap">
	<h1 class="wp-heading-inline">
		<?php echo esc_html( $title ); ?>
	</h1>

    <div class="row">
        <div class="col-md-12">
            <div id="j-main-container" class="j-main-container">
                <?php if (empty($items)) : ?>
                    <div class="alert alert-info">
                        <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo __('INFO'); ?></span>
                        <?php echo __('No data'); ?>
                    </div>
                <?php else : ?>
                    <table class="table wp-list-table widefat fixed striped table-view-list" id="bannerList">
                        <thead>
                            <tr>
                                <th scope="col" class="column-language_">
									<?= __( 'Id', 'testpage' ); ?>
								</th>
								<th scope="col" class="w-10">
									<?= __( 'User ID', 'testpage' ); ?>
								</th>
								<th scope="col" class="w-10">
									<?= __( 'Group ID', 'testpage' ); ?>
								</th>
								<th scope="col" class="column-response">
									<?= __( 'Url image', 'testpage' ); ?>
								</th>
								<th scope="col" class="column-response">
									<?= __( 'Url badge', 'testpage' ); ?>
								</th>
								<th scope="col" class="column-response">
									<?= __( 'Date created', 'testpage' ); ?>
								</th>
								<th scope="col" class="w-5 d-none d-md-table-cell">
									<?= __( 'Published', 'testpage' ); ?>
								</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $i => $item) : ?>
                                <tr class="row<?php echo $i % 2; ?>" data-draggable-group="<?php echo $item->id; ?>">
                                    <td class="text-center">
										<?php echo $item->id; ?>
										
									</td>
									<th scope="row" class="has-context">
										<?php echo $item->user_id; ?>
									</th>
									<td class="">
										<?php echo $item->group_id; ?>
									</td>
									<td class="">
										<?php echo $item->url_image; ?>
									</td>
									<td class="">
										<?php echo $item->url_badge; ?>
									</td>
									<td class="">
										<?php echo $item->created; ?>
									</td>
									<td class="d-none d-md-table-cell">
										<?= $item->published; ?>
									</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

	<div class="clear"></div>
</div><!-- .wrap -->
<?php

require_once ABSPATH . 'wp-admin/admin-footer.php';