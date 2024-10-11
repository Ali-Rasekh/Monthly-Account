<div id="{{ $modalId }}" class="side-modal" >
    <div class="side-modal-content">
        <span class="close" onclick="closeAccountModal('{{ $modalId }}')">&times;</span>
        <h3>{{ $method ? 'ویرایش حساب' : 'ایجاد حساب جدید' }}</h3>
        <form action="{{ $action }}" method="POST">
            @method($method ? 'PUT' : 'POST')
            @csrf
                <input type="hidden" name="update_id" value="{{ $method ?? null }}">
            <input type="hidden" name="parent_id" value="{{ $parentId }}">

            <div class="form-group text-right">
                <label for="name_{{ $modalId }}">نام:</label>
                <input type="text" class="form-control" id="name_{{ $modalId }}" name="name" required>
            </div>

            <button type="submit" class="btn btn-success">{{ $method ? 'ذخیره تغییرات' : 'ذخیره' }}</button>
        </form>
    </div>
</div>

