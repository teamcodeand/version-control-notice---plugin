# Version Control Notice

## What
An MU Plugin for WordPress to display a client-friendly explainer when adding or removing plugins has been disabled. Useful when developing WP sites with <a href="https://roots.io/bedrock/" target="_blank">Bedrock</a>.

This will create an 'Add New' sub page under 'Plugins' with an explanation as to why having version control means adding plugins needs to be disabled.

The wording has been written to be as developer agnostic as is reasonable and hooks have been added to allow for adding site-specific information if necessary.

## Why
Sometimes clients forget why they're not able to add plugins, or they hire new team members who were never told, or the site changes hands. This is an attempt to explain before the client requests access they can't have.

## Installing

Add this to your project's `composer.json` file:

```.json
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:teamcodeand/version-control-notice---plugin.git",
      "no-api": true
    }
  ],
  "require": {
    "teamcodeand/version-control-notice": "dev-main"
  },
```

## Extending

An example of adding developer contact details as a metabox:

```php
add_action(
    'version_control_notice_before_metaboxes',
    function () {
        ?>
        <div class="postbox">
            <div class="postbox-header">
                <h2 class="hndle"><?php esc_html_e( 'Contact details', 'version-control-notice' ); ?></h2>
                <div class="handle-actions hide-if-no-js">
                    <button type="button" class="handlediv" aria-expanded="true">
                        <span class="screen-reader-text">Toggle panel: Contact details</span>
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            <div class="inside">
                <div class="main">
                    <p><?php esc_html_e( 'This site is maintained by Code&', 'version-control-notice' ); ?></p>
                    <ul>
                        <li><strong>Web:</strong> <a href="https://codeand.com.au/" target="_blank">codeand.com.au</a></li>
                        <li><strong>Slack:</strong> <a href="https://teamcodeand.slack.com/archives/G86S99BH8" target="_blank">Open Slack channel</a></li>
                        <li><strong>Email:</strong> <a href="mailto:team@codeand.com.au" target="_blank">team@codeand.com.au</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
);
```
