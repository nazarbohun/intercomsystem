@extends('layouts.app')

@section('mainContent')

    <div class="card mb-4 col-12 strpied-tabled-with-hover rounded-0">
        <div class="card-body table-full-width table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr class="admin-tr-red">
                    <th>##</th>
                    <th>Telegram User Name</th>
                    <th>Ім'я користувача</th>
                    <th>Номер приміщення</th>
                    <th>created_at</th>
                    <th>Дія</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissionRequests as $permissionRequest)
                    @php
                        /** @var \App\Models\PermissionRequest $permissionRequest */
                    @endphp
                    <tr>
                        <td>{{ $permissionRequest->id }}</td>
                        <td>{{ $permissionRequest->messenger_user->user_name  }}</td>
                        <td>{{ $permissionRequest->messenger_user->name }}</td>
                        <td>{{ $permissionRequest->number_premise }}</td>
                        <td>{{ $permissionRequest->created_at }}</td>
                        <td>
                            <div class="btn-primary" style="cursor: pointer;text-align: center" onclick="event.preventDefault();
                    document.getElementById('access-form').submit();">
                                <div class="sb-nav-link-icon"></div>
                                Дозволити доступ
                                <form id="access-form" action="{{ route('permission_requests.access',$permissionRequest->id) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
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
