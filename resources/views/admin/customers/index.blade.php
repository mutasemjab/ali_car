@extends('layouts.admin')
@section('title')
    {{ __('messages.Customers') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title card_title_center"> {{ __('messages.Customers') }} </h3>
            <input type="hidden" id="token_search" value="{{ csrf_token() }}">
            <input type="hidden" id="ajax_search_url" value="{{ route('admin.customer.ajax_search') }}">
            <a href="{{ route('admin.customer.create') }}" class="btn btn-sm btn-success"> {{ __('messages.New') }} {{
            __('messages.Customers') }}</a>
        </div>
        <div class="card-body">
            <form method="get" action="{{ route('admin.customer.index') }}" enctype="multipart/form-data">
                @csrf
                <div class="row my-3">
                    <div class="col-md-3">
                        <input autofocus type="text" placeholder="{{ __('messages.Search') }}" name="search" class="form-control" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="dealer" class="form-control">
                            <option value="">{{ __('messages.AllDealers') }}</option>
                            @foreach ($dealers as $dealer)
                                <option value="{{ $dealer->id }}" {{ request('dealer') == $dealer->id ? 'selected' : '' }}>
                                    {{ $dealer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sectionUser" class="form-control">
                            <option value="">{{ __('messages.AllSectionUsers') }}</option>
                            @foreach ($sectionUsers as $sectionUser)
                                <option value="{{ $sectionUser->id }}" {{ request('sectionUser') == $sectionUser->id ? 'selected' : '' }}>
                                    {{ $sectionUser->name_ar }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success "> {{ __('messages.Search') }} </button>
                    </div>
                </div>
            </form>

            <div class="clearfix"></div>

            <div id="ajax_responce_serarchDiv" class="col-md-12">
                @can('customer-table')
                    @if (@isset($data) && !@empty($data) && count($data) > 0)
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <th>{{ __('messages.Name') }}</th>
                                <th>{{ __('messages.Email') }}</th>
                                <th>{{ __('messages.Phone') }}</th>
                                <th>{{ __('messages.sectionUsers') }}</th>
                                <th>{{ __('messages.dealers') }}</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($data as $info)
                                    <tr>
                                        <td>{{ $info->name }}</td>
                                        <td>{{ $info->email }}</td>
                                        <td>{{ $info->phone }}</td>
                                        <td>{{ $info->sectionUser->name_ar ?? null }}</td>
                                        <td>{{ $info->user->name ?? null }}</td>
                                        <td>
                                            @can('customer-edit')
                                                <a href="{{ route('admin.customer.edit', $info->id) }}" class="btn btn-sm btn-primary">
                                                    {{ __('messages.Edit') }}
                                                </a>
                                            @endcan
                                            <a href="{{ route('admin.customer.export', ['search' => $searchQuery]) }}" class="btn btn-sm btn-success">Export to Excel</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $data->appends(['search' => $searchQuery, 'dealer' => request('dealer'), 'sectionUser' => request('sectionUser')])->links() }}
                    @else
                        <div class="alert alert-danger">
                            {{ __('messages.No_data') }}
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/customers.js') }}"></script>
@endsection
