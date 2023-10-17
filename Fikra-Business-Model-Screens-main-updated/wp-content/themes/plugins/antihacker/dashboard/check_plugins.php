<?php
/**
 * @author William Sergio Minozzi
 * @copyright 2021
 */
if (!defined('ABSPATH'))
   exit; // Exit if accessed directly 
global $antihacker_last_plugin_scan;
if( isset( $_GET[ 'notif' ] ) ){ 
   $notif = sanitize_text_field($_GET[ 'notif' ]);
   if($notif == 'plugins')
      update_option('antihacker_last_plugin_scan', time());
}
if( isset( $_GET[ 'action' ] ) ){ 
    $action = sanitize_text_field($_GET[ 'action' ]);
    if($action == 'scan'){
       update_option('antihacker_last_plugin_scan', time());
      flush();
       antihacker_scan_plugins();
       return;
    }
 }
$timeout = time() > ($antihacker_last_plugin_scan + 60 * 60 * 24 * 3);
$timeout = time() > ($antihacker_last_plugin_scan + 10);
$site = ANTIHACKERHOMEURL . "admin.php?page=anti_hacker_plugin&tab=plugins&notif=";
?>
<div id="antihacker-notifications-page">
   <div class="antihacker-block-title">
      <?php esc_attr_e('Check Plugins','antihacker'); ?>
   </div>
   <div id="notifications-tab">
    <b>
    <?php esc_attr_e('Check Plugins for updates.','antihacker');?>
    </b>
    <br>
    <?php esc_attr_e('This test will check all your plugins against WordPress repository to see 
    if they are updated last one year. Plugins not updated last one year
    are suspect to be abandoned and we suggest replace them.','antihacker');?>
    <br>
    <br>
    <?php
    $timeout_plugin = time() > ($antihacker_last_plugin_scan + 60 * 60 * 24 * 365);

    if(!$timeout_plugin){
      echo esc_attr__('Last check for updates made (Y-M-D):', 'antihacker').' ';
      echo date ('Y-m-d', esc_attr($antihacker_last_plugin_scan));
    }
    ?>
<br>
<br>
<a href="<?php echo esc_url($site);?>plugins&action=scan" class="button button-primary"><?php esc_attr_e('Check Plugins Now','antihacker');?></a>
   </div>
</div>
<?php
function antihacker_scan_plugins()
{
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
   $all_plugins_work = get_plugins();
   $all_plugins = array_keys($all_plugins_work);
    $q = count($all_plugins);
   echo '<br>';
    for($i=0; $i< $q; $i++)
    {
            $pos = strpos($all_plugins[$i], '/');
            $myplugin = trim(substr($all_plugins[$i], 0, $pos));
            if(empty($myplugin))
              continue;

            if(strlen($myplugin) < 3)
              continue;

            $pluginData = antihackerCheckPluginUpdate($myplugin);
            if(!isset($pluginData['last_updated']))
               $last_update = 'Not Found => ';
            else
               $last_update = substr($pluginData['last_updated'],0,10);
            $timeout = strtotime($last_update) + (60*60*24*365) ;
            if($timeout < time()  )
                  echo">>>>>>>>>>> ";
            echo esc_attr($last_update);
            echo ' - '.esc_attr($myplugin);
            echo '<br>';
            echo '<hr>';
    }
}
/**
	 * Checks whether the required settings for our schema markup are set.
	 *
	 * @since 3.0.0
	 *
	 * @return array The test result.
	 */
	function antihackerCheckPluginUpdate($plugin) {
		$response = wp_remote_get('https://api.wordpress.org/plugins/info/1.0/'.esc_attr($plugin).'.json' );
		$body     = wp_remote_retrieve_body( $response );
		if ( ! $body ) {
			// Something went wrong.
			return "";
		}
		return json_decode( $body, true );
}
