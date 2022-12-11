<?php

/**
 * Plugin Name: Xenice Login
 * Plugin URI: https://www.xenice.com
 * Description: Beautify default login and add pop-up login
 * Version: 3.1.2
 * Author: Xenice
 * Author URI: https://www.xenice.com
 * Text Domain: xenice-login
 * Domain Path: /languages
 */


namespace xenice\login;

 /**
 * autoload class
 */
function __autoload($classname){
    $classname = str_replace('\\','/',$classname);
    
    $namespace = 'xenice/login';
    if(strpos($classname, $namespace) === 0){
        $filename = str_replace($namespace, '', $classname);
        require  __DIR__ .  $filename . '.php';
    }
}




 /**
 * get option
 */
function get($name, $key='xenice_login')
{
    
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}


 /**
 * set option
 */
function set($name, $value, $key='xenice_login')
{
    $options = get_option($key)?:[];
    foreach($options as $id=>&$o){
        if(isset($o[$name])){
            $o[$name] = $value;
            update_option($key, $options);
            return;
        }
    }
    
}

// Get page ID based on the template name
function get_page($template)
{
    global $wpdb;
    $page_id = $wpdb->get_var($wpdb->prepare("SELECT `post_id` 
    FROM `$wpdb->postmeta`, `$wpdb->posts`
    WHERE `post_id` = `ID`
    AND `post_status` = 'publish'
    AND `meta_key` = '_wp_page_template'
    AND `meta_value` = %s
    LIMIT 1;", $template));
    if($page_id){
        return get_post($page_id);
    }
}

function add_page($template){
    $post = [
        'post_name' => 'login',
        'post_title' => __('Login', 'xenice-login'),
        'post_status'=> 'publish',
        'post_type' => 'page'
    ];
    
    $id = wp_insert_post($post);
    
    if($id){
        update_post_meta($id, '_wp_page_template', $template);
    }
    
}

function scripts()
{
    if(!get('disable_bootstrap_lib')){
        $cdn_url = get('static_lib_cdn');
        if(!$cdn_url){
            $cdn_url = get_theme_mod('static_lib_cdn');
        }
        if($cdn_url){
            wp_enqueue_style('bootstrap-css', $cdn_url . '/twitter-bootstrap/4.4.1/css/bootstrap.min.css', [], '4.4.1');
            wp_enqueue_script('bootstrap-js', $cdn_url . '/twitter-bootstrap/4.4.1/js/bootstrap.min.js', [], '4.4.1',true);
        }
        else{
            wp_enqueue_style('bootstrap-css', plugins_url('static/libs/bootstrap/css/bootstrap.min.css', __FILE__), [], '4.4.1');
            wp_enqueue_script('bootstrap-js', plugins_url('static/libs/bootstrap/js/bootstrap.min.js', __FILE__), ['jquery'], '4.4.1',true);
        }
        
    }
        
    wp_enqueue_style('xenice-login-style-css', plugins_url('static/css/style.css', __FILE__), [], '1.0.3');
    wp_enqueue_script('xenice-login-script-js', plugins_url('static/js/script.js', __FILE__), ['jquery'], '1.0.3', true);
        
}

function head(){
    // set color
    $colors = get('display_color');
    if(!$colors){
        // Inherit theme color
        $colors = get_theme_mod('theme_color', '#0099FF #007bff #99CCFF');
    }
    
    $colors = explode(' ',$colors);
    list($a1, $a2, $a3) = $colors;
    $styles = [
        '.user-login a:hover'=>"{color:$a1;}",
        '.user-login .form-control:focus'=>"{border-color: $a3!important;}",
        '.user-login .btn-custom'=>"{color:#fff!important;background-color:$a1;border-color:$a1;}",
        '.user-login .btn-custom:hover'=>"{color:#fff;background-color:$a2;border-color:$a2}",
        '.user-login .nav-item .nav-link'=>"{color:$a3;}",
        '.user-login .nav-item .active'=>"{color:$a1;}",
        
        '.fa-weixin'=>"{color:#7BD172}",
        '.fa-qq'=>"{color:#f67585}",
        '.fa-weibo'=>"{color:#ff8d8d}",
    ];
    $str = '<style>';
    foreach($styles as $key => $style){
        $str .= $key . $style;
    }
    $str .= '</style>';
    echo $str;
    
    // min-width:768px
    $styles = [];
    $styles['.user-login .modal-dialog'] = '{width: '.get('modal_width').';}';
    $str = '<style>@media screen and (min-width:768px){';
    foreach($styles as $key => $style){
        $str .= $key . $style;
    }
    $str .= '}</style>';
    echo $str;
}

function footer(){
    $nonce = [
        'login' => wp_create_nonce('login'),
        'register' => wp_create_nonce('register'),
        'check_username' => wp_create_nonce('check_username'),
        'check_email' => wp_create_nonce('check_email'),
        'send_captcha' => wp_create_nonce('send_captcha'),
        // Reset password
        'forget_password' => wp_create_nonce('forget_password'), 
        'reset_password' => wp_create_nonce('reset_password'), 
    ];
            
    $arr = [
        'Login',
        'Register',
        'Username or email cannot be empty',
        'Password cannot be empty',
        'Login...',
        'Register...',
        'Username or password wrong',
        'Entered passwords differ',
        'Username can only be 6-16 characters composed of alphanumeric or underlined characters',
        'Email format error',
        'Password length at least 6',
        'The captcha cannot be empty',
        'Registered successfully',
        'Username or email cannot be empty',
        'execute...',
        'The link has been successfully sent to your email, please check and confirm.',
        'Get New Password',
        'Change password',
        'Password changed successfully, please remember the password.',
        'Your operation too fast, please wait a moment.',
        'Send in...',
        'Resend captcha',
        'Email already exists',
        'Send captcha',
        'The captcha failed to send. Please try again later.',
        'Captcha has been sent to the email, may appear in the dustbin oh ~',
    ];
    
    $lang = [];
    foreach($arr as $key){
        $lang[$key] = __($key, 'xenice-login');
    }
    
    $home_url = home_url();
    $action_url = admin_url('admin-ajax.php') . '?action=';
    $nonce = json_encode($nonce);
    $lang = json_encode($lang);
    $login_url = wp_login_url();
    
    
    
    echo <<<EOT
    <script>
    var xenice_login_home_url = "$home_url";
    var xenice_login_action_url = "$action_url";
    var xenice_login_nonce = $nonce;
    var xenice_login_lang = $lang;
    
    function xenice_login_t(key){
        return xenice_login_lang[key];
    }
    
    function xenice_login_show_modal(){
        jQuery('#login-modal').modal('show');
        return false;
    }
    
    function xenice_login_cut_modal(id1, id2)
    {
        jQuery(id1).removeClass('fade');
        jQuery(id1).modal('hide');
        jQuery(id1).addClass('fade');
        jQuery(id2).modal('show');
    }
    
    function xenice_login_check_name(str)
    {    
    	return /^[\w]{3,16}$/.test(str) ;
    }
    
    function xenice_login_check_mail(str)
    {
    	return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str);
    }
    
    function xenice_login_check_url(str)
    {
        return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str);
    }
    
    
   
    </script>
EOT;
    if(get('enable_login_modal')){
        include __DIR__ . '/templates/modal.php';
        
        echo <<<EOT
        <script>
        jQuery("#login-trigger").on('click',function(){
            xenice_login_cut_modal('#register-modal', '#login-modal');
        });
        
        jQuery("#register-trigger").on('click',function(){
            xenice_login_cut_modal('#login-modal', '#register-modal');
        });
        
        jQuery("#forget-password-trigger").on('click',function(){
            xenice_login_cut_modal('#login-modal', '#forget-password-modal');
        });
        
        // change login url
        jQuery(function(){
            var e = jQuery('a[href="$login_url"]');
            if(e.length>0){
                e.attr('data-toggle','modal');
                e.attr('data-target','#login-modal');
                e.attr('href','javascript:;');
            }
            
            var e = jQuery('a[href="$home_url/wp-login.php"]');
            if(e.length>0){
                e.attr('data-toggle','modal');
                e.attr('data-target','#login-modal');
                e.attr('href','javascript:;');
            }
            
        });

        </script>
EOT;
    
    }
    
}

