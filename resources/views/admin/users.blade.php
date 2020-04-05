@extends('layouts.admin')
@section('content')
{{-- tables --}}

<div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header">
            <h4 class="card-title">Users</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>
                      Name
                    </th>
                    <th>
                      Status
                    </th>
                    <th>
                      Email
                    </th>
                    <th class="text-center">
                      Gender
                    </th>

                      <th class="text-center">
                        Admin
                      </th>
                      <th class="text-center">
                        Bday
                      </th>
                      <th class="text-center">
                        Fecha creacion
                      </th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                          {{$user->name}}
                        </td>
                        <td>
                         {{$user->status}}
                        </td>
                        <td>
                         {{$user->email}}
                        </td>
                        <td class="text-center">
                          {{$user->gender}}
                        </td>
                        <td class="text-center">
                            {{$user->is_admin}}
                          </td>

                          <td class="text-center">
                            {{$user->bday}}
                          </td>
                          <td class="text-center">
                            {{$user->created_at}}
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

@endsection
