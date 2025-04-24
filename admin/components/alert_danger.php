<div id="danger-alert" class="alert-danger" style="display: none;">
    <span class="alert-icon"><i class="fas fa-times-circle"></i></span>
    <span class="alert-message"></span>
    <span class="close-btn"><i class="fas fa-times"></i></span>
</div>

<style>
.alert-danger {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color:rgb(180, 70, 70);
    color: white;
    padding: 15px 20px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 1000;
    animation: slideIn 0.5s ease-out;
}

.alert-icon {
    font-size: 20px;
}

.alert-message {
    margin: 0 10px;
}

.close-btn {
    cursor: pointer;
    padding: 5px;
}

.close-btn:hover {
    opacity: 0.8;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

<script>
function showDangerAlert(message) {
    const alert = document.getElementById('danger-alert');
    const messageElement = alert.querySelector('.alert-message');
    messageElement.textContent = message;
    alert.style.display = 'flex';
    
    // Tự động ẩn sau 3 giây
    setTimeout(() => {
        alert.style.animation = 'fadeOut 0.5s ease-out';
        setTimeout(() => {
            alert.style.display = 'none';
            alert.style.animation = '';
        }, 500);
    }, 3000);
}

// Xử lý nút đóng
document.querySelector('.close-btn').addEventListener('click', function() {
    const alert = document.getElementById('danger-alert');
    alert.style.animation = 'fadeOut 0.5s ease-out';
    setTimeout(() => {
        alert.style.display = 'none';
        alert.style.animation = '';
    }, 500);
});
</script>