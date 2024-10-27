<?php
// Verhindere direkten Zugriff auf diese Datei
if (!defined('ABSPATH')) {
    exit;
}

$GLOBALS['NoResultsDefaultText'] = "Für diese Anfrage sind keine Einträge verfügbar.";

add_action('admin_menu', 'ASA_plugin_admin_add_page');
function ASA_plugin_admin_add_page() {
    add_options_page('Artemis Stellenanzeigen Einstellungen', 'Artemis Stellenanzeigen', 'manage_options', 'artemis-wp-plugin', 'ASA_plugin_options_page');
}

function ASA_plugin_options_page() {
    ?>
    <div class="wrap">
        <h1>Artemis Stellenanzeigen Plugin - Einstellungen</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('plugin_options');
            do_settings_sections('artemis-wp-plugin');
            submit_button();
            ?>
        </form>
        <form method="post">
            <?php wp_nonce_field('asa_reset_settings', 'asa_reset_nonce'); ?>
            <input type="hidden" name="asa_reset_settings" value="1" />
            <?php submit_button('Einstellungen zurücksetzen', 'secondary', 'submit', false, array('onclick' => "return confirm('Sind Sie sicher, dass Sie die Einstellungen zurücksetzen möchten?');")); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'ASA_plugin_admin_init');
function ASA_plugin_admin_init() {
    register_setting('plugin_options', 'plugin_options', 'ASA_plugin_options_validate');
    add_settings_section('plugin_main', 'Haupteinstellungen', 'ASA_plugin_section_text', 'artemis-wp-plugin');
    add_settings_field('plugin_url_string', 'Artemis URL:', 'ASA_plugin_setting_string', 'artemis-wp-plugin', 'plugin_main');
    add_settings_field('plugin_css_string', 'Individuelles CSS:', 'ASA_plugin_setting_css', 'artemis-wp-plugin', 'plugin_main');
    add_settings_field('plugin_no_results_string', 'Keine-Einträge-Hinweis:', 'ASA_plugin_setting_no_results', 'artemis-wp-plugin', 'plugin_main');
    add_settings_field('plugin_show_kurzbeschreibung', 'Kurzbeschreibung anzeigen:', 'ASA_plugin_setting_checkbox', 'artemis-wp-plugin', 'plugin_main', array('option' => 'show_kurzbeschreibung'));
    add_settings_field('plugin_show_suchleiste', 'Suchleiste anzeigen:', 'ASA_plugin_setting_checkbox', 'artemis-wp-plugin', 'plugin_main', array('option' => 'show_suchleiste'));
    add_settings_field('plugin_open_in_actual_tab', 'Bewerben-Link im aktuellen Tab öffnen:', 'ASA_plugin_setting_checkbox', 'artemis-wp-plugin', 'plugin_main', array('option' => 'open_in_actual_tab'));
    add_settings_field('plugin_show_logo', 'Firmenlogo anzeigen:', 'ASA_plugin_setting_checkbox', 'artemis-wp-plugin', 'plugin_main', array('option' => 'show_logo'));
}

function ASA_plugin_section_text() {
    echo '<p>Hier können Sie die Einstellungen für das Artemis Stellenanzeigen Plugin anpassen.</p>';
    echo '<p>Um das Plugin zu verwenden, fügen Sie einfach auf Ihrer Wordpress-Seite den folgenden Shortcode ein: <code>[artemis-stellenanzeigen]</code></p>';
    echo '<p>Im Shortcode kann optional die URL Ihrer Schnittstelle angegeben werden: z.B. <code>[artemis-stellenanzeigen url="https://YOUR-ARTEMIS-DOMAIN/GetAktuelleStellenanzeigen"]</code></p>';
    
    echo '<div style="background-color: #e5e5e5; border-left: 5px solid #0073aa; padding: 10px; margin-top: 20px;">';
    echo '<p><strong>Wichtiger Hinweis zum Caching:</strong></p>';
    echo '<p>Um sicherzustellen, dass aktualisierte Stellenanzeigen schnell auf Ihrer Homepage angezeigt werden, ist es wichtig, den Cache für die Seite, auf der die Stellenanzeigen eingebunden sind, zu deaktivieren oder sehr kurz zu halten.</p>';
    echo '<p>Wenn Sie ein Caching-Plugin verwenden, konfigurieren Sie es so, dass die Seite mit den Stellenanzeigen ausgeschlossen wird oder nur für eine sehr kurze Zeit gecacht wird (z.B. 5 Minuten).</p>';
    echo '</div>';
}

