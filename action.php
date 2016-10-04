<?php
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
class action_plugin_authadeid extends DokuWiki_Action_Plugin {
    /**
     * Registers the event handlers.
     */
    function register(Doku_Event_Handler $controller)
    {

        $controller->register_hook('HTML_LOGINFORM_OUTPUT', 'BEFORE',  $this, 'hook_html_loginform_output', array());
    }
    /**
     * Handles the login form rendering.
     */
    function hook_html_loginform_output(&$event, $param) {
        global $ID;
        //$url = $this->getConf('service_url');
        $url = DOKU_URL . 'lib/plugins/authadeid/endpoint/';

        ?>

            <p>
                <a href="<?php echo $url; ?>"><img src="<?php echo DOKU_URL . 'lib/plugins/authadeid/images/idkaart.gif'; ?>"></img></a>
            </p>

        <?php
    }
}
?>
