<?php
/**
 * Template part for displaying a post card in loops.
 *
 * Used by home.php, index.php, archive.php and search.php.
 *
 * @package iweb
 * @since 1.0.0
 */

$iweb_card_cat = iweb_primary_category();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
	<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) );
		}
		?>
	</a>
	<div class="post-card__body">
		<?php if ( 'post' === get_post_type() && $iweb_card_cat ) : ?>
			<p class="tag-label"><?php echo esc_html( $iweb_card_cat ); ?></p>
		<?php endif; ?>
		<?php the_title( '<h2 class="post-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="post-card__meta">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 36, '', '', array( 'class' => 'avatar' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span>
					<strong><?php echo esc_html( sprintf( /* translators: %s: author name. */ __( 'By %s', 'iweb' ), get_the_author() ) ); ?></strong><br>
					<?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( iweb_reading_time_label() ); ?>
				</span>
				<a class="post-card__go" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: post title. */ __( 'Read %s', 'iweb' ), get_the_title() ) ); ?>"><?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
