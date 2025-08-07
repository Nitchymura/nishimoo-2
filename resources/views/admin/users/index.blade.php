@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
    <form action="{{ route('admin.users') }}" method="get">
        <input type="text" name="search" placeholder="search..." class="form-control form-control-sm w-25 mb-3 ms-auto">
    </form>
    <table class="table border bg-qhite table-hover align-middle text-secondary">
        <thead class="table-success text-secondary text-uppercase small">
            <tr>
                <th></th>
                <th>Name</th>
                <th>email</th>
                <th>created at</th>
                <th>status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_users as $user)
                <tr>
                    <td>
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md d-block text-center"></i>
                        @endif
                    </td>
                    <td><a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{date('M d, Y H:m:s', strtotime($user->created_at))}}
                    </td>
                    <td>
                        {{-- status --}}
                        @if($user->trashed())
                            <i class="fa-regular fa-circle"></i> Inactive
                        @else
                            <i class="fa-solid fa-circle text-success"></i> Active
                        @endif
                    </td>
                    <td>
                        @if($user->id != Auth::user()->id)
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown" >
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            @if($user->trashed())
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#activate-user{{ $user->id }}">
                                        <i class="fa-solid fa-user-slash"></i> Activate {{ $user->name }}
                                    </button>
                                </div>
                            @else
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user{{ $user->id }}">
                                        <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        @include('admin.users.status')
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_users->links() }}

@endsection