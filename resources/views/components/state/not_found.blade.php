@props([
    'message',
])

<style>
    .empty-state {
        text-align: center;
        color: #0041c2;
    }
</style>

<div class="no-results" >
    <i class="fas fa-search" ></i>
    <p>{{ $message }}</p>
</div>