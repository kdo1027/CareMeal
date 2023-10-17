<?php
/*
 * Created by Artureanec
*/

$search_rand = mt_rand(0, 999);
$search_js = 'javascript:document.getElementById("search-' . esc_attr($search_rand) . '").submit();';
?>

<form name="search_form" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="organium_search_form" id="search-<?php echo esc_attr($search_rand); ?>">
    <span class="organium_icon_search" onclick="<?php echo esc_js($search_js); ?>"></span>
    <input type="text" name="s" value="" placeholder="<?php esc_attr_e('Search...', 'organium'); ?>" title="<?php esc_attr_e('Search', 'organium'); ?>" class="form__field">
    <div class="clear"></div>
</form>
