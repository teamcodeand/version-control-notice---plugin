<?php
/**
 * Handles the version control notice screen and admin restrictions.
 *
 * @package Codeand\VersionControlNotice\Screens
 */

namespace Codeand\VersionControlNotice\Screens;

defined( 'ABSPATH' ) || exit;

/**
 * Registers a fake "Add Plugins" page that explains version control restrictions.
 *
 * @return void
 */
function register_fake_plugins_page() {
    if ( current_user_can( 'update_core' ) ) {
        return;
    }

    remove_action( 'admin_notices', 'update_nag', 3 );

    $capability = apply_filters( 'version-control-notice-capability', 'manage_options' );

    add_plugins_page(
        __( 'Add Plugins', 'version-control-notice' ),
        __( 'Add New', 'version-control-notice' ),
        $capability,
        'plugins-install',
        __NAMESPACE__ . '\\render_notice_page'
    );
}

/**
 * Enqueues inline styles and JavaScript for the custom screen.
 *
 * @return void
 */
function enqueue_admin_assets() {
    $screen = get_current_screen();

    if ( ! isset( $screen->base ) || $screen->base !== 'plugins_page_plugins-install' ) {
        return;
    }

    $custom_css = <<<CSS
#poststuff h2:not(.hndle) {
    font-size: 1.3em;
    padding: 0;
    margin: 1em 0;
    line-height: initial;
}
CSS;

    wp_add_inline_style( 'edit', $custom_css );
    wp_enqueue_script( 'postbox' );
    wp_add_inline_script( 'postbox', 'jQuery(function($){ postboxes.add_postbox_toggles(pagenow); });' );
}

/**
 * Renders the custom fake "Add Plugins" screen.
 *
 * @return void
 */
