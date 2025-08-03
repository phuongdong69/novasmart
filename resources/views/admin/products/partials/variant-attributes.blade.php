@if(isset($variant->variantAttributeValues) && count($variant->variantAttributeValues))
    @foreach($variant->variantAttributeValues as $attrValue)
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
            {{ $attrValue->attributeValue->attribute->name ?? '' }}: {{ $attrValue->attributeValue->value ?? '' }}
        </span>
    @endforeach
@else
    <span class="text-gray-400">Không có thuộc tính</span>
@endif
