@props([
    'icon',
    'messsage',
])

<style>
    .empty-state {
    text-align: center;
    color: #0041c2;
}
</style>

<div class="empty-state">
    <i class="{{ $icon }} text-gray-400" style="font-size: 48px;"></i>
    <p class="mt-2 text-gray-500">{{ $messsage }}</p>
</div>