function admin_footer()
{
    $msg = [
        'success' => __('Successfully copied to clipboard', 'xenice-login'),
        'failed' => __('The browser does not support link clicks to copy to the clipboard', 'xenice-login')
    ];
    echo <<<EOT
<script>

function xenice_login_copy (obj) {
var text = obj.href;
var textArea = document.createElement("textarea");
  textArea.style.position = 'fixed';
  textArea.style.top = '0';
  textArea.style.left = '0';
  textArea.style.width = '2em';
  textArea.style.height = '2em';
  textArea.style.padding = '0';
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';
  textArea.style.background = 'transparent';
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? '{$msg['success']}' : '{$msg['failed']}';
   alert(msg);
  } catch (err) {
    alert('{$msg['failed']}');
  }

  document.body.removeChild(textArea);
}
</script>
EOT;
    
}

function login_url( $login_url, $redirect, $force_reauth ){
    $row = get_page('xenice-login');
    if($row){
        return get_permalink($row->ID);
    }
	return $login_url;
}

register_activation_hook( __FILE__, function(){
    spl_autoload_register('xenice\login\__autoload');
    (new Config)->active();
    
    //Add login page
    $template = 'xenice-login';
    if(!get_page($template)){
        add_page($template);
    }
    
});


// load page templates

add_action('init', function(){
    add_filter( 'page_template', function($page_template){
        if ( get_page_template_slug() == 'xenice-login' ) {
    		$page_template = dirname( __FILE__ ) . '/templates/xenice-login.php';
    	}
    	return $page_template;
    });

    add_filter( 'theme_page_templates', function($post_templates, $wp_theme, $post, $post_type){
        $post_templates['xenice-login'] = __( 'Xenice Login', 'xenice-login' );
    	return $post_templates;
    }, 10, 4 );
});

    
add_action( 'plugins_loaded', function(){
    isset($_SESSION) || session_start();
    spl_autoload_register('xenice\login\__autoload');
    $plugin_name = basename(__DIR__);
    load_plugin_textdomain( $plugin_name, false , $plugin_name . '/languages/' );
    
    
    // Add setting menus
    add_action( 'admin_menu', function(){
        add_options_page(__('Login','xenice-login'), __('Login','xenice-login'), 'manage_options', 'xenice-login', function(){
            (new Config)->show();
        });
    });
    
     // Add setting button
    $plugin = plugin_basename (__FILE__);
    add_filter("plugin_action_links_$plugin" , function($links)use($plugin_name){
        $settings_link = '<a href="options-general.php?page='.$plugin_name.'">' . __( 'Settings', 'xenice-optimize') . '</a>' ;
        array_push($links , $settings_link);
        return $links;
    });
    
    new ajax\LoginAjax;
    add_action( 'wp_enqueue_scripts', 'xenice\login\scripts');
    add_action('wp_head', 'xenice\login\head');
    add_action('admin_footer', 'xenice\login\admin_footer');
    add_action('wp_footer', 'xenice\login\footer',99);
    add_filter( 'login_url', 'xenice\login\login_url', 10, 3 );
});
