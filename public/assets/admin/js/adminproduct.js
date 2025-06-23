const products = [
            {
                id: 1,
                name: "iPhone 15 Pro Max",
                sku: "IP15PM001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "29.990.000đ",
                variants: 4,
                stock: 45,
                status: "active",
                variantDetails: [
                    {
                        id: "v1",
                        name: "Điện thoại",
                        price: "29.990.000đ",
                        attributes: "Titan Tự Nhiên, Titan Xanh +2",
                        stock: 45,
                        status: "available"
                    },
                    {
                        id: "v1",
                        name: "Điện thoại",
                        price: "29.990.000đ",
                        attributes: "Titan Tự Nhiên, Titan Xanh +2",
                        stock: 45,
                        status: "available"
                    }
                ]
            },
            {
                id: 2,
                name: "Samsung Galaxy S24 Ultra",
                sku: "SGS24U001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "27.990.000đ",
                variants: 3,
                stock: 32,
                status: "active",
                variantDetails: [
                    {
                        id: "v2",
                        name: "Điện thoại",
                        price: "27.990.000đ",
                        attributes: "Đen, Xám, Tím",
                        stock: 32,
                        status: "available"
                    }
                ]
            },
            {
                id: 3,
                name: "MacBook Pro",
                sku: "MBP001",
                type: "laptop",
                category: "Laptop",
                basePrice: "45.990.000đ",
                variants: 2,
                stock: 18,
                status: "active",
                variantDetails: [
                    {
                        id: "v3",
                        name: "Laptop",
                        price: "45.990.000đ",
                        attributes: "M3 Pro, 16GB RAM",
                        stock: 18,
                        status: "available"
                    }
                ]
            },
            {
                id: 4,
                name: "iPhone 14 Pro",
                sku: "IP14P001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "24.990.000đ",
                variants: 3,
                stock: 28,
                status: "active",
                variantDetails: [
                    {
                        id: "v4",
                        name: "Điện thoại",
                        price: "24.990.000đ",
                        attributes: "Đen, Vàng, Tím",
                        stock: 28,
                        status: "available"
                    }
                ]
            },
            {
                id: 5,
                name: "MacBook Air M2",
                sku: "MBA001",
                type: "laptop",
                category: "Laptop",
                basePrice: "32.990.000đ",
                variants: 2,
                stock: 25,
                status: "active",
                variantDetails: [
                    {
                        id: "v5",
                        name: "Laptop",
                        price: "32.990.000đ",
                        attributes: "M2, 8GB RAM",
                        stock: 25,
                        status: "available"
                    }
                ]
            },
            {
                id: 6,
                name: "Samsung Galaxy S23",
                sku: "SGS23001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "19.990.000đ",
                variants: 4,
                stock: 35,
                status: "active",
                variantDetails: [
                    {
                        id: "v6",
                        name: "Điện thoại",
                        price: "19.990.000đ",
                        attributes: "Đen, Trắng, Xanh, Hồng",
                        stock: 35,
                        status: "available"
                    }
                ]
            },
            {
                id: 7,
                name: "iPad Pro 12.9",
                sku: "IPD001",
                type: "tablet",
                category: "Tablet",
                basePrice: "28.990.000đ",
                variants: 2,
                stock: 22,
                status: "active",
                variantDetails: [
                    {
                        id: "v7",
                        name: "Tablet",
                        price: "28.990.000đ",
                        attributes: "M2, 128GB",
                        stock: 22,
                        status: "available"
                    }
                ]
            },
            {
                id: 8,
                name: "Google Pixel 8 Pro",
                sku: "GP8P001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "21.990.000đ",
                variants: 3,
                stock: 15,
                status: "active",
                variantDetails: [
                    {
                        id: "v8",
                        name: "Điện thoại",
                        price: "21.990.000đ",
                        attributes: "Đen, Trắng, Xanh",
                        stock: 15,
                        status: "available"
                    }
                ]
            },
            {
                id: 9,
                name: "Dell XPS 13",
                sku: "DX13001",
                type: "laptop",
                category: "Laptop",
                basePrice: "35.990.000đ",
                variants: 2,
                stock: 12,
                status: "active",
                variantDetails: [
                    {
                        id: "v9",
                        name: "Laptop",
                        price: "35.990.000đ",
                        attributes: "Intel i7, 16GB RAM",
                        stock: 12,
                        status: "available"
                    }
                ]
            },
            {
                id: 10,
                name: "iPhone 13",
                sku: "IP13001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "18.990.000đ",
                variants: 5,
                stock: 40,
                status: "active",
                variantDetails: [
                    {
                        id: "v10",
                        name: "Điện thoại",
                        price: "18.990.000đ",
                        attributes: "Đen, Trắng, Xanh, Hồng, Đỏ",
                        stock: 40,
                        status: "available"
                    }
                ]
            },
            {
                id: 11,
                name: "Samsung Galaxy Tab S9",
                sku: "SGT001",
                type: "tablet",
                category: "Tablet",
                basePrice: "15.990.000đ",
                variants: 2,
                stock: 20,
                status: "active",
                variantDetails: [
                    {
                        id: "v11",
                        name: "Tablet",
                        price: "15.990.000đ",
                        attributes: "128GB, 256GB",
                        stock: 20,
                        status: "available"
                    }
                ]
            },
            {
                id: 12,
                name: "HP Pavilion 15",
                sku: "HP15001",
                type: "laptop",
                category: "Laptop",
                basePrice: "18.990.000đ",
                variants: 3,
                stock: 30,
                status: "active",
                variantDetails: [
                    {
                        id: "v12",
                        name: "Laptop",
                        price: "18.990.000đ",
                        attributes: "AMD Ryzen 5, 8GB RAM",
                        stock: 30,
                        status: "available"
                    }
                ]
            },
            {
                id: 13,
                name: "OnePlus 11",
                sku: "OP11001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "16.990.000đ",
                variants: 2,
                stock: 18,
                status: "active",
                variantDetails: [
                    {
                        id: "v13",
                        name: "Điện thoại",
                        price: "16.990.000đ",
                        attributes: "Đen, Xanh",
                        stock: 18,
                        status: "available"
                    }
                ]
            },
            {
                id: 14,
                name: "iPad Air",
                sku: "IPA001",
                type: "tablet",
                category: "Tablet",
                basePrice: "16.990.000đ",
                variants: 4,
                stock: 25,
                status: "active",
                variantDetails: [
                    {
                        id: "v14",
                        name: "Tablet",
                        price: "16.990.000đ",
                        attributes: "64GB, 256GB, Xanh, Hồng",
                        stock: 25,
                        status: "available"
                    }
                ]
            },
            {
                id: 15,
                name: "Xiaomi 13 Pro",
                sku: "X13P001",
                type: "phone",
                category: "Điện thoại",
                basePrice: "14.990.000đ",
                variants: 3,
                stock: 33,
                status: "active",
                variantDetails: [
                    {
                        id: "v15",
                        name: "Điện thoại",
                        price: "14.990.000đ",
                        attributes: "Đen, Trắng, Xanh",
                        stock: 33,
                        status: "available"
                    }
                ]
            }
        ];

        let expandedProduct = null;
        let currentPage = 1;
        const itemsPerPage = 5;
        const totalPages = Math.ceil(products.length / itemsPerPage);

        // Function to get product icon
        function getProductIcon(type) {
            const icons = {
                phone: `<div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center text-white text-sm">📱</div>`,
                laptop: `<div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-white text-sm">💻</div>`,
                tablet: `<div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white text-sm">📟</div>`
            };
            return icons[type] || icons.phone;
        }

        // Function to get current page products
        function getCurrentPageProducts() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            return products.slice(startIndex, endIndex);
        }

        // Function to update pagination info
        function updatePaginationInfo() {
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, products.length);
            
            document.getElementById('showingFrom').textContent = startIndex;
            document.getElementById('showingTo').textContent = endIndex;
            document.getElementById('totalItems').textContent = products.length;
        }

        // Function to render page numbers
        function renderPageNumbers() {
            const pageNumbers = document.getElementById('pageNumbers');
            pageNumbers.innerHTML = '';

            // Show first page
            if (currentPage > 3) {
                pageNumbers.innerHTML += `
                    <button onclick="goToPage(1)" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">1</button>
                    <span class="px-2 py-2 text-sm text-gray-500">...</span>
                `;
            }

            // Show pages around current page
            for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
                const isActive = i === currentPage;
                pageNumbers.innerHTML += `
                    <button onclick="goToPage(${i})" class="px-3 py-2 text-sm font-medium ${isActive ? 'text-blue-600 bg-blue-50 border-blue-500' : 'text-gray-500 bg-white border-gray-300'} border rounded-md hover:bg-gray-50">
                        ${i}
                    </button>
                `;
            }

            // Show last page
            if (currentPage < totalPages - 2) {
                pageNumbers.innerHTML += `
                    <span class="px-2 py-2 text-sm text-gray-500">...</span>
                    <button onclick="goToPage(${totalPages})" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">${totalPages}</button>
                `;
            }
        }

        // Function to go to specific page
        function goToPage(page) {
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                expandedProduct = null; // Close any expanded product when changing page
                renderProducts();
                updatePaginationInfo();
                renderPageNumbers();
                updatePaginationButtons();
            }
        }

        // Function to update pagination buttons
        function updatePaginationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            prevBtn.onclick = () => goToPage(currentPage - 1);
            nextBtn.onclick = () => goToPage(currentPage + 1);
        }

        // Function to toggle product expansion
        function toggleProduct(productId) {
            expandedProduct = expandedProduct === productId ? null : productId;
            renderProducts();
        }

        // Function to render products
        function renderProducts() {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';

            const currentProducts = getCurrentPageProducts();

            currentProducts.forEach(product => {
                const isExpanded = expandedProduct === product.id;
                
                const productHTML = `
                    <div class="border-b border-gray-200 last:border-b-0">
                        <!-- Main Product Row -->
                        <div class="grid grid-cols-12 gap-4 p-4 hover:bg-gray-50 cursor-pointer transition-colors" 
                            onclick="toggleProduct(${product.id})">
                            <div class="col-span-1 flex items-center">
                                <input type="checkbox" class="rounded border-gray-300" onclick="event.stopPropagation()">
                            </div>
                            <div class="col-span-4 flex items-center space-x-3">
                                ${getProductIcon(product.type)}
                                <div>
                                    <div class="font-medium text-gray-900">${product.name}</div>
                                    <div class="text-sm text-gray-500">SKU: ${product.sku}</div>
                                </div>
                            </div>
                            <div class="col-span-1 flex items-center">
                                <span class="text-sm text-gray-700">${product.category}</span>
                            </div>
                            <div class="col-span-1 flex items-center">
                                <span class="text-sm font-medium text-gray-900">${product.basePrice}</span>
                            </div>
                            <div class="col-span-1 flex items-center">
                                <span class="text-sm text-gray-700">${product.variants}</span>
                            </div>
                            <div class="col-span-1 flex items-center">
                                <span class="text-sm text-gray-700">${product.stock}</span>
                            </div>
                            <div class="col-span-1 flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Đang bán
                                </span>
                            </div>
                            <div class="col-span-2 flex items-center space-x-2">
                                <button class="p-1 text-gray-400 hover:text-gray-600" onclick="event.stopPropagation()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="p-1 text-gray-400 hover:text-red-600" onclick="event.stopPropagation()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                <button class="p-1 text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4 transform transition-transform ${isExpanded ? 'rotate-180' : ''}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Variant Details (Expandable) -->
                        ${isExpanded ? `
                            <div class="bg-blue-50 border-t border-blue-100">
                                ${product.variantDetails.map(variant => `
                                    <div class="grid grid-cols-12 gap-4 p-4 border-b border-blue-100 last:border-b-0">
                                        <div class="col-span-1 flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300">
                                        </div>
                                        <div class="col-span-4 flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white text-sm">📱</div>
                                            <div>
                                                <div class="font-medium text-gray-900">${variant.name}</div>
                                                <div class="text-sm text-gray-500">${variant.attributes}</div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 flex items-center">
                                            <span class="text-sm text-gray-700">Điện thoại</span>
                                        </div>
                                        <div class="col-span-1 flex items-center">
                                            <span class="text-sm font-medium text-blue-600">${variant.price}</span>
                                        </div>
                                        <div class="col-span-1 flex items-center">
                                            <span class="text-sm text-gray-700">1</span>
                                        </div>
                                        <div class="col-span-1 flex items-center">
                                            <span class="text-sm text-gray-700">${variant.stock}</span>
                                        </div>
                                        <div class="col-span-1 flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Đang bán
                                            </span>
                                        </div>
                                        <div class="col-span-2 flex items-center space-x-2">
                                            <button class="p-1 text-gray-400 hover:text-gray-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button class="p-1 text-gray-400 hover:text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            <button class="p-1 text-gray-400 hover:text-gray-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        ` : ''}
                    </div>
                `;
                
                productList.innerHTML += productHTML;
            });
        }

        // Initial render
        renderProducts();
        updatePaginationInfo();
        renderPageNumbers();
        updatePaginationButtons();