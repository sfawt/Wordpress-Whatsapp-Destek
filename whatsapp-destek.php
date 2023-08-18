<?php
/*
Plugin Name: Whatsapp Destek
Plugin URI: https://wt.net.tr/tema/whatsapp-destek
Description: WordPress sitenize WhatsApp destek ikonu ekler.
Version: 1.0
Author: Furkan Altıntaş
Author URI: https://furkanaltintas.com.tr
License: GPL-3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

// WhatsApp ayarlarının kaydedileceği fonksiyon
function whatsapp_destek_ayarlar_kaydet() {
  register_setting(
    'whatsapp_destek_ayarlar',   // Ayar grubu
    'whatsapp_destek_telefon',   // Telefon numarası için alan adı
    'sanitize_text_field'        // Verileri temizlemek için bir filtre
  );

  register_setting(
    'whatsapp_destek_ayarlar',   // Ayar grubu
    'whatsapp_destek_mesaj',     // İlk mesaj için alan adı
    'sanitize_textarea_field'    // Verileri temizlemek için bir filtre
  );

  register_setting(
    'whatsapp_destek_ayarlar',   // Ayar grubu
    'whatsapp_destek_adi',       // Kişi adı için alan adı
    'sanitize_text_field'        // Verileri temizlemek için bir filtre
  );

  register_setting(
    'whatsapp_destek_ayarlar',   // Ayar grubu
    'whatsapp_destek_aciklama',  // Mesai açıklaması için alan adı
    'sanitize_text_field'        // Verileri temizlemek için bir filtre
  );
}
add_action('admin_init', 'whatsapp_destek_ayarlar_kaydet');

// WhatsApp ayar sayfasını ekleyen fonksiyon
function whatsapp_destek_ayar_sayfasi() {
  add_menu_page(
    'WhatsApp Destek Ayarları',    // Sayfa başlığı
    'WhatsApp Destek',            // Menü adı
    'manage_options',             // Gerekli yetki seviyesi
    'whatsapp-destek-ayarlar',    // Sayfa slug
    'whatsapp_destek_ayar_sayfasi_ic', // Sayfa içeriği çağırma fonksiyonu
    'dashicons-whatsapp'          // Menü simgesi (isteğe bağlı)
  );
}
add_action('admin_menu', 'whatsapp_destek_ayar_sayfasi');

// WhatsApp ayar sayfasının içeriğini oluşturan fonksiyon
function whatsapp_destek_ayar_sayfasi_ic() {
  // Ayarlar kaydedilmiş mi?
  if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
    echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
      <p><strong>Ayarlar kaydedildi.</strong></p>
      <button type="button" class="notice-dismiss"><span class="screen-reader-text">Bu bildirimi kapat</span></button>
    </div>';
  }

  // WhatsApp ayarları
  $telefon_numarasi = get_option('whatsapp_destek_telefon');
  $ilk_mesaj = get_option('whatsapp_destek_mesaj');
  $whatsapp_adi = get_option('whatsapp_destek_adi');
  $mesai_aciklama = get_option('whatsapp_destek_aciklama');
  ?>
  <div class="wrap">
    <h1>WhatsApp Destek Ayarları</h1>
    <form method="post" action="options.php">
      <?php
      settings_fields('whatsapp_destek_ayarlar');
      do_settings_sections('whatsapp_destek_ayarlar');
      submit_button();
      ?>

      <h2>WhatsApp İletişim Bilgileri</h2>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Telefon Numarası</th>
          <td>
            <input type="text" name="whatsapp_destek_telefon" value="<?php echo esc_attr($telefon_numarasi); ?>" />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">İlk Mesaj</th>
          <td>
            <textarea name="whatsapp_destek_mesaj" rows="4" cols="50"><?php echo esc_textarea($ilk_mesaj); ?></textarea>
          </td>
        </tr>
      </table>

      <h2>WhatsApp Mesaj İçeriği</h2>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Kişi Adı</th>
          <td>
            <input type="text" name="whatsapp_destek_adi" value="<?php echo esc_attr($whatsapp_adi); ?>" />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Mesai Açıklaması</th>
          <td>
            <input type="text" name="whatsapp_destek_aciklama" value="<?php echo esc_attr($mesai_aciklama); ?>" />
          </td>
        </tr>
      </table>
      <?php
      submit_button();
      ?>
    </form>
  </div>
  <?php
}

// WhatsApp ikonunu header'a ekleyen fonksiyon
function whatsapp_destek_ekle() {
  // Telefon numarası ve ilk mesaj bilgisini ayarlardan al
  $telefon_numarasi = get_option('whatsapp_destek_telefon');
  $ilk_mesaj = get_option('whatsapp_destek_mesaj');
  
  ?>
	<div class="wassenger">
		<div type="floating" class="Window__Component-sc-17wvysh-0 dVYIqU">
	        <div type="floating" class="Window__WindowComponent-sc-17wvysh-1 llcnCH" style="width: 360px; display: none;" id="chat_kutusu"> <!-- djUbPg değişecek class-->
	            <div color="rgb(255, 255, 255)" role="button" tabindex="0" class="cm-combination Close__Component-sc-1l05yq5-0 drfHxL" id="off_chat_kutusu" style="display: none;"></div>
	            <div class="Header__Component-sc-1y135nm-0 kdxbgZ"><div size="52" class="UserImage__Component-sc-1x4ogkw-0 eZEgcx">
	                <div class="UserImage__ImageContainer-sc-1x4ogkw-1 izlSME"><div class="UserImage__Image-sc-1x4ogkw-2 jtCmja"></div>
	            </div>
	        </div>
	        <div class="Header__Info-sc-1y135nm-1 hhASjW">
	            <div class="Header__Name-sc-1y135nm-2 hDGnqR"><?php echo esc_html(get_option('whatsapp_destek_adi')); ?></div>
	            <div class="Header__AnswerTime-sc-1y135nm-3 ioFWLq">Mesai Saatlerinde 30 dakika içinde cevap verir.</div>
	        </div>
	        </div>
	        <div pattern="/images/whatsapp.png" class="WhatsappChat__Component-sc-1wqac52-0 ewIAEB">
	            <div class="WhatsappChat__MessageContainer-sc-1wqac52-1 cWUfUj">
	                <div class="WhatsappDots__Component-pks5bf-0 iNguXd" style="opacity: 0;">
	                    <div class="WhatsappDots__ComponentInner-pks5bf-1 kYdave">
	                        <div class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotOne-pks5bf-3 eMFEyG"></div>
	                        <div class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotTwo-pks5bf-4 jAqeVd"></div>
	                        <div class="WhatsappDots__Dot-pks5bf-2 WhatsappDots__DotThree-pks5bf-5 CPQqS"></div>
	                    </div>
	                </div>
	                <div class="WhatsappChat__Message-sc-1wqac52-4 dSUAOZ" style="opacity: 1;">
	                    <div class="WhatsappChat__Author-sc-1wqac52-3 acKCA"><?php echo esc_html(get_option('whatsapp_destek_adi')); ?></div>
	                    <div class="WhatsappChat__Text-sc-1wqac52-2 hOnFlx"><?php echo esc_html(get_option('whatsapp_destek_aciklama')); ?></div>
	                    <div class="WhatsappChat__Time-sc-1wqac52-5 dPhWdq">13:49</div>
	                </div>
	            </div>
	        </div>
	        <a role="button" href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($telefon_numarasi); ?>&text=<?php echo esc_attr($ilk_mesaj); ?>" title="WhatsApp" class="DefaultButton__DefaultButtonComponent-ulobej-0 jwwAjt">
	            <svg width="20" height="20" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" class="WhatsappButton__Icon-jyajcx-0 jkaHSM">
	                <path d="M90,43.841c0,24.213-19.779,43.841-44.182,43.841c-7.747,0-15.025-1.98-21.357-5.455L0,90l7.975-23.522   c-4.023-6.606-6.34-14.354-6.34-22.637C1.635,19.628,21.416,0,45.818,0C70.223,0,90,19.628,90,43.841z M45.818,6.982   c-20.484,0-37.146,16.535-37.146,36.859c0,8.065,2.629,15.534,7.076,21.61L11.107,79.14l14.275-4.537   c5.865,3.851,12.891,6.097,20.437,6.097c20.481,0,37.146-16.533,37.146-36.857S66.301,6.982,45.818,6.982z M68.129,53.938   c-0.273-0.447-0.994-0.717-2.076-1.254c-1.084-0.537-6.41-3.138-7.4-3.495c-0.993-0.358-1.717-0.538-2.438,0.537   c-0.721,1.076-2.797,3.495-3.43,4.212c-0.632,0.719-1.263,0.809-2.347,0.271c-1.082-0.537-4.571-1.673-8.708-5.333   c-3.219-2.848-5.393-6.364-6.025-7.441c-0.631-1.075-0.066-1.656,0.475-2.191c0.488-0.482,1.084-1.255,1.625-1.882   c0.543-0.628,0.723-1.075,1.082-1.793c0.363-0.717,0.182-1.344-0.09-1.883c-0.27-0.537-2.438-5.825-3.34-7.977   c-0.902-2.15-1.803-1.792-2.436-1.792c-0.631,0-1.354-0.09-2.076-0.09c-0.722,0-1.896,0.269-2.889,1.344   c-0.992,1.076-3.789,3.676-3.789,8.963c0,5.288,3.879,10.397,4.422,11.113c0.541,0.716,7.49,11.92,18.5,16.223   C58.2,65.771,58.2,64.336,60.186,64.156c1.984-0.179,6.406-2.599,7.312-5.107C68.398,56.537,68.398,54.386,68.129,53.938z"></path>
	            </svg>
	            <span class="DefaultButton__DefaultButtonText-ulobej-1 hqsrSh"> Whatsapp' tan Bilgi Al!</a></span>
	        </a>
	    </div>
	    <div role="button" tabindex="0" type="bubble" class="cm-combination Bubble__BubbleComponent-sc-83hmjh-2 hqtxZK" id="sw_chat_kutusu">
	        <div class="Icon__Component-sc-6s5exc-0 eaUCvE Bubble__StyledIcon-sc-83hmjh-1 hzZnJx" id="sw_chat_kutusu">
	            <svg viewBox="0 0 90 90" fill="rgb(79, 206, 93)" width="32" height="32">
	                <path d="M90,43.841c0,24.213-19.779,43.841-44.182,43.841c-7.747,0-15.025-1.98-21.357-5.455L0,90l7.975-23.522   c-4.023-6.606-6.34-14.354-6.34-22.637C1.635,19.628,21.416,0,45.818,0C70.223,0,90,19.628,90,43.841z M45.818,6.982   c-20.484,0-37.146,16.535-37.146,36.859c0,8.065,2.629,15.534,7.076,21.61L11.107,79.14l14.275-4.537   c5.865,3.851,12.891,6.097,20.437,6.097c20.481,0,37.146-16.533,37.146-36.857S66.301,6.982,45.818,6.982z M68.129,53.938   c-0.273-0.447-0.994-0.717-2.076-1.254c-1.084-0.537-6.41-3.138-7.4-3.495c-0.993-0.358-1.717-0.538-2.438,0.537   c-0.721,1.076-2.797,3.495-3.43,4.212c-0.632,0.719-1.263,0.809-2.347,0.271c-1.082-0.537-4.571-1.673-8.708-5.333   c-3.219-2.848-5.393-6.364-6.025-7.441c-0.631-1.075-0.066-1.656,0.475-2.191c0.488-0.482,1.084-1.255,1.625-1.882   c0.543-0.628,0.723-1.075,1.082-1.793c0.363-0.717,0.182-1.344-0.09-1.883c-0.27-0.537-2.438-5.825-3.34-7.977   c-0.902-2.15-1.803-1.792-2.436-1.792c-0.631,0-1.354-0.09-2.076-0.09c-0.722,0-1.896,0.269-2.889,1.344   c-0.992,1.076-3.789,3.676-3.789,8.963c0,5.288,3.879,10.397,4.422,11.113c0.541,0.716,7.49,11.92,18.5,16.223   C58.2,65.771,58.2,64.336,60.186,64.156c1.984-0.179,6.406-2.599,7.312-5.107C68.398,56.537,68.398,54.386,68.129,53.938z"></path>
	            </svg>
	        </div>
	        <div class="Bubble__BubbleText-sc-83hmjh-0 hYqWcg"></div>
	    </div>
	</div>

  <?php
}
add_action('wp_head', 'whatsapp_destek_ekle');

// Stil dosyasını ekleyen fonksiyon
function enqueue_whatsapp_destek_styles() {
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
  wp_enqueue_style('whatsapp-destek-style', plugin_dir_url(__FILE__) . 'whatsapp-destek.css');
}
add_action('wp_enqueue_scripts', 'enqueue_whatsapp_destek_styles');
function whatsapp_destek_js() {
  // jQuery kütüphanesini yükle
  wp_enqueue_script('jquery');

  // JavaScript kodlarını ekle
  wp_enqueue_script('whatsapp-destek-script', plugin_dir_url(__FILE__) . 'whatsapp-destek-script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'whatsapp_destek_js');
?>
