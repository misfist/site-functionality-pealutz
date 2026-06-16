<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * 
 * $attributes (array): The block attributes.
 * $content (string): The block default content.
 * $block (WP_Block): The block instance.
 */
$post_id = $block->context['postId'] ?? get_the_ID();
$clients = \Site_Functionality\App\Blocks\Blocks::get_clients( $post_id );

if ( empty( $clients ) || ! is_array( $clients ) ) {
    return;
}
?>

<div <?php echo get_block_wrapper_attributes(
	array(
		'className' => 'job-clients'
	)
); ?>>
	<ul class="wp-block-list is-style-pills">

	<?php 
	foreach( $clients as $client ) :
		?>
		<li><?php echo esc_attr( $client['client_name'] ); ?></li>
		<?php
	endforeach;
	?>

	</ul>
	<!-- /wp:list -->
</div>