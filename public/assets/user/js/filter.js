// Filter functionality
function selectColor(color) {
    document.getElementById('colorInput').value = color;
    document.getElementById('filterForm').submit();
}

function selectSize(size) {
    document.getElementById('screenSizeInput').value = size;
    document.getElementById('filterForm').submit();
}

function selectRam(ram) {
    document.getElementById('ramInput').value = ram;
    document.getElementById('filterForm').submit();
}

function selectStorage(storage) {
    document.getElementById('storageInput').value = storage;
    document.getElementById('filterForm').submit();
}

function clearFilters() {
    // Clear all inputs
    document.getElementById('search').value = '';
    document.getElementById('colorInput').value = '';
    document.getElementById('screenSizeInput').value = '';
    document.getElementById('ramInput').value = '';
    document.getElementById('storageInput').value = '';
    
    // Clear checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    
    // Clear selects
    document.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    
    // Clear price inputs
    document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
    
    // Submit form
    document.getElementById('filterForm').submit();
}

// Auto submit when dropdown changes
document.addEventListener('DOMContentLoaded', function() {
    const originSelect = document.querySelector('select[name="origin"]');
    if (originSelect) {
        originSelect.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    }
    
    // Auto submit when checkboxes change
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
}); 