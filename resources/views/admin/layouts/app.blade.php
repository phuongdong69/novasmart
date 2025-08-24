<!DOCTYPE html>
<html lang="vi">
<head>
    @include('admin.pages.head')
</head>
<body>
    @include('admin.pages.body')

    <script>
    function showStatusLogModal() {
        document.getElementById('statusLogModal').classList.remove('hidden');
    }
    function hideStatusLogModal() {
        document.getElementById('statusLogModal').classList.add('hidden');
    }
    </script>
</body>
</html>
