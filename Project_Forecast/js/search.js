$(".search-btn").click(function(){
    $("#weather-cards"). css("display", "none");
    $("#paginator"). css("display", "none");
    $("#footer"). css("display", "none");
    $(".wrapper").addClass("active");
    $(this).css("display","none");
    $(".search-data").fadeIn(500);
    $(".close-btn").fadeIn(500);
    $(".search-data .line").addClass("active");
      setTimeout(function(){
        $("input").focus();
        $(".search-data label").fadeIn(500);
        $(".search-data span").fadeIn(500);
      }, 800);
     });
     

    $(".close-btn").click(function(){
        $("#weather-cards").show();
        $("#paginator").show();
        $("#footer").show();
      $(".wrapper").removeClass("active");
      $(".search-btn").fadeIn(800);
      $(".search-data").fadeOut(500);
      $(".close-btn").fadeOut(500);
      $(".search-data .line").removeClass("active");
      $("input").val("");
      $(".search-data label").fadeOut(500);
      $(".search-data span").fadeOut(500);
    });
    
    var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();