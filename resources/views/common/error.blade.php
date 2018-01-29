@if (count($errors) > 0)
  <div class="alert alert-danger">
    <h5>有错误发生：</h5>
    <ul>
      @foreach ($errors->all() as $error)
        <li><i class="fa fa-remove"></i> {{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif