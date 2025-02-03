@extends('layouts.app')

@section('content')
<div class="container">
    <h1>التدوينات</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">إضافة تدوينة جديدة</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>الوصف</th>
                <th>تاريخ الإضافة</th>
                <th>التحكم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">عرض</a>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">تعديل</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
</div>
@endsection