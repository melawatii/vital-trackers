@extends('layouts.app')
@section('title','Edit Vital Type')
@section('content')

<!-- Begin: Edit Form -->
<form action="{{ route('vital-types.update',$type->id) }}" method="POST">
    @csrf
    @method('PUT')
    @include('master.vital-types._form')
</form>
<!-- End: Edit Form -->

@endsection
