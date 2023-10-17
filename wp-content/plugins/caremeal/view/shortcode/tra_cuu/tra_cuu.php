<?php
function create_shortcode_nguyen_lieu() {
	ob_start();
	$pageURL =  $_SERVER["REQUEST_URI"]; 
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'cm_nguyen_lieu WHERE url = "'.$pageURL.'"' ); ?>
	<img src="<?php echo getCurURL(); echo $results[0]->anh_if; ?>">
	<div class="vb-download">
		<a href="<?php echo getCurURL(); echo $results[0]->anh_if; ?>" download>Tải xuống</a>
	</div>
	<?php
	$bmi_dinh_duong = ob_get_contents(); 
	ob_end_clean();
	return $bmi_dinh_duong;
}
add_shortcode( 'nguyen_lieu', 'create_shortcode_nguyen_lieu' );
