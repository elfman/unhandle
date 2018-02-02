@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="question">
      <h5>{{ $question->title }}</h5>
      <div class="question-body markdown-body">
        {!! Parsedown::instance()->text($question->body) !!}
      </div>
    </div>

    <hr>
    <div class="answer">
      @if ($answer->id)
        <form action="{{ route('answers.update', $answer->id) }}" method="POST">
      @else
        <form action="{{ route('answers.store') }}" method="POST">
          <input type="hidden" name="question_id" value="{{ $question->id }}">
      @endif
      @include('common.error')
      {{ csrf_field() }}
      <div class="form-group">
        <label for="editor">你的回答：</label>
        <textarea name="body" id="editor" class="form-control">{{ old('body', $answer->body) }}</textarea>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">保存</button>
      </div>
    </form>
    </div>
  </div>

@endsection

@section('script')
  <script src="/js/simplemde/simplemde.min.js"></script>
  <script src="/js/inline-attachment.js"></script>
  <link rel="stylesheet" href="//cdn.bootcss.com/github-markdown-css/2.10.0/github-markdown.css">
  <link rel="stylesheet" href="/js/simplemde/simplemde.min.css">

  <script>
    var simplemde = new SimpleMDE({
      element: $('#editor')[0],
      spellChecker: false,
      autoDownloadFontAwesome: false,
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

    inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, inlineAttachmentConfig);

  </script>
@endsection