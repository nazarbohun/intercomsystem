@extends('layouts.app')

@section('mainContent')
    <div class="col-12 pl-0">
        <a type="submit" class="btn btn-primary mb-3" href="/">
            Додати новий пристрій домофону
            <i class="fas fa-plus mr-1"></i>
        </a>
    </div>
    <div class="card mb-4 col-12 strpied-tabled-with-hover rounded-0">
        <div class="card-body table-full-width table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr class="admin-tr-red">
                    <th>##</th>
                    <th>Кількість приміщень</th>
                    <th>Адрес приміщення</th>
                    <th>Назва адміністратора</th>
                    <th>created_at</th>
                    <th>Дія</th>
                </tr>
                </thead>
                <tbody>
                @foreach($intercomDevices as $intercomDevice)
                    @php
                        /** @var \App\Models\IntercomDevice $intercomDevice */
                    @endphp
                    <tr>
                        <td>{{ $intercomDevice->id }}</td>
                        <td>{{ $intercomDevice->number_premises  }}</td>
                        <td>{{ $intercomDevice->address }}</td>
                        <td>{{ $intercomDevice->user->name }}</td>
                        <td>{{ $intercomDevice->created_at }}</td>
                        <td>

                            <a href="" title="Редадгувати">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a data-toggle="modal" id="smallButton" data-target="#smallModal"
                               data-attr=""
                               data-id=""
                               title="Видалити">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="justify-content-center">Видалення продукта</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <!-- Полученый ответ Ajax -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
