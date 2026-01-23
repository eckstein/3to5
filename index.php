<?php
/**
 * The main template file
 *
 * This is the single-page campaign template.
 *
 * @package 3to5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<?php // ======================== HERO SECTION ======================== ?>
<?php
$hero_bg           = get_theme_mod( '3to5_hero_bg' );
$hero_video_enable = get_theme_mod( '3to5_hero_video_enable', false );
$hero_video_url    = get_theme_mod( '3to5_hero_video_url', '' );
$hero_classes      = 'hero section';
if ( $hero_video_enable && $hero_video_url ) {
    $hero_classes .= ' hero--has-video';
}
?>
<section class="<?php echo esc_attr( $hero_classes ); ?>" id="home" <?php
    if ( $hero_bg ) {
        echo 'style="background-image: url(' . esc_url( $hero_bg ) . ');"';
    }
?>>
    <div class="hero__content">
        <?php
        $tagline  = get_theme_mod( '3to5_hero_tagline', __( 'Lewis County Ballot Initiative', '3to5' ) );
        $title    = get_theme_mod( '3to5_hero_title', __( 'Expand Our County Commission from 3 to 5', '3to5' ) );
        $subtitle = get_theme_mod( '3to5_hero_subtitle', __( 'More voices. Better representation. Stronger community.', '3to5' ) );
        $cta_text = get_theme_mod( '3to5_hero_cta_text', __( 'Sign the Petition', '3to5' ) );
        $cta_link = get_theme_mod( '3to5_hero_cta_link', '#action' );
        $cta2_text = get_theme_mod( '3to5_hero_cta2_text', __( 'Learn More', '3to5' ) );
        $cta2_link = get_theme_mod( '3to5_hero_cta2_link', '#about' );
        ?>

        <?php if ( $tagline ) : ?>
            <p class="hero__tagline"><?php echo esc_html( $tagline ); ?></p>
        <?php endif; ?>

        <h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>

        <?php if ( $subtitle ) : ?>
            <p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>

        <div class="hero__buttons">
            <?php if ( $cta_text && $cta_link ) : ?>
                <a href="<?php echo esc_url( $cta_link ); ?>" class="btn btn--primary btn--large"<?php if ( get_theme_mod( '3to5_hero_cta_newtab', false ) ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            <?php endif; ?>

            <?php if ( $cta2_text && $cta2_link ) : ?>
                <a href="<?php echo esc_url( $cta2_link ); ?>" class="btn btn--secondary btn--large"<?php if ( get_theme_mod( '3to5_hero_cta2_newtab', false ) ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                    <?php echo esc_html( $cta2_text ); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php
        // Video embed
        $video_type   = get_theme_mod( '3to5_hero_video_type', 'youtube' );
        $video_poster = get_theme_mod( '3to5_hero_video_poster', '' );

        if ( $hero_video_enable && $hero_video_url ) :
        ?>
        <div class="hero__video">
            <?php if ( 'youtube' === $video_type ) :
                $youtube_id = three_to_five_get_youtube_id( $hero_video_url );
                if ( $youtube_id ) :
            ?>
                <div class="hero__video-wrapper">
                    <iframe
                        src="https://www.youtube.com/embed/<?php echo esc_attr( $youtube_id ); ?>?rel=0&modestbranding=1"
                        title="<?php esc_attr_e( 'Campaign Video', '3to5' ); ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            <?php endif; ?>

            <?php elseif ( 'vimeo' === $video_type ) :
                $vimeo_id = three_to_five_get_vimeo_id( $hero_video_url );
                if ( $vimeo_id ) :
            ?>
                <div class="hero__video-wrapper">
                    <iframe
                        src="https://player.vimeo.com/video/<?php echo esc_attr( $vimeo_id ); ?>?title=0&byline=0&portrait=0"
                        title="<?php esc_attr_e( 'Campaign Video', '3to5' ); ?>"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            <?php endif; ?>

            <?php elseif ( 'self' === $video_type ) : ?>
                <div class="hero__video-wrapper hero__video-wrapper--self">
                    <video
                        controls
                        preload="metadata"
                        <?php if ( $video_poster ) : ?>
                            poster="<?php echo esc_url( $video_poster ); ?>"
                        <?php endif; ?>
                    >
                        <source src="<?php echo esc_url( $hero_video_url ); ?>" type="video/mp4">
                        <?php esc_html_e( 'Your browser does not support the video tag.', '3to5' ); ?>
                    </video>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php // ======================== DONATION STRIPE ======================== ?>
<?php if ( get_theme_mod( '3to5_donation_stripe_enable', true ) ) : ?>
<section class="donation-stripe" id="donate">
    <div class="container">
        <div class="donation-stripe__inner">
            <div class="donation-stripe__text">
                <span class="donation-stripe__icon" aria-hidden="true">&#10084;</span>
                <p><?php echo esc_html( get_theme_mod( '3to5_donation_stripe_text', __( 'Help us expand representation in Lewis County. Your donation makes a difference!', '3to5' ) ) ); ?></p>
            </div>
            <?php
            $donate_btn_text = get_theme_mod( '3to5_donation_stripe_btn_text', __( 'Donate Now', '3to5' ) );
            $donate_btn_link = get_theme_mod( '3to5_donation_stripe_btn_link', '#' );
            $donate_newtab   = get_theme_mod( '3to5_donation_stripe_newtab', false );
            if ( $donate_btn_text && $donate_btn_link ) :
            ?>
            <a href="<?php echo esc_url( $donate_btn_link ); ?>" class="btn btn--donate"<?php if ( $donate_newtab ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                <?php echo esc_html( $donate_btn_text ); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php // ======================== ABOUT SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_about_enable', true ) ) : ?>
<section class="about section" id="about">
    <div class="container">
        <div class="about__grid">
            <?php
            $about_image = get_theme_mod( '3to5_about_image' );
            if ( $about_image ) :
            ?>
            <div class="about__image">
                <img src="<?php echo esc_url( $about_image ); ?>" alt="<?php esc_attr_e( 'About the campaign', '3to5' ); ?>">
            </div>
            <?php endif; ?>

            <div class="about__content">
                <h2><?php echo esc_html( get_theme_mod( '3to5_about_title', __( 'Why Expand to 5 Commissioners?', '3to5' ) ) ); ?></h2>
                <?php
                $about_content = get_theme_mod( '3to5_about_content', __( 'Lewis County has grown significantly over the years, but our County Commission has remained at just three members. By expanding to five commissioners, we can ensure better representation for all residents, bring more diverse perspectives to local government, and improve transparency in decision-making.', '3to5' ) );
                echo wp_kses_post( wpautop( $about_content ) );
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php // ======================== REASONS/WHY SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_reasons_enable', true ) ) : ?>
<section class="why section section--alt" id="why">
    <div class="container">
        <h2 class="text-center"><?php echo esc_html( get_theme_mod( '3to5_reasons_title', __( 'Key Benefits', '3to5' ) ) ); ?></h2>

       <?php
       $reasons_graphic = get_theme_mod( '3to5_reasons_graphic' );
       $reasons_graphic_width_desktop = get_theme_mod( '3to5_reasons_graphic_width_desktop', 100 );
       $reasons_graphic_width_mobile  = get_theme_mod( '3to5_reasons_graphic_width_mobile', 100 );
       ?>
       <?php if ( $reasons_graphic ) : ?>
            <style>
                .why__graphic img { width: <?php echo esc_attr( $reasons_graphic_width_desktop ); ?>%; }
                @media (max-width: 768px) { .why__graphic img { width: <?php echo esc_attr( $reasons_graphic_width_mobile ); ?>%; } }
            </style>
            <div class="why__graphic">
                <img src="<?php echo esc_url( $reasons_graphic ); ?>" alt="<?php esc_attr_e( 'Reasons Graphic', '3to5' ); ?>">
            </div>
       <?php endif; ?>
        <div class="why__grid">
            <?php
            $default_reasons = array(
                1 => array(
                    'title' => __( 'Better Representation', '3to5' ),
                    'text'  => __( 'Five commissioners means more neighborhoods and communities have a voice at the table.', '3to5' ),
                    'icon'  => '👥',
                ),
                2 => array(
                    'title' => __( 'Diverse Perspectives', '3to5' ),
                    'text'  => __( 'More commissioners bring varied backgrounds, experiences, and viewpoints to important decisions.', '3to5' ),
                    'icon'  => '🌟',
                ),
                3 => array(
                    'title' => __( 'Increased Accountability', '3to5' ),
                    'text'  => __( 'With more eyes on every decision, there is greater transparency and accountability in local government.', '3to5' ),
                    'icon'  => '✅',
                ),
            );

            for ( $i = 1; $i <= 3; $i++ ) :
                $title = get_theme_mod( "3to5_reason_{$i}_title", $default_reasons[ $i ]['title'] );
                $text  = get_theme_mod( "3to5_reason_{$i}_text", $default_reasons[ $i ]['text'] );
                $icon  = get_theme_mod( "3to5_reason_{$i}_icon", $default_reasons[ $i ]['icon'] );

                if ( $title && $text ) :
            ?>
                <article class="reason-card">
                    <?php if ( $icon ) : ?>
                        <div class="reason-card__icon" aria-hidden="true">
                            <?php echo esc_html( $icon ); ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="reason-card__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="reason-card__text"><?php echo esc_html( $text ); ?></p>
                </article>
            <?php
                endif;
            endfor;
            ?>
        </div>

        <?php // Quotes subsection ?>
        <?php
        $quote_items = three_to_five_get_quote_items();
        $has_quotes = false;
        foreach ( $quote_items as $quote ) {
            if ( ! empty( $quote['text'] ) ) {
                $has_quotes = true;
                break;
            }
        }
        if ( $has_quotes ) :
        ?>
        <div class="quotes">
            <div class="quotes__list">
                <?php foreach ( $quote_items as $index => $quote ) :
                    if ( ! empty( $quote['text'] ) ) :
                ?>
                    <blockquote class="quote-card" data-quote-index="<?php echo esc_attr( $index ); ?>">
                        <p class="quote-card__text"><?php echo esc_html( $quote['text'] ); ?></p>
                        <?php if ( ! empty( $quote['author'] ) ) : ?>
                            <footer class="quote-card__footer">
                                <cite class="quote-card__author"><?php echo esc_html( $quote['author'] ); ?></cite>
                                <?php if ( ! empty( $quote['title'] ) ) : ?>
                                    <span class="quote-card__title"><?php echo esc_html( $quote['title'] ); ?></span>
                                <?php endif; ?>
                            </footer>
                        <?php endif; ?>
                    </blockquote>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php // ======================== TAKE ACTION SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_action_enable', true ) ) : ?>
<?php
$action_bg = get_theme_mod( '3to5_action_bg' );
$action_classes = 'action section';
if ( $action_bg ) {
    $action_classes .= ' action--has-bg';
}
?>
<section class="<?php echo esc_attr( $action_classes ); ?>" id="action"<?php if ( $action_bg ) : ?> style="background-image: url(<?php echo esc_url( $action_bg ); ?>);"<?php endif; ?>>
    <div class="container text-center">
        <h2><?php echo esc_html( get_theme_mod( '3to5_action_title', __( 'How to Sign the Petition', '3to5' ) ) ); ?></h2>
        <p><?php echo esc_html( get_theme_mod( '3to5_action_subtitle', __( 'Your signature matters! Here is how you can help put this measure on the ballot.', '3to5' ) ) ); ?></p>

        <div class="action__grid">
            <?php
            $default_steps = array(
                1 => array(
                    'title' => __( 'Find a Signing Location', '3to5' ),
                    'text'  => __( 'Visit one of our signing locations listed below or contact us to arrange a signature gatherer to come to you.', '3to5' ),
                ),
                2 => array(
                    'title' => __( 'Bring Valid ID', '3to5' ),
                    'text'  => __( 'You must be a registered voter in Lewis County. Bring a valid form of identification.', '3to5' ),
                ),
                3 => array(
                    'title' => __( 'Sign & Share', '3to5' ),
                    'text'  => __( 'Sign the petition and spread the word! Tell your friends, family, and neighbors about this important initiative.', '3to5' ),
                ),
            );

            for ( $i = 1; $i <= 3; $i++ ) :
                $title      = get_theme_mod( "3to5_step_{$i}_title", $default_steps[ $i ]['title'] );
                $text       = get_theme_mod( "3to5_step_{$i}_text", $default_steps[ $i ]['text'] );
                $btn_text   = get_theme_mod( "3to5_step_{$i}_btn_text", '' );
                $btn_link   = get_theme_mod( "3to5_step_{$i}_btn_link", '' );
                $btn_newtab = get_theme_mod( "3to5_step_{$i}_btn_newtab", false );

                if ( $title && $text ) :
            ?>
                <div class="action-step">
                    <div class="action-step__number" aria-hidden="true"><?php echo esc_html( $i ); ?></div>
                    <h3 class="action-step__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="action-step__text"><?php echo esc_html( $text ); ?></p>
                    <?php if ( $btn_text && $btn_link ) : ?>
                        <a href="<?php echo esc_url( $btn_link ); ?>" class="btn btn--action-step"<?php if ( $btn_newtab ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                            <?php echo esc_html( $btn_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php
                endif;
            endfor;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php // ======================== LOCATIONS SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_locations_enable', true ) ) : ?>
<?php
$location_items = three_to_five_get_location_items();
$has_locations = false;

foreach ( $location_items as $location ) {
    if ( ! empty( $location['name'] ) ) {
        $has_locations = true;
        break;
    }
}

// Always render section structure for customizer live preview support
$locations_style = $has_locations ? '' : ' style="display: none;"';
?>
<section class="locations section section--alt" id="locations"<?php echo $locations_style; ?>>
    <div class="container">
        <h2 class="text-center"><?php echo esc_html( get_theme_mod( '3to5_locations_title', __( 'Where to Sign', '3to5' ) ) ); ?></h2>

        <div class="locations__list">
            <?php foreach ( $location_items as $index => $location ) :
                if ( ! empty( $location['name'] ) ) :
            ?>
                <article class="location-card" data-location-index="<?php echo esc_attr( $index ); ?>">
                    <h3 class="location-card__name"><?php echo esc_html( $location['name'] ); ?></h3>
                    <?php if ( ! empty( $location['address'] ) ) : ?>
                        <p class="location-card__address"><?php echo esc_html( $location['address'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $location['hours'] ) ) : ?>
                        <p class="location-card__hours"><strong><?php esc_html_e( 'Hours:', '3to5' ); ?></strong> <?php echo esc_html( $location['hours'] ); ?></p>
                    <?php endif; ?>
                </article>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php // ======================== FAQ SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_faq_enable', true ) ) : ?>
<?php
$faq_items = three_to_five_get_faq_items();
$has_faqs = false;

foreach ( $faq_items as $faq ) {
    if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) {
        $has_faqs = true;
        break;
    }
}

if ( $has_faqs ) :
?>
<section class="faq section" id="faq">
    <div class="container">
        <h2 class="text-center"><?php echo esc_html( get_theme_mod( '3to5_faq_title', __( 'Frequently Asked Questions', '3to5' ) ) ); ?></h2>

        <div class="faq__list">
            <?php foreach ( $faq_items as $index => $faq ) :
                if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) :
            ?>
                <div class="faq-item" data-faq-index="<?php echo esc_attr( $index ); ?>">
                    <button class="faq-item__question" aria-expanded="false">
                        <?php echo esc_html( $faq['question'] ); ?>
                    </button>
                    <div class="faq-item__answer" aria-hidden="true">
                        <?php echo wp_kses_post( wpautop( $faq['answer'] ) ); ?>
                    </div>
                </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php // ======================== CONTACT SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_contact_enable', true ) ) : ?>
<section class="contact section section--alt" id="contact">
    <div class="container">
        <h2 class="text-center"><?php echo esc_html( get_theme_mod( '3to5_contact_title', __( 'Get Involved', '3to5' ) ) ); ?></h2>

        <div class="contact__grid">
            <div class="contact__info">
                <h3><?php esc_html_e( 'Contact Us', '3to5' ); ?></h3>

                <?php
                $email = get_theme_mod( '3to5_contact_email' );
                $phone = get_theme_mod( '3to5_contact_phone' );
                ?>

                <?php if ( $email ) : ?>
                    <div class="contact__item">
                        <span class="contact__icon" aria-hidden="true">✉️</span>
                        <div>
                            <strong><?php esc_html_e( 'Email', '3to5' ); ?></strong><br>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                <?php echo esc_html( $email ); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( $phone ) : ?>
                    <div class="contact__item">
                        <span class="contact__icon" aria-hidden="true">📞</span>
                        <div>
                            <strong><?php esc_html_e( 'Phone', '3to5' ); ?></strong><br>
                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
                                <?php echo esc_html( $phone ); ?>
                            </a>
                        </div>
                    </div>
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

            <?php
            $volunteer_title      = get_theme_mod( '3to5_volunteer_title', __( 'Volunteer', '3to5' ) );
            $volunteer_text       = get_theme_mod( '3to5_volunteer_text', __( 'Want to help gather signatures or spread the word? We need volunteers throughout Lewis County. Contact us to get involved!', '3to5' ) );
            $volunteer_btn_text   = get_theme_mod( '3to5_volunteer_btn_text', __( 'Become a Volunteer', '3to5' ) );
            $volunteer_btn_link   = get_theme_mod( '3to5_volunteer_btn_link', '' );
            $volunteer_btn_newtab = get_theme_mod( '3to5_volunteer_btn_newtab', false );

            // Fall back to mailto if no custom link provided
            if ( empty( $volunteer_btn_link ) && $email ) {
                $volunteer_btn_link = 'mailto:' . $email . '?subject=' . rawurlencode( $volunteer_btn_text );
            }
            ?>
            <div class="contact__volunteer">
                <?php if ( $volunteer_title ) : ?>
                    <h3><?php echo esc_html( $volunteer_title ); ?></h3>
                <?php endif; ?>
                <?php if ( $volunteer_text ) : ?>
                    <p><?php echo esc_html( $volunteer_text ); ?></p>
                <?php endif; ?>
                <div class="contact__volunteer-buttons">
                    <?php if ( $volunteer_btn_text && $volunteer_btn_link ) : ?>
                        <a href="<?php echo esc_url( $volunteer_btn_link ); ?>" class="btn btn--primary"<?php if ( $volunteer_btn_newtab ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                            <?php echo esc_html( $volunteer_btn_text ); ?>
                        </a>
                    <?php endif; ?>
                    <button type="button" class="btn btn--secondary btn--updates" data-open-email-modal>
                        <?php esc_html_e( 'Get Updates', '3to5' ); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php // ======================== EMAIL OPT-IN MODAL ======================== ?>
<div class="email-modal" id="email-modal" aria-hidden="true" role="dialog" aria-labelledby="email-modal-title" aria-modal="true">
    <div class="email-modal__overlay" data-close-email-modal></div>
    <div class="email-modal__content">
        <button type="button" class="email-modal__close" data-close-email-modal aria-label="<?php esc_attr_e( 'Close modal', '3to5' ); ?>">
            <span aria-hidden="true">&times;</span>
        </button>
        <h2 id="email-modal-title" class="email-modal__title"><?php esc_html_e( 'Get Email Updates', '3to5' ); ?></h2>
        <p class="email-modal__subtitle"><?php esc_html_e( 'Stay informed about our progress and ways to help.', '3to5' ); ?></p>
        <div class="email-modal__iframe-container">
            <iframe
                title="<?php esc_attr_e( 'Signup form powered by Zeffy', '3to5' ); ?>"
                src="https://www.zeffy.com/en-US/embed/newsletter-form/get-email-updates-on-our-progress"
                allowtransparency="true"
            ></iframe>
        </div>
    </div>
</div>

<?php // ======================== STICKY GET UPDATES BUTTON ======================== ?>
<button type="button" class="sticky-updates-btn" data-open-email-modal aria-label="<?php esc_attr_e( 'Get Updates', '3to5' ); ?>">
    <span class="sticky-updates-btn__icon" aria-hidden="true">&#9993;</span>
    <span class="sticky-updates-btn__text"><?php esc_html_e( 'Get Updates', '3to5' ); ?></span>
</button>

<?php get_footer(); ?>
