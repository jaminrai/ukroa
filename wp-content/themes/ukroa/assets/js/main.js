/*membership*/

document.addEventListener('DOMContentLoaded', function () {
  const track = document.getElementById('ukroa-member-track');
  const cards = document.querySelectorAll('.ukroa-member-card');
  const prevBtn = document.querySelector('.ukroa-member-prev');
  const nextBtn = document.querySelector('.ukroa-member-next');

  let currentIndex = 0;
  const totalCards = cards.length;

  function updateSlider() {
    const cardWidth = cards[0].offsetWidth + 30; // card + gap
    let visibleCards = 3;

    if (window.innerWidth <= 640) visibleCards = 1;
    else if (window.innerWidth <= 1024) visibleCards = 2;

    const maxIndex = Math.max(0, totalCards - visibleCards);
    currentIndex = Math.min(currentIndex, maxIndex);
    currentIndex = Math.max(0, currentIndex);

    const offset = -currentIndex * cardWidth;
    track.style.transform = `translateX(${offset}px)`;

    // Hide buttons at ends
    prevBtn.style.opacity = currentIndex === 0 ? '0.3' : '1';
    nextBtn.style.opacity = currentIndex >= maxIndex ? '0.3' : '1';
  }

  nextBtn.addEventListener('click', () => {
    currentIndex++;
    updateSlider();
  });

  prevBtn.addEventListener('click', () => {
    currentIndex--;
    updateSlider();
  });

  window.addEventListener('resize', updateSlider);
  updateSlider(); // Initial call
});
/*Membership ends here */

/* change image of donate */
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.querySelector(".paypal-donations input[type='image']");
    if (!btn) return;

    // Get the original SRC directly from the HTML (auto-detect!)
    const originalSrc = btn.src;

    // Build hover image path by replacing file name only
    const hoverSrc = originalSrc.replace("donate_button.png", "donate_button_hover.png");

    // Hover event
    btn.addEventListener("mouseover", function () {
        btn.src = hoverSrc;
    });

    // Mouseout event
    btn.addEventListener("mouseout", function () {
        btn.src = originalSrc;
    });

});
/*end of change image in donate*/

/*team collapse starts from here*/
document.addEventListener('DOMContentLoaded', () => {
    // Toggle any collapsible when header is clicked
    document.querySelectorAll('.team-chapter-header').forEach(header => {
      header.addEventListener('click', () => {
        const content = header.nextElementSibling;
        header.classList.toggle('active');
        content.classList.toggle('open');
      });
    });

    // === AUTO-OPEN FROM URL HASH (Works from same & external pages) ===
    function openFromHash() {
      const hash = window.location.hash; // e.g. #team-ch-leadership
      if (!hash || !hash.startsWith('#team-ch-')) return;

      const header = document.querySelector(`.team-chapter-header[data-target="${hash}"]`);
      if (!header) return;

      const containerId = hash.replace('#team-ch-', '#team-container-');
      const container = document.querySelector(containerId);

      // Open the section
      header.classList.add('active');
      header.nextElementSibling.classList.add('open');

      // Smooth scroll to it (with small delay to ensure content is rendered)
      setTimeout(() => {
        container?.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
          inline: 'nearest'
        });
      }, 100);
    }

    // Run on load
    openFromHash();

    // Also run when user clicks back/forward buttons (SPA-like behavior)
    window.addEventListener('hashchange', openFromHash);
  });

 /*end of team*/

(function($){
  
    $(document).ready(function() {
    
        // Fullwidth Serach Box
        $(function(){
            var $searchlink = $('#search_toggle_fullwidth');
            var $searchbar_fullwidth  = $('#searchbar_fullwidth');
          
            $('#search_toggle_fullwidth').on('click', function(e){
              e.preventDefault();
                if($(this).attr('id') == 'search_toggle_fullwidth') {
                    if(!$searchbar_fullwidth.is(":visible")) { 
                        // if invisible we switch the icon to appear collapsable
                        $searchlink.removeClass('fa-search').addClass('fa-search-minus');
                    } else {
                        // if visible we switch the icon to appear as a toggle
                        $searchlink.removeClass('fa-search-minus').addClass('fa-search');
                    }
                    $searchbar_fullwidth.slideToggle(300, function(){
                    // callback after search bar animation
                    });
                }
            });
          
          $('#searchform_fullwidth').submit(function(e){
              e.preventDefault(); // stop form submission
          });
        });


        // Fullscreen Serach Box 
        $(function() {      
            $('a[href="#searchbar_fullscreen"]').on("click", function(event) {    
                event.preventDefault();
                $("#searchbar_fullscreen").addClass("open");
                $('#searchbar_fullscreen > form > input[type="search"]').focus();
            });

            $("#searchbar_fullscreen, #searchbar_fullscreen button.close").on("click", function(event) {
                if (
                  event.target == this ||
                  event.target.className == "close" ||
                  event.keyCode == 27
                ) {
                    $(this).removeClass("open");
                }
            });
 
        });

    });
})(jQuery);