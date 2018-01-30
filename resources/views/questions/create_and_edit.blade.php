@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('questions.store') }}" method="POST">
        @include('common.error')
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title-field">标题</label>
            <input class="form-control" type="text" name="title" value="{{ old('title', $question->title) }}">
        </div>
        <textarea id="editor"></textarea>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

@section('script')
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>

    <script>
        var simplemde = new SimpleMDE({ element: $('#editor')[0]});
    </script>
@endsection