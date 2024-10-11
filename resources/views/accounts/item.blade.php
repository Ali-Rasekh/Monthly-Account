<li>
    <div style="display: flex; align-items: center;"> <!-- Use flexbox to align items -->
        <span style="flex-grow: 1;">{{ $account['name'] }}</span> <!-- Push buttons to the left -->
        <span class="action-buttons">
            @if (is_null($account['parent_id']))
                <!-- Only show for main accounts -->
                <button class="button detail-button"
                        onclick="openAccountModal('addChildAccountModal', {{ $account['id'] }} )">افزودن حساب تفصیلی</button>
            @endif

            <button class="button edit-button"
                    onclick="openAccountModal('editAccountModal', null ,   {{ $account['id'] }} )">ویرایش</button>

            <!-- Hidden delete form -->
            <form id="deleteForm-{{ $account['id'] }}" action="{{ route('accounts.destroy', $account['id']) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            <button class="button delete-button"
                    onclick="confirmDelete({{ $account['id'] }})">حذف</button>
        </span>
    </div>

    @if (!empty($account['children']))
        <ul>
            @foreach ($account['children'] as $child)
                @include('accounts.item', ['account' => $child])
            @endforeach
        </ul>
    @endif
</li>

<script>
    function confirmDelete(id) {
        if (confirm('آیا از حذف این حساب مطمئن هستید؟')) {
            document.getElementById('deleteForm-' + id).submit();
        }
    }
</script>
