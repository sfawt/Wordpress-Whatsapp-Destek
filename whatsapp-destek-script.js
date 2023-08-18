// WhatsApp ikonu tıklamalarını işlemek için değişken
var isChatKutusuAcik = false;

// WhatsApp ikonu tıklandığında açılır kutuyu gösterme işlevi
jQuery(document).ready(function($) {
  $("#sw_chat_kutusu").click(function() {
    if (!isChatKutusuAcik) {
      $("#chat_kutusu").show();
      $("#off_chat_kutusu").show();
      isChatKutusuAcik = true;
    } else {
      $("#chat_kutusu").hide();
      $("#off_chat_kutusu").hide();
      isChatKutusuAcik = false;
    }
  });

  $("#off_chat_kutusu").click(function() {
    $("#chat_kutusu").hide();
    $("#off_chat_kutusu").hide();
    isChatKutusuAcik = false;
  });
});
