@extends('layouts.admin')
@section('content')

<style>
    .categories .form-group input[type="file"] {
    opacity: 1 !important;
    position: relative;
    width: auto;
    height: auto;
}
</style>


 @if(isset($selectedCategory))
<form action="../update" method="POST"  enctype="multipart/form-data">
    @csrf
 <div class="content categories">
     <div class="row">
         <div class="col-md-12">
             <div class="card">
                 <div class="card-header">
                   <h5 class="title">Editando Categoria</h5>
                 </div>
                 <div class="card-body">
                    <input type="hidden" name="id" class="hidden"    value="{{$selectedCategory->id}}">
                     <div class="row">
                       <div class="col-md-6 pr-md-1">
                         <div class="form-group">
                           <label>Titulo</label>
                         <input type="text" name="title" class="form-control" placeholder="title"  value="{{$selectedCategory->title}}">
                         </div>
                       </div>
                       <div class="col-md-6 pr-md-1">
                           <div class="form-group">
                               <label for="categoria-padre">Categoria padre</label>
                               <select class="form-control" name="parent_id" id="categoria-padre">
                               <option value="{{$selectedCategory->parent_id}}" selected>{{$selectedCategory->parent_id}}</option>
                                   @foreach($categories as $category)
                               <option value="{{$category->id}}">{{$category->title}}</option>
                                   @endforeach
                               </select>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                       <div class="col-md-8">
                         <div class="form-group">
                           <label>Descripcion</label>
                         <textarea  cols="80" class="form-control" name="description"  >{{$selectedCategory->description}}</textarea>
                         </div>
                       </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-6">
                             <div class="current-icon" >
                               @if (isset($selectedCategory->icon))
                                   <img src="{{ asset('/uploads/'.$selectedCategory->icon) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                               @endif
                             </div>
                           <div class="form-group">
                               <label for="icon">Icono</label>
                               <input type="file" name="icon" id="icon">
                            </div>
                         </div>

                         <div class="col-sm-6">
                             <div class="current-image" >
                                 @if (isset($selectedCategory->image))
                                     <img src="{{ asset('/uploads/'.$selectedCategory->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                 @endif
                               </div>
                           <div class="form-group">
                               <label for="image">Imagen</label>
                               <input type="file" name="image" id="image">
                            </div>
                         </div>


                     </div>

                 </div>
                 <div class="card-footer">
                   <button type="submit" class="btn btn-fill btn-primary">Save</button>
                 </div>
               </div>


        </div>
     </div>
</div>
</form>
@else

<form action="categories/new" method="POST"  enctype="multipart/form-data">
   @csrf
<div class="content categories">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Nueva Categoria</h5>
              </div>
              <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>Titulo</label>
                      <input type="text" name="title" class="form-control" placeholder="title"  >
                      </div>
                    </div>
                    <div class="col-md-6 pr-md-1">
                        <div class="form-group">
                            <label for="categoria-padre">Categoria padre</label>
                            <select class="form-control" name="parent_id" id="categoria-padre">
                                <option value="" selected>---</option>
                                @foreach($categories as $category)
                                @if(!isset($category->parent_id))
                            <option value="{{$category->id}}">{{$category->title}}</option>
                            @endIf()
                                @endforeach
                            </select>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label>Descripcion</label>
                      <textarea  cols="80" class="form-control" name="description"  ></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label for="icon">Icono</label>
                            <input type="file" name="icon" id="icon">
                         </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                            <label for="image">Imagen</label>
                            <input type="file" name="image" id="image">
                         </div>
                      </div>


                  </div>
                </form>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-fill btn-primary">Save</button>
              </div>
            </div>
          </div>
    </div>
</div>
</form>
@endIf()


@if(!isset($selectedCategory))
{{-- tables --}}
<div class="content">
    <div class="row">

      <div class="col-md-12">
        <div class="card   ">
          <div class="card-header">
            <h4 class="card-title">Categories</h4>
            <p class="category">  </p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>
                        Opciones
                      </th>
                    <th>
                      Titulo
                    </th>
                    <th>
                      Descripcion
                    </th>
                    <th>
                        Categoria Padre
                      </th>
                    <th>
                      Imagen
                    </th>
                    <th class="text-center">
                      Icono
                    </th>
                    <th class="text-center">
                        Fecha creación
                      </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $category)
                    <tr>

                        <td>

                            <a href="{{route('admin.categories.edit', ['id' => $category->id])}}">
                            <i class="tim-icons icon-pencil"></i>
                            </a>--
                             {{$category->id}}



                          </td>

                        <td>
                          {{$category->title}}
                        </td>
                        <td>
                         {{$category->description}}
                        </td>
                        <td>
                        {{$category->parentTitle}}
                        </td>
                        <td>
                            {{$category->image}}
                        {{--  <img src="{{$category->image}}" alt="Necesitu"> --}}
                        </td>
                        <td class="text-center">
                            {{$category->icon}}
                        {{--   <img src="{{$category->icon}}" alt="Necesitu"> --}}
                        </td>
                        <td class="text-center">
                            {{$category->created_at}}

                            <form action="{{route('admin.deleteCategory')}}" method="POST">
                                @csrf
                             <input type="hidden" name="id" value="{{$category->id}}">
                                <button type="submit" class="button btn-danger">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                          </td>
                      </tr>
                    @endforeach

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
{{-- cierro tables --}}
@endif()
@endsection
