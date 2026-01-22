<?php
/**
 * The header template
 *
 * @package 3to5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main">
    <?php esc_html_e( 'Skip to content', '3to5' ); ?>
</a>

<header class="site-header" role="banner">
    <div class="container site-header__inner">
        <div class="site-branding">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </h1>
            <?php endif; ?>
        </div>

        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', '3to5' ); ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', '3to5' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                ) );
            } else {
                // Default navigation for one-page layout
                ?>
                <ul id="primary-menu" class="menu">
                    <li><a href="#about"><?php esc_html_e( 'About', '3to5' ); ?></a></li>
                    <li><a href="#why"><?php esc_html_e( 'Why', '3to5' ); ?></a></li>
                    <li><a href="#action"><?php esc_html_e( 'Take Action', '3to5' ); ?></a></li>
                    <li><a href="#faq"><?php esc_html_e( 'FAQ', '3to5' ); ?></a></li>
                    <li><a href="#contact"><?php esc_html_e( 'Contact', '3to5' ); ?></a></li>
                    <?php if ( get_theme_mod( '3to5_donation_stripe_enable', true ) ) : ?>
                        <li class="menu-item-donate"><a href="#donate"><?php esc_html_e( 'Donate', '3to5' ); ?></a></li>
                    <?php endif; ?>
                </ul>
                <?php
            }
            ?>
        </nav>
    </div>
</header>

<main id="main" class="site-main" role="main">
