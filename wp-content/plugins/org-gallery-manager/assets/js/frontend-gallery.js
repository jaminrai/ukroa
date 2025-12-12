jQuery(document).ready(function($) {
    
    // ===== Variables =====
    var currentImages = [];
    var currentIndex = 0;
    var slideshowInterval = null;
    var isPlaying = false;
    var slideshowSpeed = 3000;
    var currentEffect = 'fade';
    var breadcrumbStack = [{id: 'all', name: '🏠 All Galleries'}];
    
    // Get effect from container
    if ($('.ogp-gallery-container').data('effect')) {
        currentEffect = $('.ogp-gallery-container').data('effect');
    }
    
    // ===== Folder Navigation =====
    $(document).on('click', '.ogp-folder-card, .open-folder-btn', function(e) {
        e.stopPropagation();
        
        var $card = $(this).hasClass('ogp-folder-card') ? $(this) : $(this).closest('.ogp-folder-card');
        var folderId = $card.data('folder-id');
        var folderName = $card.data('folder-name');
        
        openFolder(folderId, folderName);
    });
    
    function openFolder(folderId, folderName) {
        $('#ogp-gallery-content').html('<div class="loading-spinner" style="text-align:center;padding:50px;"><div class="loader-spinner" style="margin:0 auto;"></div><p>Loading...</p></div>');
        
        $.ajax({
            url: ogpGallery.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_get_folder_content',
                folder_id: folderId
            },
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    
                    // Update breadcrumb
                    breadcrumbStack.push({id: folderId, name: folderName});
                    updateBreadcrumb();
                    
                    // Build content HTML
                    var html = '';
                    
                    if (data.has_subfolders) {
                        html += '<div class="ogp-folders-grid">' + data.subfolders_html + '</div>';
                    }
                    
                    if (data.has_images) {
                        html += '<div class="ogp-images-grid">' + data.images_html + '</div>';
                    }
                    
                    if (!data.has_subfolders && !data.has_images) {
                        html = '<div class="ogp-no-results"><p>This folder is empty.</p></div>';
                    }
                    
                    // Store images for lightbox
                    currentImages = data.images || [];
                    
                    $('#ogp-gallery-content').html(html);
                }
            }
        });
    }
    
    function updateBreadcrumb() {
        var html = '';
        
        breadcrumbStack.forEach(function(item, index) {
            var isActive = index === breadcrumbStack.length - 1;
            html += '<span class="breadcrumb-item' + (isActive ? ' active' : '') + '" data-folder="' + item.id + '">' + item.name + '</span>';
            
            if (!isActive) {
                html += '<span class="breadcrumb-separator">›</span>';
            }
        });
        
        $('#ogp-breadcrumb').html(html);
    }
    
    // ===== Breadcrumb Click =====
    $(document).on('click', '.breadcrumb-item:not(.active)', function() {
        var folderId = $(this).data('folder');
        var index = $('.breadcrumb-item').index(this);
        
        // Remove items after this one
        breadcrumbStack = breadcrumbStack.slice(0, index + 1);
        
        if (folderId === 'all') {
            location.reload();
        } else {
            var folderName = breadcrumbStack[breadcrumbStack.length - 1].name;
            breadcrumbStack.pop(); // Remove current to re-add in openFolder
            openFolder(folderId, folderName);
        }
    });
    
    // ===== Search Functionality =====
    var searchTimeout;
    
    $('#ogp-search-input').on('input', function() {
        var query = $(this).val();
        
        if (query.length > 0) {
            $('#ogp-clear-search').show();
        } else {
            $('#ogp-clear-search').hide();
        }
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) return;
        
        searchTimeout = setTimeout(function() {
            performSearch(query);
        }, 300);
    });
    
    $('#ogp-clear-search').on('click', function() {
        $('#ogp-search-input').val('');
        $(this).hide();
        location.reload();
    });
    
    function performSearch(query) {
        $.ajax({
            url: ogpGallery.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_search_gallery',
                search: query
            },
            success: function(response) {
                if (response.success) {
                    displaySearchResults(response.data);
                }
            }
        });
    }
    
    function displaySearchResults(results) {
        var html = '<div class="search-results">';
        
        if (results.folders.length > 0) {
            html += '<h3 style="color:#667eea;margin:20px 0;">📁 Matching Folders</h3>';
            html += '<div class="ogp-folders-grid">';
            
            results.folders.forEach(function(folder) {
                html += '<div class="ogp-folder-card event" data-folder-id="' + folder.id + '" data-folder-name="' + folder.name + '">';
                html += '<div class="folder-card-image">';
                html += folder.cover ? '<img src="' + folder.cover + '" alt="">' : '<div class="folder-placeholder">📂</div>';
                html += '<div class="folder-overlay"><button class="open-folder-btn">Open</button></div>';
                html += '</div>';
                html += '<div class="folder-card-info"><h3 class="folder-title">' + folder.name + '</h3>';
                html += '<div class="folder-meta"><span class="meta-item">🖼️ ' + folder.count + ' images</span></div></div></div>';
            });
            
            html += '</div>';
        }
        
        if (results.images.length > 0) {
            html += '<h3 style="color:#667eea;margin:20px 0;">🖼️ Matching Images</h3>';
            html += '<div class="ogp-images-grid">';
            
            currentImages = results.images;
            
            results.images.forEach(function(image) {
                html += '<div class="ogp-image-card" data-image-id="' + image.id + '" data-full="' + image.full + '" data-title="' + image.title + '">';
                html += '<img src="' + image.thumbnail + '" alt="' + image.title + '">';
                html += '<div class="image-overlay"><span class="view-icon">🔍</span></div></div>';
            });
            
            html += '</div>';
        }
        
        if (results.folders.length === 0 && results.images.length === 0) {
            html += '<div class="ogp-no-results"><h3>No results found</h3><p>Try different keywords</p></div>';
        }
        
        html += '</div>';
        
        $('#ogp-gallery-content').html(html);
    }
    
    // ===== Lightbox =====
    $(document).on('click', '.ogp-image-card', function() {
        var $card = $(this);
        var imageIndex = $('.ogp-image-card').index($card);
        
        // Get all images from current view
        currentImages = [];
        $('.ogp-image-card').each(function() {
            currentImages.push({
                id: $(this).data('image-id'),
                full: $(this).data('full'),
                title: $(this).data('title'),
                thumbnail: $(this).find('img').attr('src')
            });
        });
        
        currentIndex = imageIndex;
        openLightbox();
    });
    
    function openLightbox() {
        var $lightbox = $('#ogp-lightbox');
        $lightbox.addClass('active');
        $('body').css('overflow', 'hidden');
        
        loadImage(currentIndex);
        buildThumbnails();
        updateCounter();
    }
    
    function closeLightbox() {
        $('#ogp-lightbox').removeClass('active');
        $('body').css('overflow', '');
        stopSlideshow();
    }
    
    function loadImage(index, direction) {
        var image = currentImages[index];
        var $img = $('#lightbox-image');
        var $loader = $('.lightbox-loader');
        
        $loader.addClass('active');
        
        // Preload image
        var preloader = new Image();
        preloader.onload = function() {
            $loader.removeClass('active');
            
            // Apply effect
            $img.removeClass('fade-in fade-out slide-left slide-right zoom-in flip-in');
            
            switch(currentEffect) {
                case 'slide':
                    $img.addClass(direction === 'next' ? 'slide-right' : 'slide-left');
                    break;
                case 'zoom':
                    $img.addClass('zoom-in');
                    break;
                case 'flip':
                    $img.addClass('flip-in');
                    break;
                default:
                    $img.addClass('fade-in');
            }
            
            $img.attr('src', image.full);
            $('#lightbox-caption').text(image.title || '');
        };
        preloader.src = image.full;
        
        updateThumbnailActive();
        updateCounter();
    }
    
    function buildThumbnails() {
        var html = '';
        
        currentImages.forEach(function(image, index) {
            html += '<div class="thumb-item' + (index === currentIndex ? ' active' : '') + '" data-index="' + index + '">';
            html += '<img src="' + image.thumbnail + '" alt="">';
            html += '</div>';
        });
        
        $('#lightbox-thumbnails').html(html);
    }
    
    function updateThumbnailActive() {
        $('.thumb-item').removeClass('active');
        $('.thumb-item[data-index="' + currentIndex + '"]').addClass('active');
        
        // Scroll thumbnail into view
        var $thumb = $('.thumb-item.active');
        if ($thumb.length) {
            $thumb[0].scrollIntoView({ behavior: 'smooth', inline: 'center' });
        }
    }
    
    function updateCounter() {
        $('#image-counter').text((currentIndex + 1) + ' / ' + currentImages.length);
    }
    
    function navigateLightbox(direction) {
        if (direction === 'next') {
            currentIndex = (currentIndex + 1) % currentImages.length;
        } else {
            currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
        }
        
        loadImage(currentIndex, direction);
    }
    
    // ===== Slideshow =====
    function startSlideshow() {
        isPlaying = true;
        $('#btn-play').addClass('playing').html('⏸');
        
        slideshowInterval = setInterval(function() {
            navigateLightbox('next');
        }, slideshowSpeed);
    }
    
    function stopSlideshow() {
        isPlaying = false;
        $('#btn-play').removeClass('playing').html('▶');
        
        if (slideshowInterval) {
            clearInterval(slideshowInterval);
            slideshowInterval = null;
        }
    }
    
    function toggleSlideshow() {
        if (isPlaying) {
            stopSlideshow();
        } else {
            startSlideshow();
        }
    }
    
    // ===== Lightbox Controls =====
    $('#lightbox-close, .lightbox-backdrop').on('click', closeLightbox);
    
    $('#lightbox-prev, #btn-prev').on('click', function(e) {
        e.stopPropagation();
        navigateLightbox('prev');
    });
    
    $('#lightbox-next, #btn-next').on('click', function(e) {
        e.stopPropagation();
        navigateLightbox('next');
    });
    
    $('#btn-first').on('click', function(e) {
        e.stopPropagation();
        currentIndex = 0;
        loadImage(currentIndex);
    });
    
    $('#btn-last').on('click', function(e) {
        e.stopPropagation();
        currentIndex = currentImages.length - 1;
        loadImage(currentIndex);
    });
    
    $('#btn-play').on('click', function(e) {
        e.stopPropagation();
        toggleSlideshow();
    });
    
    $('#slideshow-speed').on('change', function() {
        slideshowSpeed = parseInt($(this).val());
        if (isPlaying) {
            stopSlideshow();
            startSlideshow();
        }
    });
    
    // Thumbnail click
    $(document).on('click', '.thumb-item', function(e) {
        e.stopPropagation();
        currentIndex = $(this).data('index');
        loadImage(currentIndex);
    });
    
    // Fullscreen
    $('#btn-fullscreen').on('click', function(e) {
        e.stopPropagation();
        var elem = document.getElementById('ogp-lightbox');
        
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            elem.requestFullscreen();
        }
    });
    
    // Download
    $('#btn-download').on('click', function(e) {
        e.stopPropagation();
        var image = currentImages[currentIndex];
        
        var link = document.createElement('a');
        link.href = image.full;
        link.download = image.title || 'image';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
    
    // Zoom
    var isZoomed = false;
    
    $('#btn-zoom').on('click', function(e) {
        e.stopPropagation();
        isZoomed = !isZoomed;
        
        if (isZoomed) {
            $('#lightbox-image').css({
                'max-width': 'none',
                'max-height': 'none',
                'cursor': 'zoom-out'
            });
        } else {
            $('#lightbox-image').css({
                'max-width': '100%',
                'max-height': '70vh',
                'cursor': 'zoom-in'
            });
        }
    });
    
    // ===== Keyboard Navigation =====
    $(document).on('keydown', function(e) {
        if (!$('#ogp-lightbox').hasClass('active')) return;
        
        switch(e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                navigateLightbox('prev');
                break;
            case 'ArrowRight':
                navigateLightbox('next');
                break;
            case ' ':
                e.preventDefault();
                toggleSlideshow();
                break;
            case 'Home':
                currentIndex = 0;
                loadImage(currentIndex);
                break;
            case 'End':
                currentIndex = currentImages.length - 1;
                loadImage(currentIndex);
                break;
        }
    });
    
    // ===== Touch/Swipe Support =====
    var touchStartX = 0;
    var touchEndX = 0;
    
    $('#ogp-lightbox').on('touchstart', function(e) {
        touchStartX = e.originalEvent.touches[0].clientX;
    });
    
    $('#ogp-lightbox').on('touchmove', function(e) {
        touchEndX = e.originalEvent.touches[0].clientX;
    });
    
    $('#ogp-lightbox').on('touchend', function() {
        var diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                navigateLightbox('next');
            } else {
                navigateLightbox('prev');
            }
        }
    });
    
    // ===== View Toggle =====
    $('.view-btn').on('click', function() {
        var view = $(this).data('view');
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        
        if (view === 'list') {
            $('.ogp-folders-grid, .ogp-images-grid').addClass('list-view');
        } else {
            $('.ogp-folders-grid, .ogp-images-grid').removeClass('list-view');
        }
    });
});