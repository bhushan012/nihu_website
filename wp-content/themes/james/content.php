<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage james_Themes
 * @since Road Themes 1.0
 */

$james_opt = get_option( 'james_opt' );

$james_postthumb = JamesTheme::james_post_thumbnail_size('');

if(JamesTheme::james_post_odd_event() == 1){
	$james_postclass='even';
} else {
	$james_postclass='odd';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($james_postclass); ?>>
	
	<?php if ( ! post_password_required() && ! is_attachment() ) : ?>
	<?php 
		if ( is_single() ) { ?>
			<?php if ( has_post_thumbnail() ) { ?>
				<div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
			<?php } ?>
		<?php }
	?>
	<?php if ( !is_single() ) { ?>
		<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($james_postthumb); ?></a>
		</div>
		<?php } ?>
	<?php } ?>
	<?php endif; ?>
	
	<div class="postinfo-wrapper <?php if ( !has_post_thumbnail() ) { echo 'no-thumbnail';} ?>">
		
		<div class="post-info">
			<header class="entry-header">
				<?php if ( is_single() ) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php else : ?>
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
				<?php endif; ?>
			</header>
			
			<footer class="entry-meta-small">
				<div class="post-date">
					<?php echo '<span class="day">'.get_the_date('d', $post->ID).'</span><span class="month">'.get_the_date('M', $post->ID).'</span>' ;?>
				</div>
				<?php JamesTheme::james_entry_meta_small(); ?>
			</footer>
			
			<?php if ( is_single() ) : ?>
				<div class="entry-content">
					<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'james' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'james' ), 'after' => '</div>', 'pagelink' => '<span>%</span>' ) ); ?>
				</div>
			<?php else : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
					<a class="readmore" href="<?php the_permalink(); ?>"><?php if(isset($james_opt['readmore_text']) && $james_opt['readmore_text']!=''){ echo esc_html($james_opt['readmore_text']); } else { esc_html_e('Read more', 'james');}  ?></a>
				</div>
			<?php endif; ?>
			
			<?php if ( is_single() ) : ?>
				<div class="entry-meta">
					<?php JamesTheme::james_entry_meta(); ?>
				</div>
			
				<?php if( function_exists('james_blog_sharing') ) { ?>
					<div class="social-sharing"><?php james_blog_sharing(); ?></div>
				<?php } ?>
			
				<div class="author-info">
					<div class="author-avatar">
						<?php
						$author_bio_avatar_size = apply_filters( 'roadthemes_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div>
					<div class="author-description">
						<h2><?php esc_html_e( 'About the Author:', 'james'); printf( '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" rel="author">%s</a>' , get_the_author()); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>