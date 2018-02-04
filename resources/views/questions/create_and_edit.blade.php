@extends('layouts.app')

@section('content')
  <div class="container">
    @if ($question->id)
      <form action="{{ route('questions.update', $question->id) }}" method="POST">
        {{ method_field('PUT') }}
    @else
      <form action="{{ route('questions.store') }}" method="POST">
    @endif
      @include('common.error')
      {{ csrf_field() }}
      <div class="form-group">
        <label for="title-field">标题</label>
        <input class="form-control" type="text" name="title" value="{{ old('title', $question->title) }}">
      </div>
      <div class="form-group">
        <label for="tags-field">标签</label>
        <input type="text" class="form-control" name="tags" id="tags-field" data-role="tagsinput" value="{{ old('tags', implode(',', $question->tags->pluck('name')->toArray())) }}">
      </div>
      <div class="form-group markdown-body">
        <label for="editor">内容</label>
        <textarea name="body" id="editor" style="visibility: hidden;">{{ old('body', $question->body) }}</textarea>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">保存</button>
      </div>
    </form>
  </div>

@endsection

@section('script')

  <script src="/js/simplemde/simplemde.min.js"></script>
  <script src="/js/inline-attachment.js"></script>
  <script src="//cdn.bootcss.com/typeahead.js/0.11.1/typeahead.bundle.js"></script>
  <script src="/js/tagsinput.js"></script>
  <link rel="stylesheet" href="/css/tagsinput.css">
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

    var tags = {!! \Spatie\Tags\Tag::all()->pluck('name') !!};

    var data = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.whitespace,
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      local: tags,
    });

    $('#tags-field').tagsinput({
      typeaheadjs: {
        minLength: 0,
        source: data.ttAdapter(),
        name: 'tags'
      }
    });

    $('#tags-field').on('beforeItemAdd', function (event) {
      if (tags.indexOf(event.item) === -1) {
        event.cancel = true;
      }
    })
  </script>
@endsection