function ASA_plugin_setting_string() {
    $options = get_option('plugin_options');
    echo "<input id='plugin_url_string' name='plugin_options[url_string]' size='70' type='text' value='" . esc_attr($options['url_string']) . "' />";
    echo "<p class='description'>Geben Sie hier die URL Ihrer Artemis-Installation ein. Diese URL sollte in der Regel auf folgende URL verweisen: https://YOUR-ARTEMIS-DOMAIN/GetAktuelleStellenanzeigen</p>";
}

function ASA_plugin_setting_css() {
    $options = get_option('plugin_options');
    echo "<textarea id='plugin_css_string' name='plugin_options[css_string]' rows='10' cols='67'>" . esc_textarea($options['css_string']) . "</textarea>";
    
    // Ermittle den Pfad zur CSS-Datei im Plugin
    $css_file_path = plugin_dir_path(__FILE__) . 'css/artemis-stellenanzeigen.css';
    $css_file_url = plugins_url('css/artemis-stellenanzeigen.css', __FILE__);
    
    if (file_exists($css_file_path)) {
        echo "<p class='description'>Hier können Sie benutzerdefiniertes CSS eingeben, um das Aussehen der Stellenanzeigen anzupassen. Dieses CSS überschreibt die Stile, die in der Datei <a href='" . esc_url($css_file_url) . "' target='_blank'>artemis-stellenanzeigen.css</a> definiert sind.</p>";
        echo "<p class='description'><strong>Tipp:</strong> Sie können die Originaldatei als Referenz verwenden, um zu sehen, welche Stile Sie anpassen möchten.</p>";
    } else {
        echo "<p class='description'>Hier können Sie benutzerdefiniertes CSS eingeben, um das Aussehen der Stellenanzeigen anzupassen. Die Original-CSS-Datei konnte nicht gefunden werden.</p>";
    }
}

function ASA_plugin_setting_no_results() {
    $options = get_option('plugin_options');
    if (empty($options['no_results_string'])) {
        $options['no_results_string'] = $GLOBALS['NoResultsDefaultText'];
    }
    echo "<textarea id='plugin_no_results_string' name='plugin_options[no_results_string]' rows='4' cols='67'>" . esc_textarea($options['no_results_string']) . "</textarea>";
    echo "<p class='description'>Geben Sie hier den Text ein, der angezeigt werden soll, wenn keine Stellenanzeigen gefunden wurden.</p>";
}

function ASA_plugin_setting_checkbox($args) {
    $options = get_option('plugin_options');
    $option = $args['option'];
    $checked = isset($options[$option]) ? checked(1, $options[$option], false) : '';
    echo "<input type='checkbox' id='plugin_{$option}' name='plugin_options[{$option}]' value='1' {$checked} />";
    
    $descriptions = [
        'show_kurzbeschreibung' => 'Aktivieren Sie diese Option, um eine Kurzbeschreibung jeder Stellenanzeige in der Listenansicht anzuzeigen.',
        'show_suchleiste' => 'Aktivieren Sie diese Option, um eine Suchleiste über den Stellenanzeigen angezeigt.',
        'open_in_actual_tab' => 'Aktivieren Sie diese Option, wenn Sie möchten, dass die Stellenanzeigen und Bewerben-Links im aktuellen Tab geöffnet werden.',
        'show_logo' => 'Aktivieren Sie diese Option, um das Firmenlogo neben jeder Stellenanzeige anzuzeigen.'
    ];
    
    if (isset($descriptions[$option])) {
        echo "<p class='description'>{$descriptions[$option]}</p>";
    }
}

function ASA_plugin_options_validate($input) {
    $options = get_option('plugin_options');
    
    // Validiere und setze die Textfeld-Optionen
    $options['url_string'] = esc_url_raw($input['url_string']);
    $options['css_string'] = sanitize_textarea_field($input['css_string']);
    $options['no_results_string'] = empty($input['no_results_string']) ? $GLOBALS['NoResultsDefaultText'] : sanitize_textarea_field($input['no_results_string']);
    
    // Validiere und setze die Checkbox-Optionen
    $checkbox_options = ['show_kurzbeschreibung', 'show_suchleiste', 'open_in_actual_tab', 'show_logo'];
    
    foreach ($checkbox_options as $option) {
        $options[$option] = isset($input[$option]) && $input[$option] == '1';
    }

    return $options;
}

add_action('admin_init', 'ASA_plugin_check_reset_settings');

function ASA_plugin_check_reset_settings() {
    if (isset($_POST['asa_reset_settings']) && $_POST['asa_reset_settings'] == '1') {
        if (check_admin_referer('asa_reset_settings', 'asa_reset_nonce')) {
            delete_option('plugin_options');
            add_settings_error('plugin_options', 'settings_reset', 'Plugin-Einstellungen wurden auf die Standardwerte zurückgesetzt.', 'updated');
        }
    }
}
?>