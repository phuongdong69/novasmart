<div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
    <a href="{{ $cancelUrl ?? '#' }}" 
       class="btn btn-secondary">
        {{ $cancelText ?? 'Hủy bỏ' }}
    </a>
    <button type="submit" 
            class="btn btn-primary"
            id="submitBtn">
        <span class="inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ $submitText ?? 'Lưu' }}
        </span>
    </button>
</div> 