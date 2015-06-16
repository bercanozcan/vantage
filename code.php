<?php 

      $post_id = wp_insert_post( array(
	                    'post_status' => $durum,
	                    'post_type' => $tur,
	                    'post_title' => $gelen_baslik,
	                    'post_content' => $gelen_icerik,
	                    //'post_date' => $gelen_zaman,
	  					//'post_date_gmt' => $gelen_zaman,
	  					'tax_input' => array('listing_category' => $arrg_kategori, 'listing_tag' => $arrg_etiket)
	  				));
			GLOBAL $wpdb; 
			$wpdb->insert( $wpdb->app_geodata, array( 'post_id' => $post_id, 'lat' => $gelen_enlem, 'lng' => $gelen_boylam )); 
			// Özel alanlar..
			add_post_meta( $post_id, 'phone', $gelen_tel );
				$son_adres = $gelen_adres.' '.sef_link($gelen_il);
			add_post_meta( $post_id, 'address', $son_adres );
			add_post_meta( $post_id, 'kontrol', $temiz_baslik );
			//add_post_meta( $post_id, 'listing_claimable', '1' );
			add_post_meta( $post_id, 'app_kredi-kart-kabul-edilir', 'Evet' );
			add_post_meta( $post_id, 'app_fiyat-aral', '₺₺' );
			add_post_meta( $post_id, 'featured', '0' );
			add_post_meta( $post_id, 'featured-cat', '0' );
			add_post_meta( $post_id, 'featured-home', '0' );
			add_post_meta( $post_id, 'listing_duration', '0' );
			// Öne çıkan görsel
			$upload_dir = wp_upload_dir();

			$image_data = siteConnect($gelen_gorsel); 
			$filename   = basename($gelen_gorsel); 
			if( wp_mkdir_p( $upload_dir['path'] ) ) {
				$file = $upload_dir['path'] . '/' . $filename;
			} else {
				$file = $upload_dir['basedir'] . '/' . $filename;
			}
			file_put_contents( $file, $image_data );
			$wp_filetype = wp_check_filetype( $filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => sanitize_file_name( $ilan_baslik ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			set_post_thumbnail( $post_id, $attach_id );
			
			echo 1;


?>
