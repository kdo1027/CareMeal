<?php
defined( 'ABSPATH' ) or die();

$header_classes = 'organium_header';
if ( !empty(organium_get_prefered_option('header_style')) ) {
	$header_classes .= ' organium_header_' . esc_attr(organium_get_prefered_option('header_style'));
}
if ( !empty(organium_get_prefered_option('header_position')) ) {
	$header_classes .= ' header_position_' . esc_attr(organium_get_prefered_option('header_position'));
}
if ( !empty(organium_get_prefered_option('sticky_header')) ) {
	$header_classes .= ' organium_sticky_header_' . esc_attr(organium_get_prefered_option('sticky_header'));
}

$mobile_classes = 'header_mobile';
if ( !empty(organium_get_prefered_option('header_position')) ) {
	$mobile_classes .= ' header_position_' . esc_attr(organium_get_prefered_option('header_position'));
}
if ( !empty(organium_get_prefered_option('sticky_header')) ) {
	$mobile_classes .= ' organium_sticky_header_' . esc_attr(organium_get_prefered_option('sticky_header'));
}
if ( !empty(organium_get_prefered_option('header_style')) ) {
	$mobile_classes .= ' organium_mobile_header_' . esc_attr(organium_get_prefered_option('header_style'));
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="cache-control" content="max-age=0">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
	<meta http-equiv="pragma" content="no-cache">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<script src="https://unpkg.com/ml5@latest/dist/ml5.min.js"></script>
	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/60549468f7ce18270931d134/1f1567f2u';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
		})();
	</script>
	<!--End of Tawk.to Script-->
	<?php wp_head(); ?>
</head>
<?php
if ( is_user_logged_in() ){
	$user=wp_get_current_user();
	$user_id=$user->ID;
	$user_roles=$user->roles;
	$id_hs=get_user_meta( $user_id, 'user_registration_input_box_1606780902', true);
}
else{
	?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
	<script type="text/javascript">
		Push.create('Bạn chưa đăng nhập', {
			body: 'Hãy đăng nhập để nhận thông báo mới nhất về dinh dưỡng hàng hàng của bạn',
			icon: 'https://caremeal.vn/caremeal.png',
			timeout: 8000,             
			onClick: function() {
				location.href="/thuc-don/"
			}  
		});
	</script>
	<?php
}
?>
<!--  -->
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} ?>
	<div class="body-overlay"  <?php if($user_roles[0]=="phu_huynh" || $user_roles[0]=="hoc_sinh"){echo 'cm_id_use="'.$id_hs.'"';} ?>></div>

	<?php if ( organium_get_prefered_option('page_loader') == 'on' ) { ?>
		<div class="page_loader_container">
			<div class="page_loader">
				<div class="page_loader_inner">
					<img src="<?php echo esc_url(get_template_directory_uri() . '/img/title.png'); ?>" alt="<?php esc_html_e('Loader Logo', 'organium') ?>" class="loader_logo">
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if ( organium_get_prefered_option('header_search') == 'on' ) { ?>
		<div class="site-search">
			<div class="close-search"></div>
			<?php get_search_form() ?>
		</div>
	<?php } ?>
	<?php get_template_part( 'templates/header/header_mobile_aside' ); ?>
	<div class="organium_page-wrapper">

		<!-- Side Panel -->
		<?php
		if (organium_get_prefered_option('side_panel') == 'on') {
			?>
			<div class="organium_aside-dropdown">
				<div class="organium_aside-dropdown__inner">
					<div class="organium_aside-dropdown__close"></div>

					<div class="organium_aside-dropdown__item">
						<?php dynamic_sidebar('sidebar-side'); ?>
					</div>
				</div>
			</div>
			<?php
		}
		?>

		<!-- Mobile Header -->
		<?php
		echo '<div class="' . esc_attr($mobile_classes) . '">';
		echo(organium_get_prefered_option('sticky_header') == 'on' ? '<div class="sticky_wrapper">' : '');
		get_template_part( 'templates/header/header_mobile' );
		echo(organium_get_prefered_option('sticky_header') == 'on' ? '</div>' : '');
		echo '</div>';
		?>

		<!-- Header -->
		<?php
		echo '<header class="' . esc_attr($header_classes) . '">';
		echo '<div class="sticky_wrapper">';
		switch( organium_get_prefered_option('header_style') ){
			case 'type_2' :
			get_template_part( 'templates/header/header_2' );
			break;
			case 'type_3' :
			get_template_part( 'templates/header/header_3' );
			break;
			default :
			get_template_part( 'templates/header/header_1' );
			break;
		}
		echo '</div>';
		echo '</header>';
		?>