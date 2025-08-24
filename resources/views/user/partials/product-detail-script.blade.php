<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check wishlist status for this product
            const wishlistBtn = document.querySelector('.wishlist-btn');
            if (wishlistBtn && isAuthenticated()) {
                const productVariantId = wishlistBtn.getAttribute('data-product-variant-id');
                
                fetch('/wishlist/check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_variant_id: productVariantId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.is_liked) {
                        wishlistBtn.classList.add('liked');
                        wishlistBtn.style.backgroundColor = '#ef4444';
                        wishlistBtn.style.color = 'white';
                        // Update text if exists
                        const textElement = wishlistBtn.querySelector('.wishlist-text');
                        if (textElement) {
                            textElement.textContent = 'Đã yêu thích';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking wishlist status:', error);
                });
            }
            
            // Handle variant selection with AJAX
            const variantOptions = document.querySelectorAll('.variant-option');
            
            variantOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const variantId = this.getAttribute('data-variant-id');
                    if (!variantId) return;
                    
                    // Show loading state
                    showLoading();
                    
                    // Fetch variant data
                    fetch(`/api/product-variant/${variantId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateProductContent(data.product, data.relatedVariants);
                                updateURL(variantId);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching variant:', error);
                            hideLoading();
                        });
                });
            });
            
            function showLoading() {
                // Add subtle loading indicator to variant options
                const variantOptions = document.querySelectorAll('.variant-option');
                variantOptions.forEach(option => {
                    option.style.opacity = '0.6';
                    option.style.pointerEvents = 'none';
                });
            }
            
            function hideLoading() {
                const variantOptions = document.querySelectorAll('.variant-option');
                variantOptions.forEach(option => {
                    option.style.opacity = '1';
                    option.style.pointerEvents = 'auto';
                });
            }
            
            function updateProductContent(product, relatedVariants) {
                // Update product name
                const productName = document.querySelector('h5.text-2xl');
                if (productName) {
                    productName.textContent = product.product.name;
                }
                
                // Update price
                const priceElement = document.querySelector('.text-red-600.font-semibold');
                if (priceElement) {
                    priceElement.textContent = new Intl.NumberFormat('vi-VN').format(product.price) + ' VNĐ';
                }
                
                // Update product images
                updateProductImages(product.product.thumbnails);
                
                // Update product configuration info
                updateProductConfig(product);
                
                // Update form action
                const form = document.querySelector('form[action*="cart/add"]');
                if (form) {
                    const input = form.querySelector('input[name="product_variant_id"]');
                    if (input) {
                        input.value = product.id;
                    }
                }
                
                // Update buy now form
                const buyNowForm = document.querySelector('form[action*="cart/buy-now"]');
                if (buyNowForm) {
                    const buyNowInput = buyNowForm.querySelector('input[name="product_variant_id"]');
                    if (buyNowInput) {
                        buyNowInput.value = product.id;
                    }
                }
                
                // Update wishlist button
                const wishlistBtn = document.querySelector('.wishlist-btn');
                if (wishlistBtn) {
                    wishlistBtn.setAttribute('data-product-variant-id', product.id);
                    // Reset wishlist button state
                    wishlistBtn.classList.remove('liked');
                    wishlistBtn.style.backgroundColor = '';
                    wishlistBtn.style.color = '';
                    const textElement = wishlistBtn.querySelector('.wishlist-text');
                    if (textElement) {
                        textElement.textContent = 'Yêu thích';
                    }
                    
                    // Check if this variant is in wishlist
                    checkWishlistStatus(product.id, wishlistBtn);
                }
                
                // Update variant options list
                updateVariantOptions(relatedVariants, product.id);
                
                hideLoading();
            }
            
            function updateProductImages(thumbnails) {
                const imgSelect = document.querySelector('.img-select');
                const imgShowcase = document.querySelector('.img-showcase');
                
                if (imgSelect && imgShowcase && thumbnails && thumbnails.length > 0) {
                    // Clear existing images
                    imgSelect.innerHTML = '';
                    imgShowcase.innerHTML = '';
                    
                    // Add new images
                    thumbnails.forEach((thumbnail, index) => {
                        const imgUrl = `/storage/${thumbnail.url}`;
                        
                        // Add to thumbnail list
                        const thumbnailItem = document.createElement('li');
                        thumbnailItem.className = 'p-px';
                        thumbnailItem.innerHTML = `
                            <a href="#" data-id="${index + 1}" class="block">
                                <img src="${imgUrl}" 
                                     class="shadow-sm dark:shadow-gray-800 w-20 h-20 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity" 
                                     alt="Product thumbnail"
                                     onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;">
                            </a>
                        `;
                        imgSelect.appendChild(thumbnailItem);
                        
                        // Add to showcase
                        const showcaseItem = document.createElement('img');
                        showcaseItem.src = imgUrl;
                        showcaseItem.className = 'min-w-full h-96 object-cover flex-shrink-0';
                        showcaseItem.alt = 'Product image';
                        showcaseItem.onerror = function() {
                            this.src = '{{ asset('assets/user/images/shop/mens-jecket.jpg') }}';
                        };
                        imgShowcase.appendChild(showcaseItem);
                    });
                    
                    // Reinitialize image gallery
                    initializeImageGallery();
                }
            }
            
            function updateProductConfig(product) {
                // Update SKU - find by text content
                const skuRow = Array.from(document.querySelectorAll('tr')).find(row => 
                    row.textContent.includes('SKU')
                );
                if (skuRow) {
                    const skuCell = skuRow.querySelector('td:last-child');
                    if (skuCell) {
                        skuCell.textContent = product.sku;
                    }
                }
                
                // Update quantity - find by text content
                const quantityRow = Array.from(document.querySelectorAll('tr')).find(row => 
                    row.textContent.includes('Tồn kho')
                );
                if (quantityRow) {
                    const quantityCell = quantityRow.querySelector('td:last-child');
                    if (quantityCell) {
                        quantityCell.textContent = product.quantity + ' sản phẩm';
                    }
                }
            }
            
            function updateVariantOptions(relatedVariants, currentVariantId) {
                const variantsContainer = document.querySelector('.flex.gap-4.overflow-x-auto');
                
                if (variantsContainer) {
                    variantsContainer.innerHTML = '';
                    
                    relatedVariants.forEach((variant, index) => {
                        const thumbnail = variant.product.thumbnails && variant.product.thumbnails.length > 0 ? variant.product.thumbnails[0] : null;
                        const imageUrl = thumbnail ? `/storage/${thumbnail.url}` : '{{ asset('assets/user/images/shop/mens-jecket.jpg') }}';
                        const variantName = variant.sku || `Biến thể ${index + 1}`;
                        
                        const variantOption = document.createElement('a');
                        variantOption.href = 'javascript:void(0)';
                        variantOption.setAttribute('data-variant-id', variant.id);
                        variantOption.className = 'variant-option border-2 rounded-lg p-3 transition-all duration-300 flex-shrink-0 cursor-pointer border-gray-200 hover:border-orange-500 hover:bg-gray-50';
                        variantOption.innerHTML = `
                            <div class="w-10 h-10 mb-2">
                                <img src="${imageUrl}" 
                                     class="w-full h-full object-cover rounded" 
                                     alt="${variant.product.name}"
                                     loading="lazy"
                                     onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;" />
                            </div>
                            <div class="text-xs font-medium text-center text-gray-800 mb-1">${variantName}</div>
                            <div class="text-xs text-red-600 font-semibold text-center">${new Intl.NumberFormat('vi-VN').format(variant.price)} ₫</div>
                        `;
                        
                        // Add click event
                        variantOption.addEventListener('click', function(e) {
                            e.preventDefault();
                            const variantId = this.getAttribute('data-variant-id');
                            if (variantId) {
                                showLoading();
                                fetch(`/api/product-variant/${variantId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            updateProductContent(data.product, data.relatedVariants);
                                            updateURL(variantId);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error fetching variant:', error);
                                        hideLoading();
                                    });
                            }
                        });
                        
                        variantsContainer.appendChild(variantOption);
                    });
                }
            }
            
            function updateURL(variantId) {
                // Update URL without page reload
                const newUrl = `/products/${variantId}`;
                window.history.pushState({}, '', newUrl);
            }
            
            function checkWishlistStatus(variantId, wishlistBtn) {
                if (isAuthenticated()) {
                    fetch('/wishlist/check', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_variant_id: variantId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.is_liked) {
                            wishlistBtn.classList.add('liked');
                            const textElement = wishlistBtn.querySelector('.wishlist-text');
                            if (textElement) {
                                textElement.textContent = 'Đã yêu thích';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error checking wishlist status:', error);
                    });
                }
            }
            
            function initializeImageGallery() {
                const imgs = document.querySelectorAll('.img-select a');
                const imgBtns = [...imgs];
                let imgId = 1;

                function removeActiveClass() {
                    imgBtns.forEach(btn => {
                        btn.classList.remove('ring-2', 'ring-orange-500');
                    });
                }

                function addActiveClass(clickedBtn) {
                    removeActiveClass();
                    clickedBtn.classList.add('ring-2', 'ring-orange-500');
                }

                imgBtns.forEach((imgItem) => {
                    imgItem.addEventListener('click', (event) => {
                        event.preventDefault();
                        imgId = imgItem.dataset.id;
                        slideImage();
                        addActiveClass(imgItem);
                    });
                });

                function slideImage(){
                    const showcase = document.querySelector('.img-showcase');
                    const firstImg = showcase.querySelector('img:first-child');
                    if (firstImg) {
                        const displayWidth = firstImg.clientWidth;
                        showcase.style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
                    }
                }

                if (imgBtns.length > 0) {
                    addActiveClass(imgBtns[0]);
                }

                window.addEventListener('resize', slideImage);
            }
            
            // Check if user is authenticated
            function isAuthenticated() {
                return document.querySelector('meta[name="auth-status"]')?.getAttribute('content') === 'true';
            }
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imgs = document.querySelectorAll('.img-select a');
            const imgBtns = [...imgs];
            let imgId = 1;

            // Remove active class from all thumbnails
            function removeActiveClass() {
                imgBtns.forEach(btn => {
                    btn.classList.remove('ring-2', 'ring-orange-500');
                });
            }

            // Add active class to clicked thumbnail
            function addActiveClass(clickedBtn) {
                removeActiveClass();
                clickedBtn.classList.add('ring-2', 'ring-orange-500');
            }

            imgBtns.forEach((imgItem) => {
                imgItem.addEventListener('click', (event) => {
                    event.preventDefault();
                    imgId = imgItem.dataset.id;
                    slideImage();
                    addActiveClass(imgItem);
                });
            });

            function slideImage(){
                const showcase = document.querySelector('.img-showcase');
                const firstImg = showcase.querySelector('img:first-child');
                if (firstImg) {
                    const displayWidth = firstImg.clientWidth;
                    showcase.style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
                }
            }

            // Set first thumbnail as active initially
            if (imgBtns.length > 0) {
                addActiveClass(imgBtns[0]);
            }

            window.addEventListener('resize', slideImage);
        });
    </script>