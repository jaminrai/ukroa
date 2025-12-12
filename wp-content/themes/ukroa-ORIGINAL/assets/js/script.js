// Ensure script runs after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Hamburger menu
    const hamburger = document.querySelector('.hamburger');
    const navUl = document.querySelector('nav ul');
    if (hamburger && navUl) {
        hamburger.addEventListener('click', () => {
            navUl.classList.toggle('show');
            hamburger.setAttribute('aria-expanded', navUl.classList.contains('show'));
        });

// Enhanced mobile menu

const primaryMenu = document.querySelector('#primary-menu');

if (hamburger && primaryMenu) {
    hamburger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isExpanded = hamburger.getAttribute('aria-expanded') === 'true';
        hamburger.setAttribute('aria-expanded', !isExpanded);
        primaryMenu.classList.toggle('show');
        
        // Add overlay for mobile menu
        if (!isExpanded) {
            const overlay = document.createElement('div');
            overlay.className = 'mobile-menu-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            `;
            document.body.appendChild(overlay);
            
            overlay.addEventListener('click', () => {
                hamburger.setAttribute('aria-expanded', 'false');
                primaryMenu.classList.remove('show');
                document.body.removeChild(overlay);
            });
        } else {
            const overlay = document.querySelector('.mobile-menu-overlay');
            if (overlay) document.body.removeChild(overlay);
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && primaryMenu.classList.contains('show')) {
            hamburger.setAttribute('aria-expanded', 'false');
            primaryMenu.classList.remove('show');
            const overlay = document.querySelector('.mobile-menu-overlay');
            if (overlay) document.body.removeChild(overlay);
            hamburger.focus();
        }
    });
}

// Preload animation cleanup
const preload = document.getElementById('preload-animation');
if (preload) {
    if (!sessionStorage.getItem('preloadShown')) {
        setTimeout(() => {
            preload.style.opacity = '0';
            setTimeout(() => {
                preload.style.display = 'none';
                sessionStorage.setItem('preloadShown', 'true');
            }, 500);
        }, 3000);
    } else {
        preload.style.display = 'none';
    }
}
// Sticky navigation with logo
const nav = document.querySelector('nav');
const header = document.querySelector('header');
const stickyLogo = document.querySelector('.logo');
/*const stickyLogo = document.createElement('img');*/

// Create and add sticky logo
/*stickyLogo.src = '<?php echo esc_url(get_template_directory_uri() . "/assets/images/logo.png"); ?>';
stickyLogo.alt = '<?php esc_attr_e("UKROA Logo", "ukroa"); ?>';
stickyLogo.className = 'sticky-logo';
nav.appendChild(stickyLogo);
*/
// Sticky navigation handler
const handleScroll = () => {
    const headerHeight = header.offsetHeight;
    if (window.scrollY > headerHeight - 50) {
        nav.classList.add('sticky');
        

    } else {
        nav.classList.remove('sticky');
        

    }
};

window.addEventListener('scroll', handleScroll);


// Prevent white flash
window.addEventListener('load', () => {
    document.body.style.opacity = '1';
});
document.addEventListener('DOMContentLoaded', () => {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.opacity = '1';
        document.body.style.transition = 'opacity 0.3s ease';
    }, 100);
});

 // Search icon toggle
    const searchIcon = document.querySelector('.search-icon');
    const searchInput = document.querySelector('#search-input');
    if (searchIcon && searchInput) {
        const toggleSearch = () => {
            searchInput.classList.toggle('active');
            if (searchInput.classList.contains('active')) {
                searchInput.focus();
            }
        };
        searchIcon.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent click from closing immediately
            toggleSearch();
        });
        searchIcon.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleSearch();
            }
        });

        // Hide search on click outside
        document.addEventListener('click', (e) => {
            if (!searchIcon.contains(e.target) && !searchInput.contains(e.target)) {
                searchInput.classList.remove('active');
            }
        });

        // Hide search on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && searchInput.classList.contains('active')) {
                searchInput.classList.remove('active');
                searchIcon.focus();
            }
        });
    }
        // Keyboard accessibility for hamburger
        hamburger.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                navUl.classList.toggle('show');
                hamburger.setAttribute('aria-expanded', navUl.classList.contains('show'));
            }
        });
    }


   // Search icon toggle (existing code is fine, no changes)

// Search form submit (update to this)
const searchForm = document.querySelector('#search-form');
if (searchForm) {
    searchForm.addEventListener('submit', (e) => {
        const query = document.querySelector('#search-input').value.trim();
        if (!query) {
            e.preventDefault(); // Prevent submit if empty
            alert('Please enter a search query.');
            return;
        }
        // Let form submit naturally (redirects to ?s=query)
        // If you want to force JS redirect: window.location.href = `${ukroaData.homeUrl}/?s=${encodeURIComponent(query)}`;
    });
}

    // Newsletter subscription (AJAX for better UX)
    const newsletterForm = document.querySelector('#newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[type="email"]').value.trim();
            const nonce = newsletterForm.querySelector('input[name="subscribe_nonce_field"]').value;

            if (!email) {
                alert('Please enter a valid email.');
                return;
            }

            fetch(ukroaData.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=ukroa_subscribe&email=${encodeURIComponent(email)}&subscribe_nonce_field=${nonce}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Subscribed!');
                newsletterForm.reset();
            })
            .catch(() => alert('Subscription failed. Try again.'));
        });
    }

    // Calendar sorting
    const chapterSelect = document.getElementById('chapter-select');
    if (chapterSelect) {
        chapterSelect.addEventListener('change', (e) => {
            const selected = e.target.value;
            document.querySelectorAll('.event').forEach(el => {
                el.style.display = (selected === 'all' || el.dataset.chapter === selected) ? 'block' : 'none';
            });
        });
    }

    // Scroll-to-top
    const scrollArrow = document.getElementById('scroll-to-top');
    if (scrollArrow) {
        scrollArrow.addEventListener('click', () => {
            scrollArrow.classList.add('clicked');
            setTimeout(() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                scrollArrow.classList.remove('clicked');
            }, 200);
        });

        // Keyboard accessibility for scroll-to-top
        scrollArrow.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Debounced scroll handler
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (window.scrollY > 300) {
                    scrollArrow.classList.remove('hide');
                } else {
                    scrollArrow.classList.add('hide');
                }
            }, 100);
        });

        if (window.scrollY <= 300) {
            scrollArrow.classList.add('hide');
        }
    }

    // Preload animation
    const preload = document.getElementById('preload-animation');
    if (preload && !sessionStorage.getItem('preloadShown')) {
        preload.style.display = 'flex';
        setTimeout(() => {
            preload.classList.add('hide');
            sessionStorage.setItem('preloadShown', 'true');
        }, 4000);
    } else if (preload) {
        preload.classList.add('hide');
    }
});

// Localize WordPress data (set in functions.php)
const ukroaData = window.ukroaData || { homeUrl: '/', ajaxUrl: '/wp-admin/admin-ajax.php' };


wp.customize('ukroa_primary_color', function(value) {
    value.bind(function(newval) {
        document.querySelector('header').style.backgroundColor = newval;
    });
});