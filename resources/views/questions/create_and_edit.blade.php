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
      <div class="form-group">
        <label for="editor">内容</label>
        <textarea name="body" id="editor">{{ old('body', $question->body) }}</textarea>
      </div>
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
  <script src="/js/inline-attachment.js"></script>

  <script>
    var simplemde = new SimpleMDE({
      element: $('#editor')[0],
      spellChecker: false,
    });

    var inlineAttachmentConfig = {
      uploadUrl: '/upload_image',
      extraHeaders: {
        'X-CSRF-Token': $('meta[name="csrf-token"]')[0].content,
      },
      onFileUploadResponse: function (xhr) {
        var result = JSON.parse(xhr.responseText);

        if (result && result.success) {

        }
      }
    };

    inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, inlineAttachmentConfig)
  </script>
@endsection