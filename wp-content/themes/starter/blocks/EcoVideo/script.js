let gk_eco_video = {

  load() {
    $(document).on('click', '.eco-video', function (e) {
      var videoID = $(this).attr("data-id");
      var newContent = '<div class="eco-video">'
          + '<iframe frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" src="https://www.youtube-nocookie.com/embed/'
          + videoID
          + '?autoplay=0&disablekb=1&fs=0&controls=0&loop=1&showinfo=0&rel=0&mute=0&modestbranding=1&playlist='
          + videoID
          + '">';
      $(this).replaceWith(newContent);
    });
  }
}

export default gk_eco_video;
