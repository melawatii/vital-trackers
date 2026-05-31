@extends('layouts.app')
@section('title','Create Vital Type')
@section('content')

<!-- Begin: Create Form -->
<form action="{{ route('vital-types.store') }}" method="POST">
    @csrf
    @include('vital-types._form')
</form>
<!-- End: Create Form -->

@endsection
