@extends('admin.layouts.app')
@section('title')
Trang Thuộc Tính
@endsection
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            {{-- Khu vực thông báo --}}
            <div id="notification-area" class="fixed top-0 inset-x-0 flex items-start justify-center z-50 hidden pt-2">
                <div class="max-w-md w-full mx-4 px-4 py-3 rounded-lg shadow-lg relative transition-all transform duration-300 opacity-0 bg-white border border-gray-100" role="alert">
                    <div class="flex items-center">
                        <span class="message font-medium flex-grow"></span>
                        <button type="button" class="ml-4 alert-close focus:outline-none hover:opacity-75">
                            <svg class="fill-current h-4 w-4" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Đóng</title>
                                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                {{-- Tiêu đề + Nút thêm mới --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h3 class="dark:text-white text-lg font-semibold">Danh sách thuộc tính</h3>
                    <a href="{{ route('admin.attributes.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                        + Thêm mới
                    </a>
                </div>

                {{-- Thanh tìm kiếm --}}
                <div class="px-6 mt-4">
                    <form method="GET" action="{{ route('admin.attributes.index') }}" class="flex justify-end items-center gap-2">
                        <input
                            type="search"
                            name="keyword"
                            class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Tìm theo ID hoặc tên..."
                            value="{{ request('keyword') }}"
                        >
                        <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Tìm
                        </button>
                    </form>
                </div>

                {{-- Bảng thuộc tính --}}
                <div class="flex-auto px-0 pt-4 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">#</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tên</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Mô tả</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attributes as $attribute)
                                    <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition" data-attribute-id="{{ $attribute->id }}">
                                        <td class="px-6 py-3 text-sm">{{ $loop->index + 1 }}</td>
                                        <td class="px-6 py-3 text-sm">
                                            <!-- Display mode -->
                                            <div class="name-display">
                                                <a href="#" class="attribute-name text-blue-600 hover:underline" data-attribute-id="{{ $attribute->id }}">{{ $attribute->name }}</a>
                                            </div>
                                            <!-- Edit mode -->
                                            <div class="name-edit hidden">
                                                <input type="text" class="name-input border border-gray-300 rounded px-2 py-1 text-sm w-full" value="{{ $attribute->name }}">
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            <!-- Display mode -->
                                            <div class="description-display">
                                                <span class="description-text">{{ $attribute->description }}</span>
                                            </div>
                                            <!-- Edit mode -->
                                            <div class="description-edit hidden">
                                                <input type="text" class="description-input border border-gray-300 rounded px-2 py-1 text-sm w-full" value="{{ $attribute->description }}">
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            <!-- Display mode buttons -->
                                            <div class="action-display flex gap-2">
                                                <button class="edit-attribute-btn border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-1 rounded text-xs font-medium transition-colors" data-attribute-id="{{ $attribute->id }}">Sửa</button>
                                                <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="border border-gray-500 text-gray-600 hover:bg-gray-50 px-3 py-1 rounded text-xs font-medium transition-colors inline-block">Chi tiết</a>
                                            </div>
                                            <!-- Edit mode buttons -->
                                            <div class="action-edit hidden flex gap-2">
                                                <button class="save-attribute-btn border border-green-500 text-green-600 hover:bg-green-50 px-3 py-1 rounded text-xs font-medium transition-colors">Lưu</button>
                                                <button class="cancel-attribute-btn border border-red-500 text-red-600 hover:bg-red-50 px-3 py-1 rounded text-xs font-medium transition-colors">Hủy</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">Không có thuộc tính nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popover for Attribute Values -->
<div id="attributeValuesPopover" class="hidden fixed bg-white rounded-lg shadow-xl border border-gray-200 p-4" style="min-width:300px; max-width:400px; z-index:1000;">
    <div class="flex justify-between items-center border-b pb-2 mb-3">
        <h4 class="text-base font-semibold text-gray-800">Giá trị thuộc tính</h4>
        <div class="flex items-center gap-2">
            <button id="addAttributeValueBtn" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-medium">+ Thêm</button>
            <button id="closeAttributePopover" class="text-gray-400 hover:text-gray-600 text-xl leading-none focus:outline-none">&times;</button>
        </div>
    </div>
    <div id="attributeValuesContent"></div>
    <!-- Add new value form (hidden by default) -->
    <div id="addValueForm" class="hidden mt-3 pt-3 border-t">
        <div class="flex gap-2">
            <input type="text" id="newValueInput" class="border border-gray-300 rounded px-2 py-1 text-sm flex-1" placeholder="Nhập giá trị mới...">
            <button id="saveNewValueBtn" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-medium">Lưu</button>
            <button id="cancelNewValueBtn" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium">Hủy</button>
        </div>
    </div>
</div>

<script>
function showNotification(message, type = 'success') {
    const notificationArea = document.getElementById('notification-area');
    const alertDiv = notificationArea.querySelector('div[role="alert"]');
    const messageSpan = notificationArea.querySelector('.message');

    // Thiết lập màu sắc dựa trên loại thông báo
    if (type === 'success') {
        alertDiv.className = alertDiv.className.replace(/bg-\w+-\d+/g, '') + ' bg-green-100 text-green-800';
    } else {
        alertDiv.className = alertDiv.className.replace(/bg-\w+-\d+/g, '') + ' bg-red-100 text-red-800';
    }

    messageSpan.textContent = message;
    notificationArea.classList.remove('hidden');
    
    // Thêm animation hiện
    setTimeout(() => {
        alertDiv.classList.remove('opacity-0');
        alertDiv.classList.add('opacity-100', 'translate-y-0');
    }, 10);

    // Tự động ẩn sau 3 giây
    const hideTimeout = setTimeout(() => {
        alertDiv.classList.add('opacity-0');
        alertDiv.classList.remove('opacity-100');
        setTimeout(() => {
            notificationArea.classList.add('hidden');
        }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
    const popover = document.getElementById('attributeValuesPopover');
    const content = document.getElementById('attributeValuesContent');
    const closeBtn = document.getElementById('closeAttributePopover');
    
    // Thêm sự kiện đóng cho nút đóng thông báo
    document.querySelectorAll('.alert-close').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('#notification-area').classList.add('hidden');
        });
    });

    // Đảm bảo popover luôn là con của body để định vị tuyệt đối chính xác
    if (popover.parentNode !== document.body) {
        document.body.appendChild(popover);
    }

    let lastTarget = null;

    document.querySelectorAll('.attribute-name').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            const attributeId = this.getAttribute('data-attribute-id');
            currentAttributeId = attributeId; // Set current attribute ID for add functionality
            lastTarget = this;
            content.innerHTML = '<div class="text-gray-400">Đang tải...</div>';
            popover.classList.remove('hidden');

            // Popover xuất hiện ngang với tên thuộc tính
            const rect = this.getBoundingClientRect();
            // Điều chỉnh vị trí popover
            const viewportHeight = window.innerHeight;
            const popoverHeight = popover.offsetHeight;
            let topPosition = rect.top + window.scrollY;

            // Kiểm tra xem popover có vượt quá viewport không
            if (rect.top + popoverHeight > viewportHeight) {
                topPosition = rect.top - popoverHeight + window.scrollY;
            }

            popover.style.top = `${topPosition}px`;
            popover.style.left = `${rect.right + 10}px`;

            fetch(`/admin/attributes/${attributeId}/values`)
                .then(response => response.json())
                .then(data => {
                    if (data.values && data.values.length > 0) {
                        content.innerHTML = data.values.map(v => `
                            <div class='flex items-center justify-between mb-2' data-value-id='${v.id}' data-attribute-id='${v.attribute_id}'>
                                <span class='block bg-gray-100 rounded px-2 py-1 value-text'>${v.value}</span>
                                <input type='text' class='hidden value-input border rounded px-2 py-1 text-sm' value='${v.value}' style='min-width:80px;'>
                                <button class='ml-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded shadow-sm transition duration-150 ease-in-out edit-btn'>Sửa</button>
                                <button class='ml-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded shadow-sm transition duration-150 ease-in-out save-btn hidden' style='min-width: 60px;'>Lưu</button>
                            </div>
                        `).join('');

                        // Bắt sự kiện sửa
                        document.querySelectorAll('#attributeValuesContent .edit-btn').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                const row = this.closest('div[data-value-id]');
                                row.querySelector('.value-text').classList.add('hidden');
                                const input = row.querySelector('.value-input');
                                input.classList.remove('hidden');
                                this.classList.add('hidden');
                                row.querySelector('.save-btn').classList.remove('hidden');
                                input.focus();
                            });
                        });

                        // Bắt sự kiện lưu
                        document.querySelectorAll('#attributeValuesContent .save-btn').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                const row = this.closest('div[data-value-id]');
                                const valueId = row.getAttribute('data-value-id');
                                const input = row.querySelector('.value-input');
                                const newValue = input.value.trim();
                                if (!newValue) { input.focus(); return; }

                                btn.disabled = true;
                                btn.innerText = 'Đang lưu...';

                                // Đổi màu nút khi đang lưu
                                btn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                                btn.classList.add('bg-blue-400', 'cursor-not-allowed');

                                fetch(`/admin/attribute_values/${valueId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        _method: 'PUT',
                                        value: newValue
                                    })
                                })
                                .then(async r => {
                                    let data;
                                    try { data = await r.json(); } catch (e) { data = {}; }

                                    if (r.ok && data.success) {
                                        // Cập nhật UI khi thành công
                                        row.querySelector('.value-text').textContent = newValue;
                                        row.querySelector('.value-text').classList.remove('hidden');
                                        input.classList.add('hidden');
                                        btn.classList.add('hidden');
                                        row.querySelector('.edit-btn').classList.remove('hidden');

                                        // Hiển thị thông báo thành công ở đầu trang
                                        showNotification('Cập nhật thành công!', 'success');
                                    } else {
                                        // Khôi phục nút về trạng thái bình thường và hiện thông báo lỗi ở đầu trang
                                        btn.classList.remove('bg-blue-400', 'cursor-not-allowed');
                                        btn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                                        showNotification(data?.message ?? 'Có lỗi xảy ra khi cập nhật. Vui lòng thử lại.', 'error');
                                    }
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                    const errorMsg = document.createElement('div');
                                    errorMsg.className = 'text-red-500 text-sm mt-1 error-message';
                                    errorMsg.textContent = 'Có lỗi xảy ra khi lưu. Vui lòng thử lại.';
                                    
                                    // Xóa thông báo lỗi cũ nếu có
                                    const oldError = row.querySelector('.error-message');
                                    if (oldError) oldError.remove();
                                    
                                    // Thêm thông báo lỗi mới
                                    row.appendChild(errorMsg);
                                    
                                    // Khôi phục nút về trạng thái bình thường
                                    btn.classList.remove('bg-gray-400');
                                    btn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                                    
                                    // Tự động ẩn thông báo sau 3 giây
                                    setTimeout(() => errorMsg.remove(), 3000);
                                })
                                .finally(() => {
                                    btn.disabled = false;
                                    btn.innerText = 'Lưu';
                                });
                            });

                            // Thêm sự kiện nhấn Enter để lưu
                            const input = btn.closest('div[data-value-id]').querySelector('.value-input');
                            input.addEventListener('keydown', function(e) {
                                if (e.key === 'Enter') {
                                    btn.click();
                                }
                            });
                        });
                    } else {
                        content.innerHTML = '<span class="text-gray-400">(Không có giá trị)</span>';
                    }
                })
                .catch(() => {
                    content.innerHTML = '<span class="text-red-500">Lỗi khi tải giá trị!</span>';
                });
        });
    });

    // Đóng popup khi click ra ngoài
    closeBtn.addEventListener('click', function () {
        popover.classList.add('hidden');
        // Reset add form when closing
        document.getElementById('addValueForm').classList.add('hidden');
        document.getElementById('newValueInput').value = '';
    });

    document.addEventListener('mousedown', function (e) {
        if (!popover.contains(e.target) && (!lastTarget || e.target !== lastTarget)) {
            popover.classList.add('hidden');
            // Reset add form when closing
            document.getElementById('addValueForm').classList.add('hidden');
            document.getElementById('newValueInput').value = '';
        }
    });

    // Add new attribute value functionality
    let currentAttributeId = null;
    
    document.getElementById('addAttributeValueBtn').addEventListener('click', function() {
        const addForm = document.getElementById('addValueForm');
        const newValueInput = document.getElementById('newValueInput');
        
        addForm.classList.remove('hidden');
        newValueInput.focus();
    });
    
    document.getElementById('cancelNewValueBtn').addEventListener('click', function() {
        const addForm = document.getElementById('addValueForm');
        const newValueInput = document.getElementById('newValueInput');
        
        addForm.classList.add('hidden');
        newValueInput.value = '';
    });
    
    document.getElementById('saveNewValueBtn').addEventListener('click', function() {
        const newValueInput = document.getElementById('newValueInput');
        const newValue = newValueInput.value.trim();
        
        if (!newValue) {
            showNotification('Vui lòng nhập giá trị!', 'error');
            newValueInput.focus();
            return;
        }
        
        if (!currentAttributeId) {
            showNotification('Không tìm thấy thuộc tính!', 'error');
            return;
        }
        
        // Disable button and show loading state
        const saveBtn = this;
        saveBtn.disabled = true;
        saveBtn.innerHTML = 'Đang lưu...';
        saveBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
        saveBtn.classList.remove('border-green-500', 'text-green-600', 'hover:bg-green-50');
        
        // Send AJAX request to create new attribute value
        fetch(`/admin/attributes/${currentAttributeId}/values`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                value: newValue
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Hide add form and clear input
                document.getElementById('addValueForm').classList.add('hidden');
                newValueInput.value = '';
                
                // Refresh the attribute values list
                const attributeNameElement = document.querySelector(`[data-attribute-id="${currentAttributeId}"]`);
                if (attributeNameElement) {
                    attributeNameElement.click(); // Trigger reload of values
                }
                
                showNotification('Thêm giá trị thành công!', 'success');
            } else {
                showNotification(data.message || 'Có lỗi xảy ra khi thêm giá trị!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi thêm giá trị!', 'error');
        })
        .finally(() => {
            // Restore button state
            saveBtn.disabled = false;
            saveBtn.innerHTML = 'Lưu';
            saveBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            saveBtn.classList.add('border-green-500', 'text-green-600', 'hover:bg-green-50');
        });
    });
    
    // Handle Enter key to save new value
    document.getElementById('newValueInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('saveNewValueBtn').click();
        } else if (e.key === 'Escape') {
            e.preventDefault();
            document.getElementById('cancelNewValueBtn').click();
        }
    });

    // Inline editing functionality for attributes
    document.querySelectorAll('.edit-attribute-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const attributeId = this.getAttribute('data-attribute-id');
            
            // Switch to edit mode
            row.querySelector('.name-display').classList.add('hidden');
            row.querySelector('.name-edit').classList.remove('hidden');
            row.querySelector('.description-display').classList.add('hidden');
            row.querySelector('.description-edit').classList.remove('hidden');
            row.querySelector('.action-display').classList.add('hidden');
            row.querySelector('.action-edit').classList.remove('hidden');
            
            // Focus on name input
            row.querySelector('.name-input').focus();
        });
    });

    // Save attribute changes
    document.querySelectorAll('.save-attribute-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const attributeId = row.getAttribute('data-attribute-id');
            const nameInput = row.querySelector('.name-input');
            const descriptionInput = row.querySelector('.description-input');
            
            const newName = nameInput.value.trim();
            const newDescription = descriptionInput.value.trim();
            
            if (!newName) {
                showNotification('Tên thuộc tính không được để trống!', 'error');
                nameInput.focus();
                return;
            }
            
            // Disable button and show loading state
            btn.disabled = true;
            btn.innerHTML = 'Đang lưu...';
            btn.classList.add('bg-gray-400', 'cursor-not-allowed');
            btn.classList.remove('bg-green-500', 'hover:bg-green-600');
            
            // Send AJAX request to update attribute
            fetch(`/admin/attributes/${attributeId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: newName,
                    description: newDescription
                })
            })
            .then(response => {
                // Check if the response is ok (status 200-299)
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug log
                if (data.success) {
                    // Update display values
                    row.querySelector('.attribute-name').textContent = newName;
                    row.querySelector('.description-text').textContent = newDescription;
                    
                    // Switch back to display mode
                    row.querySelector('.name-display').classList.remove('hidden');
                    row.querySelector('.name-edit').classList.add('hidden');
                    row.querySelector('.description-display').classList.remove('hidden');
                    row.querySelector('.description-edit').classList.add('hidden');
                    row.querySelector('.action-display').classList.remove('hidden');
                    row.querySelector('.action-edit').classList.add('hidden');
                    
                    showNotification('Cập nhật thuộc tính thành công!', 'success');
                } else {
                    console.log('Server returned success=false:', data); // Debug log
                    showNotification(data.message || 'Có lỗi xảy ra khi cập nhật thuộc tính!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Có lỗi xảy ra khi cập nhật thuộc tính!', 'error');
            })
            .finally(() => {
                // Restore button state
                btn.disabled = false;
                btn.innerHTML = 'Lưu';
                btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                btn.classList.add('bg-green-500', 'hover:bg-green-600');
            });
        });
    });

    // Cancel attribute editing
    document.querySelectorAll('.cancel-attribute-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            
            // Reset input values to original
            const originalName = row.querySelector('.attribute-name').textContent;
            const originalDescription = row.querySelector('.description-text').textContent;
            row.querySelector('.name-input').value = originalName;
            row.querySelector('.description-input').value = originalDescription;
            
            // Switch back to display mode
            row.querySelector('.name-display').classList.remove('hidden');
            row.querySelector('.name-edit').classList.add('hidden');
            row.querySelector('.description-display').classList.remove('hidden');
            row.querySelector('.description-edit').classList.add('hidden');
            row.querySelector('.action-display').classList.remove('hidden');
            row.querySelector('.action-edit').classList.add('hidden');
        });
    });

    // Handle Enter key to save, Escape key to cancel
    document.querySelectorAll('.name-input, .description-input').forEach(function(input) {
        input.addEventListener('keydown', function(e) {
            const row = this.closest('tr');
            if (e.key === 'Enter') {
                e.preventDefault();
                row.querySelector('.save-attribute-btn').click();
            } else if (e.key === 'Escape') {
                e.preventDefault();
                row.querySelector('.cancel-attribute-btn').click();
            }
        });
    });
});
</script>
@endsection