function render_notice_page() {
    $capability = apply_filters( 'version-control-notice-capability', 'manage_options' );
    if ( ! current_user_can( $capability ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <hr class="wp-header-end">

        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">

                    <?php do_action( 'version_control_notice_before_page_content' ); ?>

                    <h2><?php esc_html_e( 'Hey there! This site is under version control', 'version-control-notice' ); ?></h2>
                    <p>
                    <?php
                        esc_html_e(
                            "Adding, removing & editing themes, plugins or WP itself
                        is disabled on this site because it's under version control, meaning every
                        change made to the code base is tracked along with who, when and why. This
                        allows software developers to see the context of changes at any given point
                        in a project's history — and roll back from the current version to an earlier
                        version if they need to. It also creates a single source of truth; one
                        location from where the project files can be retrieved without risk of
                        tampering or contamination.",
                            'version-control-notice'
                        );
                    ?>
                    </p>

                    <h3><?php esc_html_e( 'Can I be allowed to add my own plugins?', 'version-control-notice' ); ?></h3>
                    <p><?php esc_html_e( 'No, for a number of reasons, the core ones being:', 'version-control-notice' ); ?></p>
                    <h4><?php esc_html_e( 'Your live website is not a good place to test new plugins', 'version-control-notice' ); ?></h4>
                    <p>
                    <?php
                        esc_html_e(
                            "When adding a new plugin, any good developer will test
                        it in a development environment first and/or deploy it to your staging site to
                        see if it's compatible. Nothing should ever be added directly to the live site
                        without being tested first. The last thing we want is for an incompatible
                        plugin to take your site offline! In our experience, this generally happens
                        when a site admin has found some free time, which means evenings or weekends
                        - no-one wants to be recovering a site under pressure on a Friday evening.",
                            'version-control-notice'
                        );
                    ?>
                    </p>
                    <h4><?php esc_html_e( 'Confidence in deployments', 'version-control-notice' ); ?></h4>
                    <p>
                    <?php
                        esc_html_e(
                            "Your developer should be able to redeploy the site with
                        completely fresh code at any given time. This might be to fix an issue, to add
                        the latest updates or features they've been working on, to update the server
                        or any number of other reasons. Any plugins added directly to the website
                        won't be under version control, meaning you've lost your single source of
                        truth, and so those changes will be lost when the site is next deployed. Any
                        hard work you've put into setting up a new plugin will be gone.",
                            'version-control-notice'
                        );
                    ?>
                    </p>
                    <h4><?php esc_html_e( 'Best practice for modern websites', 'version-control-notice' ); ?></h4>
                    <p>
                    <?php
                        esc_html_e(
                            "Developers should look forward, not backward. This
                        approach is best practice in modern web projects and anyone not doing it is
                        probably cutting costs by cutting corners. Allowing code changes to be added
                        through the WP dashboard is fundamentally incompatible with our workflow and
                        we wouldn't be able to offer things like disaster recovery if we didn't vet
                        all code we're responsible for.",
                            'version-control-notice'
                        );
                    ?>
                    </p>

                    <?php do_action( 'version_control_notice_after_reasons' ); ?>

                    <h3><?php esc_html_e( 'How do I get a plugin added to/removed from this site?', 'version-control-notice' ); ?></h3>
                    <p>
                    <?php
                        esc_html_e(
                            "Ask your developers. Tell them the name of the plugin
                        and a link to it, that should be enough. If it's a premium (paid) plugin, make
                        sure you've purchased the plugin then provide the logins - they'll need to be
                        able to download any updates for your new plugin in future.",
                            'version-control-notice'
                        );
                    ?>
                    </p>
                    <p>
                    <?php
                        esc_html_e(
                            "Your site is a valuable asset to your business, keeping
                        one source of truth for all code added will be invaluable to you in the
                        future. Especially when something goes wrong! We realise it's a little more
                        inconvenient and you may be used to adding your own, but it's the correct way
                        to look after your site and avoid stressful accidents.",
                            'version-control-notice'
                        );
                    ?>
                    </p>
                    <p><?php esc_html_e( 'Thanks for understanding!', 'version-control-notice' ); ?></p>

                    <?php do_action( 'version_control_notice_after_page_content' ); ?>

                </div>

                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables">

                        <?php do_action( 'version_control_notice_before_metaboxes' ); ?>

                        <div class="postbox">
                            <div class="postbox-header">
                                <h2 class="hndle"><?php esc_html_e( 'Developer resources', 'version-control-notice' ); ?></h2>
                                <div class="handle-actions hide-if-no-js">
                                    <button type="button" class="handlediv" aria-expanded="true">
                                        <span class="screen-reader-text">Toggle panel: Developer resources</span>
                                        <span class="toggle-indicator" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="inside">
                                <div class="main">
                                    <p><?php esc_html_e( 'Inherited this site and/or want to know more about these concepts?', 'version-control-notice' ); ?></p>
                                    <ol>
                                        <li><a href="https://roots.io/twelve-factor-wordpress/" target="_blank" rel="noopener">12 Factor WordPress - Roots</a></li>
                                        <li><a href="https://about.gitlab.com/topics/version-control" target="_blank" rel="noopener">What is version control? - Gitlab</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <?php do_action( 'version_control_notice_after_metaboxes' ); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Blocks access to `plugin-install.php` and `update-core.php` for unauthorized users.
 *
 * Shows a custom message explaining why updates are restricted.
 *
 * @return void
 */
function block_plugin_access() {
    global $pagenow;

    $blocked = [ 'update-core.php', 'plugin-install.php' ];
    if ( ! in_array( $pagenow, $blocked, true ) ) {
        return;
    }

    $title     = __( 'Pardon the interruption...', 'version-control-notice' );
    $message   = __( 'Adding or editing plugins through the WP dashboard has been disabled on this site for all users, including administrators. This site\'s code is under version control, meaning any code changes you make (i.e. adding a new plugin) would be overwritten the next time the site is deployed.', 'version-control-notice' );
    $link_text = __( 'this page', 'version-control-notice' );

    wp_die(
        '<h1>' . esc_html( $title ) . '</h1>' .
        '<p>' . esc_html( $message ) . '</p>' .
        '<p>' . esc_html__( 'Contact your developers or see', 'version-control-notice' ) .
        ' <a href="' . esc_url( admin_url( 'admin.php?page=plugins-install' ) ) . '">' . esc_html( $link_text ) . '</a> ' .
        esc_html__( 'for more information.', 'version-control-notice' ) . '</p>',
        esc_html( $title ),
        [ 'response' => 403 ]
    );
}
