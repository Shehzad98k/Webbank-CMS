<div class="pt-1 position-relative">
    <table class="table table-responsive-md mb-0" aria-describedby="news-listing-table">
        <thead>
        <tr>
            <th scope="row">
                <input class="form-control" placeholder="Search By title" type="search" wire:model.debounce.500ms="title">
            </th>
            <th scope="row"></th>
            <th scope="row"></th>
            <th scope="row"></th>
            <th scope="row"></th>
        </tr>
        <tr>
            <th scope="row">
                Feature Image
            </th>
            <th scope="row">
                <a href="javascript:void(0);" wire:click="sort('title')">
                    title
                </a>
                @if ($orderBy == 'title')
                    {!! $sortArrow !!}
                @endif
            </th>
            <th scope="row"> Description </th>
            <th scope="row"> Date </th>
            <th scope="row" class="text-center">
                    Active
            </th>
            <th scope="row">
                <a href="javascript:void(0);" wire:click="sort('created_at')">
                    Created At
                </a>
                @if ($orderBy == 'created_at')
                    {!! $sortArrow !!}
                @endif
            </th>
            <th scope="row">Featured</th>
            <th scope="row">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $new)
            <tr>
                <td style="width: 12%">
                    <img alt="news feature image" style="width: 100%;" src="{{$new->feature ?? ''}}">
                </td>
                <td>
                    {{ $new->title }}
                </td>
                <td>
                     {{$new->getDescription(10)}}
                </td>
                <td style="width: 12%">
                    {{date("M, d Y", strtotime($new->date))}}
                </td>
                <td class="text-center" style="width: 12%" >
                    <div>
                        <livewire:status-toggle-component :key="$new->getUniqueKey('status')" :model="$new"  />
                    </div>
                </td>
                <td>
                    {{ $new->created_at->format('m-d-Y g:i:s a')}}
                </td>
                   
                <td> {{ $new->is_featured? 'Yes': 'No' }} </td>
                <td>
                    <div class="btn-group">
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-success dropdown-toggle waves-effect waves-light">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropright">

                                <a href="{{ route(config('cms.routeNamePrefix').'news.edit',$new) }}" title="Edit Page" class="dropdown-item w-100">
                                    <em class="fa fa-edit"></em> Edit
                                </a>
                                <button class="dropdown-item w-100 text-danger position-relative" wire:click="$emit('confirmDelete','{{$new->id}}')">
                                    <em class="feather icon-trash-2"></em> Delete
                                    @include('layouts.livewire.button-loading')
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end px-2 mx-2 my-2">
        {{ $news->links() }}
    </div>
    @include('layouts.livewire.loading')
</div>
