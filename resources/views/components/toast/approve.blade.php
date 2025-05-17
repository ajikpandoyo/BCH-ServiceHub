@props([
    'title',
    'condition',
])



<div id="successPopup" class="custom-toast-success">
    <div class="icon-left-success">
        <span class="check-icon">✔</span>
    </div>
    <div class="toast-text">
        <div class="toast-title">{{ $title }}</div>
        <div class="toast-message">{{ $condition }}</div>
    </div>
    <div class="icon-right" onclick="document.getElementById('successPopup').style.display='none'">
        ×
    </div>
</div>

<style>
    /* success toast */
    .custom-toast-success {
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(90deg, #38b000, #00b894);
        color: white;
        padding: 16px 20px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        max-width: 400px;
        z-index: 9999;
        font-family: 'Segoe UI', sans-serif;
        opacity: 1;
        transition: opacity 0.5s ease-out;
        }

        .icon-left-success {
        background-color: rgba(0, 0, 0, 0.1);
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        }

        .check-icon {
        font-size: 16px;
        font-weight: bold;
        color: white;
        }

        .toast-text {
        flex-grow: 1;
        }

        .toast-title {
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 4px;
        }

        .toast-message {
        font-size: 14px;
        }

        .icon-right {
        font-size: 18px;
        margin-left: 12px;
        cursor: pointer;
        font-weight: bold;
        opacity: 0.8;
        }

        .icon-right:hover {
        opacity: 1;
        }
</style>

<script>
    function hideToast() {
        const toast = document.getElementById('successPopup');
        toast.classList.add('fade-out');
        setTimeout(() => {
            toast.style.display = 'none';
        }, 500); // match transition duration
    }

    // Auto-hide after 3 seconds
    setTimeout(() => {
        hideToast();
    }, 3000);
</script>