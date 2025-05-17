@props([
    'url',
    'title',
    'icon' => '',
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

    .btn-outline-tertiary {
        border: 1px solid #0041C2;
        background: white;
        color: #0041C2;

}
</style>

<button href="{{ $url ?? '' }}" type="{{ $type }}" class="btn btn-outline-tertiary" {{ $onclick ? "onclick=$onclick" : '' }}>
    {{ $title }} <i class="{{ $icon }}"></i>
</button>