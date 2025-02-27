<div class="pt-1 position-relative">
    <div class="actions d-flex w-100 px-2 justify-content-end">
        <div id="bulk-actions" style="display: none">
            <a href="javascript:void(0);" class="btn btn-primary" wire:click="markActive">
                <em class="fa fa-download"> Mark Active</em>
            </a>
            <a href="javascript:void(0);" class="btn btn-danger ml-2" wire:click="markInactive">
                <em class="fa fa-download"> Mark Inactive</em>
            </a>
        </div>

        <a class="btn btn-primary ml-2" href="{{ route(config('core.routeNamePrefix') . 'import-users.index') }}">
            <em class="fa fa-upload"> Import</em>
        </a>
        <a class="btn btn-primary ml-2" href="{{ $downloadLink }}">
            <em class="fa fa-download"> Export</em>
        </a>

    </div>
    <table class="table table-responsive-md mb-0" aria-describedby="core-table-component">
        <thead>
            <tr>
                <th scope="col" colspan="3">
                    <input type="search" placeholder="Search by Email" class="form-control" wire:model.debounce.500ms="email">
                </th>
                <th scope="row">
                    <select class="form-control" wire:model.debounce.500ms="active">
                        <option value="-1">All</option>
                        <option value="1">Active</option>
                        <option value="0">In Active</option>
                    </select>
                </th>
                <th scope="row"></th>
                <th scope="row"></th>
            </tr>
            <tr>
                <th scope="row" style="width: 20px;">
                    
                </th>
                <th scope="row">
                    <a href="javascript:void(0);" wire:click="sort('name')">
                        Name
                    </a>
                    @if ($orderBy == 'name')
                        {!! $sortArrow !!}
                    @endif
                </th>
                <th scope="row">Email</th>
                <th scope="row" class="text-center">Active</th>
                <th scope="row">
                    <a href="javascript:void(0);" wire:click="sort('created_at')">
                        Registered At
                    </a>
                    @if ($orderBy == 'created_at')
                        {!! $sortArrow !!}
                    @endif
                </th>
                <th scope="row">Action</th>
            </tr>

        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="{{ $user->isAdmin() ? 'bg-danger text-white' : '' }}">
                    <td>
                        <input class="bulk-checkbox" style="width: 20px;" type="checkbox" wire:model.defer="selectedUsers.{{ $user->id }}">
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td class="text-center">
                        <livewire:status-toggle-component :model="$user" :key="$user->getUniqueKey('status')" />
                    </td>
                    <td>
                        {{ $user->created_at->format('m-d-Y g:i:s a') }}
                    </td>
                    <td>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-success dropdown-toggle waves-effect waves-light">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropright">

                                    <a href="{{ route(config('core.routeNamePrefix') . 'users.show', $user) }}" title="Edit User" class="dropdown-item w-100">
                                        <em class="fa fa-eye"></em> View
                                    </a>

                                    <a href="{{ route(config('core.routeNamePrefix') . 'users.roles.index', $user) }}" title="Edit User Roles" class="dropdown-item w-100">
                                        <em class="fa fa-key"></em> Roles
                                    </a>
                                    <a href="{{ route(config('core.routeNamePrefix') . 'users.edit', $user) }}" title="Edit User" class="dropdown-item w-100">
                                        <em class="fa fa-edit"></em> Edit
                                    </a>
                                    {{-- <form action="{{ route(config('core.routeNamePrefix').'users.login',$user) }}" class="d-flex" method="post"> --}}
                                    {{-- @csrf --}}
                                    {{-- <button class="dropdown-item w-100"> --}}
                                    {{-- <em class="feather icon-lock"></em> Login --}}
                                    {{-- </button> --}}
                                    {{-- </form> --}}
                                    {{-- <form action="{{ route(config('core.routeNamePrefix').'users.destroy',$user) }}" class="d-flex" method="post" onsubmit="return confirmDelete()"> --}}
                                    {{-- @csrf --}}
                                    {{-- @method('DELETE') --}}
                                    {{-- <button class="dropdown-item w-100 text-danger"> --}}
                                    {{-- <em class="feather icon-trash-2"></em> Delete --}}
                                    {{-- </button> --}}
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">
                    No results found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end px-2 mx-2 my-2">
        {{ $users->links() }}
    </div>
    @include('layouts.livewire.loading')
</div>

@push('js')

    <script>
        $('body').on('change', '.bulk-checkbox', function() {
            if ($('.bulk-checkbox:checked').length > 0) {
                $('#bulk-actions').show();
            } else {
                $('#bulk-actions').hide();
            }

        })
    </script>

@endpush
