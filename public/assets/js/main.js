// ShoeHub - Main JavaScript

$(document).ready(function () {

    // Mobile Menu Toggle
    $('#mobile-menu-toggle').click(function () {
        $('#mobile-menu').slideToggle(300);
    });

    // UI Elements
    const miniCartDrawer = $('#mini-cart-drawer');
    const miniCartOverlay = $('#mini-cart-overlay');
    const wishlistDrawer = $('#wishlist-drawer');
    const wishlistOverlay = $('#wishlist-overlay');

    // Close buttons
    $('#close-mini-cart, #mini-cart-overlay').click(function () {
        miniCartDrawer.addClass('translate-x-full');
        miniCartOverlay.fadeOut(300);
        $('body').css('overflow', '');
    });

    $('#close-wishlist, #wishlist-overlay').click(function () {
        wishlistDrawer.addClass('translate-x-full');
        wishlistOverlay.fadeOut(300);
        $('body').css('overflow', '');
    });

    // Header Toggles
    $('#cart-toggle').click(function (e) {
        e.preventDefault();
        openMiniCart();
    });

    $('#wishlist-toggle').click(function (e) {
        e.preventDefault();
        openWishlistDrawer();
    });

    $('#search-toggle, #mobile-search-toggle').click(function () {
        $('#search-overlay').slideToggle(300);
    });

    // Hero Slider
    let currentSlide = 0;
    const slides = $('.hero-slide');
    const slideCount = slides.length;

    function showSlide(index) {
        slides.removeClass('active');
        slides.eq(index).addClass('active');

        // Update dots
        $('.slider-dot').removeClass('bg-white w-8 border-white');
        $('.slider-dot').eq(index).addClass('bg-white w-8 border-white');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slideCount;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slideCount) % slideCount;
        showSlide(currentSlide);
    }

    if (slideCount > 0) {
        let timer = setInterval(nextSlide, 5000);

        $('.slider-next').click(function () {
            clearInterval(timer);
            nextSlide();
            timer = setInterval(nextSlide, 5000);
        });

        $('.slider-prev').click(function () {
            clearInterval(timer);
            prevSlide();
            timer = setInterval(nextSlide, 5000);
        });

        $('.slider-dot').click(function () {
            clearInterval(timer);
            const index = $(this).data('index');
            currentSlide = index;
            showSlide(currentSlide);
            timer = setInterval(nextSlide, 5000);
        });
    }

    // Product Quick View - handled by global function openQuickView defined at bottom

    // ==========================================
    // SMART SHOP PAGE LOGIC (AJAX + SLIDER)
    // ==========================================

    // 1. Price Slider Initialization
    if ($('#price-slider').length) {
        const slider = document.getElementById('price-slider');
        const minInput = document.getElementById('min-price-input');
        const maxInput = document.getElementById('max-price-input');
        const minDisplay = document.getElementById('price-min-display');
        const maxDisplay = document.getElementById('price-max-display');

        // Check if noUiSlider are loaded
        if (typeof noUiSlider !== 'undefined') {
            const minVal = parseInt(minInput.value) || 0;
            const maxVal = parseInt(maxInput.value) || 50000;

            noUiSlider.create(slider, {
                start: [minVal, maxVal],
                connect: true,
                range: {
                    'min': 0,
                    'max': 50000
                },
                step: 500,
                format: {
                    to: function (value) { return Math.round(value); },
                    from: function (value) { return Number(value); }
                }
            });

            slider.noUiSlider.on('update', function (values, handle) {
                const value = values[handle];
                if (handle === 0) {
                    minDisplay.innerText = value;
                    minInput.value = value;
                } else {
                    maxDisplay.innerText = value;
                    maxInput.value = value;
                }
            });

            slider.noUiSlider.on('change', function () {
                fetchProducts();
            });
        }
    }

    // 2. Filter & Sort Event Listeners
    $('#filter-form').on('change', 'select, input', function () {
        // Debounce text input
        if ($(this).attr('type') === 'text') return;
        fetchProducts();
    });

    // Debounce for search input
    let searchTimeout;
    $('input[name="search"]').on('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(fetchProducts, 500);
    });

    $('#sort-select, #limit-select').on('change', function () {
        fetchProducts();
    });

    // Pagination Click
    $(document).on('click', '.pagination-btn', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchProducts(page);
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });

    // History API (Back button support)
    window.onpopstate = function (event) {
        if (event.state) {
            // Restore state if needed, or just reload/refetch
            window.location.reload();
        }
    };

    // 3. Main Fetch Function
    function fetchProducts(page = 1) {
        // Show Skeleton / Loading State
        const grid = $('.products-grid');
        grid.html(getSkeletonHtml(12));

        // Collect Data
        const formData = $('#filter-form').serializeArray();
        const sort = $('#sort-select').val();
        const limit = $('#limit-select').val();

        const params = {};
        formData.forEach(item => {
            if (item.value) params[item.name] = item.value;
        });
        if (sort) params.sort = sort;
        if (limit) params.limit = limit;
        params.page = page;

        // Build Query String for URL
        const queryString = $.param(params);
        const newUrl = window.location.pathname + '?' + queryString;
        window.history.pushState({ path: newUrl }, '', newUrl);

        // AJAX Request
        $.ajax({
            url: BASE_URL + '/shop',
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    grid.html(response.products_html).css('opacity', '1');
                    $('.pagination-container').html(response.pagination_html);
                    $('.showing-text').html(response.showing_text);

                    // Re-initialize any plugins if needed (e.g. lazy load)
                    // But delegated events work fine
                } else {
                    grid.html('<p class="text-center text-red-500">Error loading products.</p>').css('opacity', '1');
                }
            },
            error: function () {
                grid.html('<p class="text-center text-red-500">Failed to load products.</p>').css('opacity', '1');
            }
        });
    }

    // ... (skip finding lines)

    function openMiniCart() {
        miniCartOverlay.removeClass('hidden').fadeIn(300);
        miniCartDrawer.removeClass('translate-x-full');
        $('body').css('overflow', 'hidden');

        $.ajax({
            url: BASE_URL + '/ajax/get-cart-details',
            success: function (response) {
                if (response && response.success) {
                    renderMiniCart(response);
                }
            }
        });
    }

    function renderMiniCart(data) {
        const container = $('#mini-cart-items');
        const totalContainer = $('#mini-cart-total');
        const countContainer = $('.cart-count');

        container.empty();

        if (data.items.length === 0) {
            container.html('<div class="text-center py-12"><i class="fas fa-shopping-basket text-4xl text-gray-200 mb-4 block"></i><p class="text-gray-400">Your cart is empty</p></div>');
        } else {
            data.items.forEach(item => {
                container.append(`
                    <div class="flex gap-4 group">
                        <div class="w-20 h-20 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                            <img src="${item.image_url}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-secondary text-sm mb-1 line-clamp-1">${item.name}</h4>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">${item.quantity} × ৳${parseFloat(item.price).toLocaleString()}</span>
                                <span class="font-bold text-primary text-sm">৳${parseFloat(item.total).toLocaleString()}</span>
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        totalContainer.text('৳' + parseFloat(data.total).toLocaleString());
        countContainer.text(data.count);
    }

    // ...

    function openWishlistDrawer() {
        $.ajax({
            url: BASE_URL + '/wishlist/details',
            success: function (response) {
                let data = response;
                if (data.success) {
                    renderWishlistDrawer(data);
                    wishlistOverlay.removeClass('hidden').fadeIn(300);
                    wishlistDrawer.removeClass('translate-x-full');
                    $('body').css('overflow', 'hidden');
                }
            }
        });
    }

    function renderWishlistDrawer(data) {
        const container = $('#wishlist-items');
        container.empty();

        if (data.items.length === 0) {
            container.html('<div class="text-center py-12"><i class="far fa-heart text-4xl text-gray-200 mb-4 block"></i><p class="text-gray-400">Your wishlist is empty</p></div>');
        } else {
            data.items.forEach(item => {
                container.append(`
                    <div class="flex gap-4 group">
                        <div class="w-20 h-20 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                            <img src="${item.image_url}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-secondary text-sm mb-1 line-clamp-1">${item.name}</h4>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-primary text-sm">৳${parseFloat(item.price).toLocaleString()}</span>
                                <button class="remove-wishlist-item text-red-400 hover:text-red-600 text-xs" data-product-id="${item.product_id}">Remove</button>
                            </div>
                        </div>
                    </div>
                `);
            });
        }
    }

    // ...

    // Delegated Wishlist Removal (Works for both drawer and full page)
    $(document).on('click', '.remove-wishlist-item', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const itemRow = $(this).closest('.group, .animate-fade-in-up');

        itemRow.css('opacity', '0.5');

        $.ajax({
            url: BASE_URL + '/wishlist/remove',
            type: 'POST',
            data: { product_id: productId },
            success: function (response) {
                if (response.success) {
                    showNotification(response.message, 'success');

                    // If we are on the wishlist page, we might want to reload or remove the element
                    if (window.location.pathname.includes('/wishlist')) {
                        itemRow.fadeOut(300, function () {
                            if ($('.remove-wishlist-item').length === 0) {
                                location.reload(); // Show empty state
                            }
                        });
                    } else {
                        // Refresh drawer if it's open
                        if (!$('#wishlist-drawer').hasClass('translate-x-full')) {
                            openWishlistDrawer();
                        }
                    }

                    // Update counts in header
                    $('.wishlist-count-drawer, #wishlist-toggle span').text(response.count);
                }
            }
        });
    });

    // ...

    function addToCartRequest(productId, size, color, quantity, btn = null, isBuyNow = false) {
        const originalText = btn ? btn.html() : null;
        if (btn) {
            btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            btn.prop('disabled', true);
        }

        $.ajax({
            url: BASE_URL + '/cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                size: size,
                color: color,
                quantity: quantity
            },
            success: function (response) {
                if (btn) {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }

                if (response.success) {
                    if (isBuyNow) {
                        window.location.href = BASE_URL + '/checkout';
                    } else {
                        openMiniCart();
                    }
                } else {
                    showNotification(response.message || 'Error adding to cart', 'error');
                }
            },
            error: function () {
                if (btn) {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }
                showNotification('Server connection error', 'error');
            }
        });
    }

    // ...

    $(document).on('click', '.add-to-wishlist-btn', function (e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent triggering parent click events (like product card link)
        const productId = $(this).data('product-id');
        const btn = $(this);

        // Add visual feedback immediately
        const icon = btn.find('i');
        icon.removeClass('far').addClass('fas text-red-500 scale-125 transition-transform');

        $.ajax({
            url: BASE_URL + '/wishlist/add',
            type: 'POST',
            data: { product_id: productId },
            success: function (response) {
                let data = response;

                if (data.success) {
                    if (data.action === 'removed') {
                        icon.removeClass('fas text-red-500 scale-125').addClass('far');
                    }
                    showNotification(data.message, 'success');
                    if (data.action === 'added') {
                        // Optional: Open drawer
                        // openWishlistDrawer();
                        // Update count if available
                    }
                    // Update all wishlist buttons for this product
                    $(`.add-to-wishlist-btn[data-product-id="${productId}"]`).find('i')
                        .toggleClass('far fas', data.action === 'added')
                        .toggleClass('text-red-500', data.action === 'added');

                    // Update drawer count
                    if (data.count !== undefined) {
                        $('.wishlist-count-drawer').text(data.count);
                    }
                } else {
                    showNotification(data.message || 'Error', 'error');
                    // Revert visual change on error
                    icon.removeClass('fas text-red-500 scale-125').addClass('far');
                }
            },
            error: function (xhr) {
                let msg = 'Connection failed';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                showNotification(msg, 'error');
                icon.removeClass('fas text-red-500 scale-125').addClass('far');
            }
        });
    });

    // ...

    // Update Cart Quantity
    $('.cart-quantity-input').change(function () {
        const input = $(this);
        const cartKey = input.data('cart-key');
        const quantity = input.val();

        if (quantity < 1) {
            input.val(1);
            return;
        }

        // Show loading state
        input.prop('disabled', true);

        $.ajax({
            url: BASE_URL + '/cart/update',
            type: 'POST',
            data: {
                cart_key: cartKey,
                quantity: quantity
            },
            success: function (response) {
                let data = response;

                if (data.success) {
                    // Update cart count and total in header
                    $('.cart-count').text(data.cart_count);
                    $('.cart-total').text('৳' + parseFloat(data.cart_total).toFixed(2));

                    showNotification('Cart updated successfully', 'success');
                    // location.reload(); // Try to update dynamically if possible, but reload is safe
                    window.location.reload();
                } else {
                    showNotification(data.message || 'Error updating cart', 'error');
                    input.prop('disabled', false);
                }
            },
            error: function () {
                showNotification('Error updating cart', 'error');
                input.prop('disabled', false);
            }
        });
    });

    // Remove from Cart
    $('.remove-from-cart').click(function (e) {
        e.preventDefault();
        const btn = $(this);
        const cartKey = btn.data('cart-key');
        const cartItem = btn.closest('.p-6');

        if (!confirm('Remove this item from cart?')) {
            return;
        }

        // Add loading state
        cartItem.css('opacity', '0.5');
        btn.prop('disabled', true);

        $.ajax({
            url: BASE_URL + '/cart/remove',
            type: 'POST',
            data: { cart_key: cartKey },
            success: function (response) {
                let data = response;

                if (data.success) {
                    // Update cart count and total in header
                    $('.cart-count').text(data.cart_count);
                    $('.cart-total').text('৳' + parseFloat(data.cart_total).toFixed(2));

                    showNotification('Item removed from cart', 'success');
                    // Smooth remove animation
                    cartItem.slideUp(300, function () {
                        location.reload(); // Reload to update everything
                    });
                } else {
                    showNotification(data.message || 'Error removing item', 'error');
                    cartItem.css('opacity', '1');
                    btn.prop('disabled', false);
                }
            },
            error: function () {
                showNotification('Error removing item', 'error');
                cartItem.css('opacity', '1');
                btn.prop('disabled', false);
            }
        });
    });

    // Apply Coupon
    $('#apply-coupon-btn').click(function (e) {
        e.preventDefault();
        const couponCode = $('#coupon-code').val();

        if (!couponCode) {
            showNotification('Please enter a coupon code', 'warning');
            return;
        }

        $.ajax({
            url: BASE_URL + '/cart/apply-coupon', // Placeholder, confirm if exists
            type: 'POST',
            data: { coupon_code: couponCode },
            success: function (response) {
                if (response.success) {
                    showNotification(response.message || 'Coupon applied successfully!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(response.message || 'Invalid coupon code', 'error');
                }
            },
            error: function () {
                showNotification('Server error applying coupon', 'error');
            }
        });
    });

    // Product Image Gallery
    $('.product-thumbnail').click(function () {
        const newImage = $(this).data('image');
        $('#main-product-image').attr('src', newImage);
        $('.product-thumbnail').removeClass('border-primary');
        $(this).addClass('border-primary');
    });

    // Price Range Filter
    if ($('#price-range').length) {
        const priceRange = $('#price-range');
        const minPrice = $('#min-price');
        const maxPrice = $('#max-price');

        priceRange.on('input', function () {
            const value = $(this).val();
            maxPrice.text(value);
        });
    }

    // Newsletter Subscription
    $('#newsletter-form').submit(function (e) {
        e.preventDefault();
        const email = $(this).find('input[name="email"]').val();

        $.ajax({
            url: BASE_URL + '/newsletter/subscribe',
            type: 'POST',
            data: { email: email },
            success: function (response) {
                if (response.success) {
                    showNotification('Successfully subscribed!', 'success');
                    $('#newsletter-form')[0].reset();
                } else {
                    showNotification(response.message || 'Subscription failed', 'error');
                }
            },
            error: function (xhr) {
                showNotification(xhr.responseJSON?.message || 'Subscription failed', 'error');
            }
        });
    });

    // Helper Functions
    function updateCartCount() {
        $.ajax({
            url: BASE_URL + '/ajax/get-cart-count',
            success: function (response) {
                $('.cart-count').text(response.count || 0);
            }
        });
    }

    function showNotification(message, type) {
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        const notification = $('<div>')
            .addClass('fixed top-20 right-4 px-6 py-4 rounded-lg text-white shadow-lg z-50 ' + colors[type])
            .text(message)
            .hide()
            .fadeIn(300);

        $('body').append(notification);

        setTimeout(function () {
            notification.fadeOut(300, function () {
                $(this).remove();
            });
        }, 3000);
    }

    function flyToCart(element) {
        const cart = $('.fa-shopping-cart').first();
        if (cart.length === 0) return;

        const imgClone = element.closest('.product-card').find('img').clone()
            .css({
                'position': 'absolute',
                'z-index': '9999',
                'width': '80px',
                'height': '80px',
                'object-fit': 'cover',
                'border-radius': '8px'
            });

        const imgPosition = element.offset();
        const cartPosition = cart.offset();

        imgClone.css({
            'top': imgPosition.top,
            'left': imgPosition.left
        });

        $('body').append(imgClone);

        imgClone.animate({
            top: cartPosition.top,
            left: cartPosition.left,
            width: 0,
            height: 0,
            opacity: 0
        }, 1000, function () {
            $(this).remove();
        });
    }

    // Lazy Load Images
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));

    // Smooth Scroll to Top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            if ($('#back-to-top').length === 0) {
                $('body').append('<button id="back-to-top" class="fixed bottom-8 right-8 bg-primary text-white w-12 h-12 rounded-full shadow-lg hover:bg-blue-700 transition z-50"><i class="fas fa-arrow-up"></i></button>');
            }
        } else {
            $('#back-to-top').remove();
        }
    });

    $(document).on('click', '#back-to-top', function () {
        $('html, body').animate({ scrollTop: 0 }, 600);
    });

    // Video Lightbox Logic
    window.openVideoLightbox = function (videoUrl) {
        const container = $('#video-container');
        const lightbox = $('#video-lightbox');

        // Check if it's a direct video link (.mp4, .webm, etc)
        const isDirectVideo = videoUrl.match(/\.(mp4|webm|ogg)$/i) || videoUrl.includes('raw=1');

        if (isDirectVideo) {
            container.html(`
                <video controls autoplay class="w-full h-full rounded-2xl">
                    <source src="${videoUrl}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            `);
        } else {
            // Handle YouTube
            let embedUrl = videoUrl;
            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                let videoId = '';
                if (videoUrl.includes('v=')) {
                    videoId = videoUrl.split('v=')[1].split('&')[0];
                } else if (videoUrl.includes('youtu.be/')) {
                    videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                }
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            }
            container.html(`<iframe src="${embedUrl}" class="w-full h-full border-none" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`);
        }
    };




    // ==========================================
    // DELEGATED EVENT LISTENERS (Robust for AJAX)
    // ==========================================

    // 1. Quick View Button
    $(document).on('click', '.quick-view-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const btn = $(this);
        let product = btn.data('product');

        // Fallback or if data-product is already an object
        if (typeof product === 'string') {
            try {
                product = JSON.parse(product);
            } catch (err) {
                console.error('Error parsing product data', err);
                return;
            }
        }

        if (product) {
            openQuickView(product);
        }
    });

    // 2. Quick Add Size Button
    $(document).on('click', '.quick-add-size-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const btn = $(this);
        const productId = btn.data('product-id');
        const size = btn.data('size');

        quickAddToCart(productId, size, btn);
    });

    // 3. Add to Cart Button (Bag Icon)
    $(document).on('click', '.add-to-cart-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const btn = $(this);
        const productId = btn.data('product-id');
        const colors = btn.data('colors');
        const sizes = btn.data('sizes');

        // If it has multiple sizes/colors, open quick view instead of direct add
        if ((colors && colors.length > 0) || (sizes && sizes.length > 0)) {
            // Get full product data to open quick view
            const product = {
                id: productId,
                name: btn.data('product-name'),
                price: btn.data('product-price'),
                featured_image: btn.data('product-image'),
                description: btn.data('description') || '',
                slug: btn.data('slug') || ''
            };
            openQuickView(product);
        } else {
            // Direct add if no attributes
            quickAddToCart(productId, null, btn);
        }
    });

    // ==========================================
    // GLOBAL HELPER FUNCTIONS
    // ==========================================

    window.openQuickView = function (product) {
        $('#qv-name').text(product.name);

        // Handle Price display
        const price = parseFloat(product.price);
        if (!isNaN(price)) {
            $('#qv-price').text('৳' + price.toLocaleString());
        } else {
            $('#qv-price').text('৳0');
        }

        $('#qv-description').html(product.description).addClass('line-clamp-4');

        // Robust image path handling matching getProductImage helper
        let imagePath = product.featured_image;
        if (imagePath) {
            if (imagePath.startsWith('http')) {
                // already a full URL
            } else if (imagePath.startsWith('assets/')) {
                imagePath = BASE_URL + '/' + imagePath;
            } else {
                // Remove duplicate storage/ if it exists
                let path = imagePath.replace(/^\//, '');
                if (path.startsWith('storage/')) {
                    path = path.substring(8);
                }

                if (path.startsWith('products/')) {
                    imagePath = BASE_URL + '/assets/uploads/' + path;
                } else {
                    imagePath = BASE_URL + '/storage/' + path;
                }
            }
        } else {
            imagePath = 'https://via.placeholder.com/300x300?text=No+Image';
        }

        $('#qv-img').attr('src', imagePath);
        $('#qv-link').attr('href', BASE_URL + '/product/' + (product.slug || product.id));

        // Update Add to Cart button in modal
        const qvAddToCartBtn = $('#quick-view-modal button[onclick*="quickAddToCart"]');
        if (qvAddToCartBtn.length) {
            qvAddToCartBtn.attr('onclick', `quickAddToCart(${product.id}, null, this)`);
        }

        $('#quick-view-modal').removeClass('hidden').addClass('flex').hide().fadeIn(400);
        $('body').css('overflow', 'hidden');
    };

    window.closeQuickView = function () {
        $('#quick-view-modal').addClass('hidden').removeClass('flex');
    };

    window.closeVideoLightbox = function () {
        $('#video-container').empty();
        $('#video-lightbox').removeClass('flex').addClass('hidden');
        $('body').css('overflow', '');
    };

    // Quick Add To Cart Logic
    window.quickAddToCart = function (productId, size, btn) {
        const $btn = $(btn);
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i>');
        $btn.addClass('bg-primary text-white border-primary');

        $.ajax({
            url: BASE_URL + '/cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                size: size,
                quantity: 1
            },
            success: function (response) {
                if (response.success) {
                    if (typeof openMiniCart === 'function') openMiniCart();
                    showNotification('Added to cart!', 'success');
                } else {
                    showNotification(response.message || 'Error', 'error');
                }
            },
            error: function () {
                showNotification('Connection failed', 'error');
            },
            complete: function () {
                $btn.html(originalText);
                setTimeout(() => {
                    $btn.removeClass('bg-primary text-white border-primary');
                }, 2000);
            }
        });
    };


}); // End Document Ready

function toggleShopSidebar() {
    const sidebar = $('#shop-sidebar');
    if (sidebar.hasClass('-translate-x-full')) {
        sidebar.removeClass('-translate-x-full');
        $('body').css('overflow', 'hidden');
    } else {
        sidebar.addClass('-translate-x-full');
        $('body').css('overflow', '');
    }
}
