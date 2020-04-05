@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="row profile">
            <div class="col-md-12 preview-profile">
               <div class="card"><div class="card-body">Aqui puede ir el listado de imagenes de lso libros que corresponden al usuario</div></div>
            </div>

            <div class="col-md-12">
                <div class="profile-content">
                    @if($user->rol==="bitch")
                        <new-product-form  :profile="{{  json_encode($profile)  }}" :categories="{{  json_encode($categories)  }}"></new-product-form>
                     @else
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6 review-box">
                                    <h2>Review</h2>
                                    <div class="review">
                                        review long tex1
                                    </div>
                                </div>
                                <div class="col-sm-6 review-box">
                                    <h2>Review</h2>
                                    <div class="review">
                                        review long tex1
                                    </div>
                                </div>
                                <div class="col-sm-6 review-box">
                                    <h2>Review</h2>
                                    <div class="review ">
                                        review long tex1
                                    </div>
                                </div>
                            </div>
                        </div>
                     @endif
                </div>
            </div>
        </div>
    </div>


    <footer-vue></footer-vue>
@endsection
