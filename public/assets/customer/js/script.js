$(document).ready(function() {
 
  // Carousel slider
  $("#product-preview").owlCarousel({
 
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });

  // Show more and less
  $(".show-more a").each(function() {
      var $link = $(this);
      var $content = $link.parent().prev("div.text-content");

      console.log($link);

      var visibleHeight = $content[0].clientHeight;
      var actualHide = $content[0].scrollHeight - 1;

      console.log(actualHide);
      console.log(visibleHeight);

      if (actualHide > visibleHeight) {
          $link.show();
      } else {
          $link.hide();
      }
  });

  // $(".show-more a").on("click", function() {
  //     var $link = $(this);
  //     var $content = $link.parent().prev("div.text-content");
  //     var linkText = $link.text();

  //     $content.toggleClass("short-text full-text");

  //     $link.text(getShowLinkText(linkText));

  //     return false;
  // });

  // function getShowLinkText(currentText) {
  //     var newText = '';

  //     if (currentText.toUpperCase() === "SHOW MORE") {
  //         newText = "Show less";
  //     } else {
  //         newText = "Show more";
  //     }

  //     return newText;
  // }

  // Typekit

  (function(d) {
    var config = {
      kitId: 'cop6cra',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
 
});