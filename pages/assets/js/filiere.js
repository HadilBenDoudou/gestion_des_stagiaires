$(document).ready(function () {
    $("#searchBtn").on("click", function () {
      var category = $("#categorySelect").val().toLowerCase();

      // Hide all meeting items
      $(".meeting-item").hide();

      if (category === "all") {
        // Show all meeting items if "All Categories" is selected
        $(".meeting-item").show();
      } else {
        // Show only the meeting items that match the specified category
        $("." + category).show();
      }
    });
  });
  $('.nav li:first').addClass('active');

  var showSection = function showSection(section, isAnimate) {
    var
    direction = section.replace(/#/, ''),
    reqSection = $('.section').filter('[data-section="' + direction + '"]'),
    reqSectionPos = reqSection.offset().top - 0;

    if (isAnimate) {
      $('body, html').animate({
        scrollTop: reqSectionPos },
      800);
    } else {
      $('body, html').scrollTop(reqSectionPos);
    }

  };

  var checkSection = function checkSection() {
    $('.section').each(function () {
      var
      $this = $(this),
      topEdge = $this.offset().top - 80,
      bottomEdge = topEdge + $this.height(),
      wScroll = $(window).scrollTop();
      if (topEdge < wScroll && bottomEdge > wScroll) {
        var
        currentId = $this.data('section'),
        reqLink = $('a').filter('[href*=\\#' + currentId + ']');
        reqLink.closest('li').addClass('active').
        siblings().removeClass('active');
      }
    });
  };

  $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
    e.preventDefault();
    showSection($(this).attr('href'), true);
  });

  $(window).scroll(function () {
    checkSection();
  });