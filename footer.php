<?php
/**
 * The footer template
 *
 * @package 3to5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
</main><!-- #main -->

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__about">
                <h3><?php bloginfo( 'name' ); ?></h3>
                <p><?php echo esc_html( get_theme_mod( '3to5_hero_subtitle', __( 'More voices. Better representation. Stronger community.', '3to5' ) ) ); ?></p>
            </div>

            <div class="footer__links">
                <h4><?php esc_html_e( 'Quick Links', '3to5' ); ?></h4>
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'depth'          => 1,
                    ) );
                } else {
                    ?>
                    <ul>
                        <li><a href="#about"><?php esc_html_e( 'About', '3to5' ); ?></a></li>
                        <li><a href="#action"><?php esc_html_e( 'Sign the Petition', '3to5' ); ?></a></li>
                        <li><a href="#faq"><?php esc_html_e( 'FAQ', '3to5' ); ?></a></li>
                        <li><a href="#contact"><?php esc_html_e( 'Contact', '3to5' ); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </div>

            <div class="footer__contact">
                <h4><?php esc_html_e( 'Contact Us', '3to5' ); ?></h4>
                <?php
                $email = get_theme_mod( '3to5_contact_email' );
                $phone = get_theme_mod( '3to5_contact_phone' );
                ?>
                <?php if ( $email ) : ?>
                    <p>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <?php if ( $phone ) : ?>
                    <p>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php
                $facebook  = get_theme_mod( '3to5_social_facebook' );
                $twitter   = get_theme_mod( '3to5_social_twitter' );
                $instagram = get_theme_mod( '3to5_social_instagram' );

                if ( $facebook || $twitter || $instagram ) :
                    ?>
                    <div class="social-links">
                        <?php if ( $facebook ) : ?>
                            <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', '3to5' ); ?>">
                                <span aria-hidden="true">f</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( $twitter ) : ?>
                            <a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Twitter', '3to5' ); ?>">
                                <span aria-hidden="true">𝕏</span>
                            </a>
                        <?php endif; ?>
                        <?php if ( $instagram ) : ?>
                            <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', '3to5' ); ?>">
                                <span aria-hidden="true">📷</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer__bottom">
            <p>
                <?php echo wp_kses_post( get_theme_mod( '3to5_footer_text', __( 'Paid for by the 3 to 5 Campaign Committee.', '3to5' ) ) ); ?>
            </p>
            <p>
                &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
                <?php esc_html_e( 'All rights reserved.', '3to5' ); ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
