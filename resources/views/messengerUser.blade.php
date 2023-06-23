@extends('layouts.app')

@section('mainContent')

    <div class="card mb-4 col-12 strpied-tabled-with-hover rounded-0">
        <div class="card-body table-full-width table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr class="admin-tr-red">
                    <th>##</th>
                    <th>telegram_id</th>
                    <th>Імя користувача</th>
                    <th>Telegram user name</th>
                    <th>Адрес приміщення</th>
                    <th>Номер приміщення</th>
                    <th>created_at</th>
                    <th>Дія</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messengerUsers as $messengerUser)
                    @php
                        /** @var \App\Models\MessengerUsers $messengerUser */
//                    @endphp
                    <tr>
                        <td>{{ $messengerUser->id }}</td>
                        <td>{{ $messengerUser->telegram_id }}</td>
                        <td>{{ empty($messengerUser->name) ? null : $messengerUser->name }}</td>

                        <td>{{ empty($messengerUser->user_name) ? null : $messengerUser->user_name }}</td>
                        <td>{{ $messengerUser->intercom_device->address }}</td>
                        <td>{{ !empty($messengerUser->permission_request) ?? $messengerUser->permission_request->permission_access ? $messengerUser->permission_request->number_premise  : null }}</td>
                        <td>{{ $messengerUser->created_at }}</td>
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
