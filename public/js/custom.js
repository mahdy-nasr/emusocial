$(document).ready(function() {
   /*============ Chat sidebar ========*/
  $('.chat-sidebar, .nav-controller, .chat-sidebar a').on('click', function(event) {
      $('.chat-sidebar').toggleClass('focus');
  });

  $(".hide-chat").click(function(){
      $('.chat-sidebar').toggleClass('focus');
  });

  /*============= About page ==============*/
  $(".about-tab-menu .list-group-item").click(function(e) {
      e.preventDefault();
      $(this).siblings('a.active').removeClass("active");
      $(this).addClass("active");
      var index = $(this).index();
      $("div.about-tab>div.about-tab-content").removeClass("active");
      $("div.about-tab>div.about-tab-content").eq(index).addClass("active");
  });
  if ($(".error-div")[0]) {
    err = $($(".error-div")[0]);
    //err.fadeIn(1000).delay(2000).fadeOut();
      err.slideDown(400).delay(2000).slideUp();

  }

  if ($(".error-div-fixed")[0]) {
    err = $($(".error-div-fixed")[0]);
    //err.fadeIn(1000).delay(2000).fadeOut();
      err.slideDown(500);

  }
})