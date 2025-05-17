@props([
    'url',
    'title',
    'icon'  => '',
    'type' => ''

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

    .btn-primary {
        background: #0041C2;
        color: white;
        border: none;
    }
</style>

<a href="{{ $url ?? '' }}" type="{{ $type }}" class="btn btn-primary">{{ $title }} <i class="{{ $icon }}"></i></a>
