@extends('layouts.app')
 
@section('content')
<h1 class="my-5">This is Sample Index Page</h1>
<form method="get" action="">
  <div class="row">
    <div class="col-9">
      <div class="form-group">
        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search..." value="">
      </div>
    </div>
    <div class="col-3">
      <button id="s" type="submit" class="btn btn-primary btn-block font-weight-bold">Search</button>
    </div>
  </div>
</form>
<div class="mb-3">
  <a href="{{ route('export.sample', ['keyword' => $keyword]) }}" class="btn btn-primary font-weight-bold"><i class="fas fa-download"></i> Export to CSV</a>
</div>
<div class="small">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Sample1</th>
        <th>Sample2</th>
        <th>Sample3</th>
        <th>Created</th>
        <th>Updated</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $sample_list as $sample )
      <tr>
        <td>{{ $sample->id }}</td>
        <td>{{ $sample->sample1 }}</td>
        <td>{{ $sample->sample2 }}</td>
        <td>{{ $sample->sample3 }}</td>
        <td>{{ $sample->created_at }}</td>
        <td>{{ $sample->updated_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection