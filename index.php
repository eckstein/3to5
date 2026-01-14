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
                <a href="<?php echo esc_url( $cta_link ); ?>" class="btn btn--primary btn--large">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            <?php endif; ?>

            <?php if ( $cta2_text && $cta2_link ) : ?>
                <a href="<?php echo esc_url( $cta2_link ); ?>" class="btn btn--secondary btn--large">
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
                4 => array(
                    'title' => __( 'Stronger Community', '3to5' ),
                    'text'  => __( 'Better governance leads to better outcomes for roads, services, and quality of life for all residents.', '3to5' ),
                    'icon'  => '🏘️',
                ),
            );

            for ( $i = 1; $i <= 4; $i++ ) :
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
    </div>
</section>
<?php endif; ?>

<?php // ======================== TAKE ACTION SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_action_enable', true ) ) : ?>
<section class="action section" id="action">
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
                $title = get_theme_mod( "3to5_step_{$i}_title", $default_steps[ $i ]['title'] );
                $text  = get_theme_mod( "3to5_step_{$i}_text", $default_steps[ $i ]['text'] );

                if ( $title && $text ) :
            ?>
                <div class="action-step">
                    <div class="action-step__number" aria-hidden="true"><?php echo esc_html( $i ); ?></div>
                    <h3 class="action-step__title"><?php echo esc_html( $title ); ?></h3>
                    <p class="action-step__text"><?php echo esc_html( $text ); ?></p>
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
$has_locations = false;
for ( $i = 1; $i <= 4; $i++ ) {
    if ( get_theme_mod( "3to5_location_{$i}_name" ) ) {
        $has_locations = true;
        break;
    }
}

if ( $has_locations ) :
?>
<section class="locations section section--alt" id="locations">
    <div class="container">
        <h2 class="text-center"><?php echo esc_html( get_theme_mod( '3to5_locations_title', __( 'Where to Sign', '3to5' ) ) ); ?></h2>

        <div class="locations__list">
            <?php
            for ( $i = 1; $i <= 4; $i++ ) :
                $name    = get_theme_mod( "3to5_location_{$i}_name" );
                $address = get_theme_mod( "3to5_location_{$i}_address" );
                $hours   = get_theme_mod( "3to5_location_{$i}_hours" );

                if ( $name ) :
            ?>
                <article class="location-card">
                    <h3 class="location-card__name"><?php echo esc_html( $name ); ?></h3>
                    <?php if ( $address ) : ?>
                        <p class="location-card__address"><?php echo esc_html( $address ); ?></p>
                    <?php endif; ?>
                    <?php if ( $hours ) : ?>
                        <p class="location-card__hours"><strong><?php esc_html_e( 'Hours:', '3to5' ); ?></strong> <?php echo esc_html( $hours ); ?></p>
                    <?php endif; ?>
                </article>
            <?php
                endif;
            endfor;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php // ======================== FAQ SECTION ======================== ?>
<?php if ( get_theme_mod( '3to5_faq_enable', true ) ) : ?>
<?php
$has_faqs = false;
$default_faqs = array(
    1 => array(
        'question' => __( 'How many signatures are needed?', '3to5' ),
        'answer'   => __( 'We need to collect a specific number of valid signatures from registered voters in Lewis County. Every signature counts toward getting this measure on the ballot.', '3to5' ),
    ),
    2 => array(
        'question' => __( 'Who can sign the petition?', '3to5' ),
        'answer'   => __( 'Any registered voter who resides in Lewis County can sign the petition. You will need to provide valid identification.', '3to5' ),
    ),
    3 => array(
        'question' => __( 'When is the deadline?', '3to5' ),
        'answer'   => __( 'We have a limited time to collect all necessary signatures. Please sign as soon as possible and encourage others to do the same.', '3to5' ),
    ),
    4 => array(
        'question' => '',
        'answer'   => '',
    ),
    5 => array(
        'question' => '',
        'answer'   => '',
    ),
);

for ( $i = 1; $i <= 5; $i++ ) {
    $question = get_theme_mod( "3to5_faq_{$i}_question", $default_faqs[ $i ]['question'] );
    if ( $question ) {
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
            <?php
            for ( $i = 1; $i <= 5; $i++ ) :
                $question = get_theme_mod( "3to5_faq_{$i}_question", $default_faqs[ $i ]['question'] );
                $answer   = get_theme_mod( "3to5_faq_{$i}_answer", $default_faqs[ $i ]['answer'] );

                if ( $question && $answer ) :
            ?>
                <div class="faq-item">
                    <button class="faq-item__question" aria-expanded="false">
                        <?php echo esc_html( $question ); ?>
                    </button>
                    <div class="faq-item__answer" aria-hidden="true">
                        <?php echo wp_kses_post( wpautop( $answer ) ); ?>
                    </div>
                </div>
            <?php
                endif;
            endfor;
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

            <div class="contact__volunteer">
                <h3><?php esc_html_e( 'Volunteer', '3to5' ); ?></h3>
                <p><?php esc_html_e( 'Want to help gather signatures or spread the word? We need volunteers throughout Lewis County. Contact us to get involved!', '3to5' ); ?></p>
                <?php if ( $email ) : ?>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>?subject=<?php echo esc_attr( rawurlencode( __( 'I want to volunteer!', '3to5' ) ) ); ?>" class="btn btn--primary">
                        <?php esc_html_e( 'Become a Volunteer', '3to5' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
