<div id="sideModal" class="side-modal">
    <div class="side-modal-content">
        <span class="close" onclick="closeSideModal()">&times;</span>
        <h3>{{ $title }}</h3>
        <form id="createSettingForm" action="{{ $action }}" method="POST" onsubmit="return validateCreateForm();">
            @csrf
            {{ $slot }}
            <button type="submit" class="btn btn-success">{{ $submitLabel ?? 'ذخیره' }}</button>
        </form>
    </div>
</div>

<style>
    /* استایل برای مدال کشویی */
    .side-modal {
        position: fixed;
        right: 0;
        top: 0;
        width: 0;
        height: 100%;
        background-color: white;
        overflow-x: hidden;
        transition: 0.5s;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .side-modal-content {
        padding: 20px;
        width: 300px;
    }

    .close {
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 20px;
    }

    .error-message {
        border: 2px solid red;
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
    }
</style>

<script>
    function openSideModal() {

        document.getElementById('sideModal').style.width = '300px';
        document.addEventListener('keydown', handleEscapeKey);
    }

    function closeSideModal() {
        document.getElementById('sideModal').style.width = '0';
        document.removeEventListener('keydown', handleEscapeKey);
    }

    function handleEscapeKey(event) {
        if (event.key === 'Escape') {
            closeSideModal();
        }
    }
</script>
