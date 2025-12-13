jQuery(document).ready(function($) {
    
    var currentFolderId = null;
    
    // ===== Render Folder Tree in Media Library =====
    function renderFolderTree(folders, container, level) {
        level = level || 0;
        
        folders.forEach(function(folder) {
            var indent = '&nbsp;&nbsp;&nbsp;&nbsp;'.repeat(level);
            var hasChildren = folder.children && folder.children.length > 0;
            
            var html = '<div class="ogp-folder-item" data-folder-id="' + folder.id + '">' +
                (hasChildren ? '<span class="folder-toggle">▶</span>' : '<span class="folder-toggle-space"></span>') +
                '<span class="folder-icon">' + (level === 0 ? '📁' : '📂') + '</span>' +
                '<span class="folder-name">' + folder.name + '</span>' +
                '<span class="folder-count">' + folder.count + '</span>' +
                '</div>';
            
            if (hasChildren) {
                html += '<div class="ogp-folder-children">';
                container.append(html);
                renderFolderTree(folder.children, container.find('.ogp-folder-children').last(), level + 1);
                container.append('</div>');
            } else {
                container.append(html);
            }
        });
    }
    
    if ($('#ogp-folders-container').length && typeof ogpFolders !== 'undefined') {
        renderFolderTree(ogpFolders.folders, $('#ogp-folders-container'), 0);
    }
    
    // ===== Folder Click in Media Library =====
    $(document).on('click', '.ogp-folder-item', function(e) {
        e.stopPropagation();
        
        var folderId = $(this).data('folder-id');
        $('.ogp-folder-item').removeClass('active');
        $(this).addClass('active');
        
        // Filter media library
        if (wp.media && wp.media.frame) {
            wp.media.frame.content.get().collection.props.set({
                gallery_folder: folderId
            });
        }
        
        // Toggle children
        $(this).next('.ogp-folder-children').slideToggle(200);
        $(this).find('.folder-toggle').toggleClass('open');
    });
    
    // ===== Admin Page - Tree Toggle =====
    $(document).on('click', '.tree-toggle', function(e) {
        e.stopPropagation();
        $(this).toggleClass('open');
        $(this).closest('.ogp-tree-item').find('> .tree-children').toggleClass('open');
    });
    
    // ===== Admin Page - Select Folder =====
    $(document).on('click', '.tree-item-content', function() {
        var folderId = $(this).closest('.ogp-tree-item').data('folder-id');
        var folderName = $(this).find('.tree-name').text();
        
        $('.tree-item-content').removeClass('active');
        $(this).addClass('active');
        
        currentFolderId = folderId;
        $('#current-folder-name').text('📂 ' + folderName);
        $('#folder-actions').show();
        
        loadFolderImages(folderId);
    });
    
    // ===== Load Folder Images =====
    function loadFolderImages(folderId) {
        $('#folder-images').html('<p style="text-align:center;padding:50px;">Loading...</p>');
        
        $.ajax({
            url: ogpFolders.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_get_folder_images',
                nonce: ogpFolders.nonce,
                folder_id: folderId
            },
            success: function(response) {
                if (response.success) {
                    renderImages(response.data);
                }
            }
        });
    }
    
    function renderImages(images) {
        var html = '';
        
        if (images.length === 0) {
            html = '<p class="select-folder-msg">No images in this folder. Click "Upload Images" to add some.</p>';
        } else {
            images.forEach(function(img) {
                html += '<div class="image-item" data-image-id="' + img.id + '">' +
                    '<img src="' + img.thumbnail + '" alt="">' +
                    '<button class="delete-btn" title="Delete">&times;</button>' +
                    '</div>';
            });
        }
        
        $('#folder-images').html(html);
    }
    
    // ===== Add Chapter Button =====
    $('.ogp-add-chapter-btn').on('click', function() {
        $('#add-folder-modal-title').text('Add New Chapter');
        $('#new-folder-parent').val(0);
        $('#ogp-add-folder-modal').addClass('active');
    });
    
    // ===== Add Subfolder/Event =====
    $(document).on('click', '.ogp-add-subfolder', function() {
        if (!currentFolderId) return;
        
        $('#add-folder-modal-title').text('Add Event/Subfolder');
        $('#new-folder-parent').val(currentFolderId);
        $('#ogp-add-folder-modal').addClass('active');
    });
    
    // ===== Create Folder Form =====
    $('#ogp-add-folder-form').on('submit', function(e) {
        e.preventDefault();
        
        var name = $('#new-folder-name').val();
        var parent = $('#new-folder-parent').val();
        
        $.ajax({
            url: ogpFolders.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_create_folder',
                nonce: ogpFolders.nonce,
                name: name,
                parent: parent
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.data);
                }
            }
        });
    });
    
    // ===== Upload Images =====
    $(document).on('click', '.ogp-upload-images', function() {
        if (!currentFolderId) return;
        $('#ogp-upload-modal').addClass('active');
    });
    
    $('#ogp-select-files').on('click', function() {
        $('#ogp-file-input').click();
    });
    
    // Drag & Drop Upload
    var uploadArea = document.getElementById('ogp-upload-area');
    
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            
            var files = e.dataTransfer.files;
            uploadFiles(files);
        });
    }
    
    $('#ogp-file-input').on('change', function() {
        uploadFiles(this.files);
    });
    
    function uploadFiles(files) {
        var progressContainer = $('#ogp-upload-progress');
        progressContainer.empty();
        
        Array.from(files).forEach(function(file, index) {
            var itemHtml = '<div class="upload-item" id="upload-' + index + '">' +
                '<span class="file-name">' + file.name + '</span>' +
                '<div class="progress-bar"><div class="progress-fill"></div></div>' +
                '<span class="status">0%</span>' +
                '</div>';
            progressContainer.append(itemHtml);
            
            var formData = new FormData();
            formData.append('action', 'ogp_upload_to_folder');
            formData.append('nonce', ogpFolders.nonce);
            formData.append('folder_id', currentFolderId);
            formData.append('file', file);
            
            $.ajax({
                url: ogpFolders.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $('#upload-' + index + ' .progress-fill').css('width', percent + '%');
                            $('#upload-' + index + ' .status').text(percent + '%');
                        }
                    });
                    return xhr;
                },
                success: function(response) {
                    $('#upload-' + index + ' .status').text('✓');
                    
                    // Refresh images
                    if (index === files.length - 1) {
                        setTimeout(function() {
                            loadFolderImages(currentFolderId);
                        }, 500);
                    }
                }
            });
        });
    }
    
    // ===== Delete Image =====
    $(document).on('click', '.delete-btn', function(e) {
        e.stopPropagation();
        
        if (!confirm('Delete this image permanently?')) return;
        
        var $item = $(this).closest('.image-item');
        var imageId = $item.data('image-id');
        
        $.ajax({
            url: ogpFolders.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_delete_image',
                nonce: ogpFolders.nonce,
                image_id: imageId
            },
            success: function(response) {
                if (response.success) {
                    $item.fadeOut(function() { $(this).remove(); });
                }
            }
        });
    });
    
    // ===== Rename Folder =====
    $(document).on('click', '.ogp-rename-folder', function() {
        if (!currentFolderId) return;
        
        var newName = prompt('Enter new folder name:');
        if (!newName) return;
        
        $.ajax({
            url: ogpFolders.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_rename_folder',
                nonce: ogpFolders.nonce,
                folder_id: currentFolderId,
                new_name: newName
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
    
    // ===== Delete Folder =====
    $(document).on('click', '.ogp-delete-folder', function() {
        if (!currentFolderId) return;
        
        if (!confirm('Delete this folder? This will also delete all subfolders and images inside!')) return;
        
        $.ajax({
            url: ogpFolders.ajaxurl,
            type: 'POST',
            data: {
                action: 'ogp_delete_folder',
                nonce: ogpFolders.nonce,
                folder_id: currentFolderId,
                delete_images: 'true'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
    
    // ===== Close Modals =====
    $(document).on('click', '.ogp-modal-close, .ogp-modal-cancel', function() {
        $('.ogp-modal').removeClass('active');
    });
    
    $(document).on('click', '.ogp-modal', function(e) {
        if ($(e.target).hasClass('ogp-modal')) {
            $(this).removeClass('active');
        }
    });
});