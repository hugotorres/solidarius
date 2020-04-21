@extends('layouts.app')

@section('content')
{{$categories}}
<new-product-form :categoriesData="{{  json_encode($categories)  }}"></new-product-form>


<footer-vue></footer-vue>
@endsection
