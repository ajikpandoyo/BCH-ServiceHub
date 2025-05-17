@props([
    'url',
    'title',
    'icon'  => '',
    'type' => '',
    'onclick' => ''
])

<style>
    .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-outline-secondary {
        border: 1px solid #D0D5DD;
        background: white;
        color: #64748b;
}
</style>

<a href="{{ $url ?? '' }}" type="{{ $type }}" class="btn btn-outline-secondary" {{ $onclick ? "onclick=$onclick" : '' }}>
    {{ $title }} <i class="{{ $icon }}"></i>
</a>