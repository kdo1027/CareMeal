<?php
   require_once( ABSPATH . 'wp-load.php' );
    $wordpress_upload_dir = wp_upload_dir();
    if (!empty($_FILES['profilepicture']['tmp_name'])) {
        $i = 1;
        $profilepicture = $_FILES['profilepicture'];
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
        $new_file_mime = $profilepicture['type'];
        $av_id = 'nl_av_' . time();
        if( empty( $profilepicture ) )
            die( 'Ảnh chưa được chọn.' );
        if( $profilepicture['error'] )
            die( $profilepicture['error'] );
        if( $profilepicture['size'] > wp_max_upload_size() )
            die( 'Kích thước ảnh quá lớn.' );
        if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
            die( 'WordPress không đọc được định dạng này.' );
        while( file_exists( $new_file_path ) ) {
            $i++;
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
        }
        $new_file_path_db=strstr($new_file_path,'/wp-content');
        if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
            $upload_id = wp_insert_attachment( array(
                'guid'           => $new_file_path, 
                'post_mime_type' => $new_file_mime,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'post_excerpt'   => $av_id
            ), $new_file_path );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
        }
    }
    if (!empty($_FILES['profilepicture_2']['tmp_name'])){
        $i_2 = 1;
        $profilepicture_2 = $_FILES['profilepicture_2'];
        $new_file_path_2 = $wordpress_upload_dir['path'] . '/' . $profilepicture_2['name'];
        $new_file_mime_2 = $profilepicture_2['type'];
        $if_id = 'nl_if_' . time();
        if( empty( $profilepicture_2 ) )
            die( 'Ảnh chưa được chọn.' );
        if( $profilepicture_2['error'] )
            die( $profilepicture_2['error'] );
        if( $profilepicture_2['size'] > wp_max_upload_size() )
            die( 'Kích thước ảnh quá lớn.' );
        if( !in_array( $new_file_mime_2, get_allowed_mime_types() ) )
            die( 'WordPress không đọc được định dạng này.' );
        while( file_exists( $new_file_path_2 ) ) {
            $i_2++;
            $new_file_path_2 = $wordpress_upload_dir['path'] . '/' . $i_2 . '_' . $profilepicture_2['name'];
        }
        $new_file_path_2_db=strstr($new_file_path_2,'/wp-content');
        if( move_uploaded_file( $profilepicture_2['tmp_name'], $new_file_path_2 ) ) {
            $upload_id_2 = wp_insert_attachment( array(
                'guid'           => $new_file_path_2, 
                'post_mime_type' => $new_file_mime_2,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture_2['name'] ),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'post_excerpt'   => $if_id
            ), $new_file_path_2 );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            wp_update_attachment_metadata( $upload_id_2, wp_generate_attachment_metadata( $upload_id_2, $new_file_path_2 ) );
        }
    }
?>