<?php defined('SYSPATH') or die('No direct script access.');

/**
 * View used for generating network disconnect link. Parameters:
 * - $network - name of the network (displayed in message),
 * - $network_alias (optional) - the alias being passed to the server when
 *      disconnecting from the service; if none, the lowercase $network assumed
 */

// if no network alias is given, use network name
$network_alias = !empty($network_alias) ? $network_alias : strtolower($network);

echo HTML::anchor('#', __('Disconnect from :network', array(
    ':network' => $network,
)), array(
    'class' => 'social-disconnect',
    'data-action' => 'disconnect',
    'data-network' => $network_alias,
    'data-network-name' => $network,
));
