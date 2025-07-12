<form action="{{ route('admin.users.update_status', 1) }}" method="POST">
    @csrf
    <button type="submit" name="status_id" value="5">Test đổi trạng thái user 1 sang Hoạt động</button>
</form>
@if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div style="color: red">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 