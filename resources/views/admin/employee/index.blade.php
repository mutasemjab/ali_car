@extends('layouts.admin')

@section('title')
    {{ __('messages.Employee') }}
@endsection

@section('content')
    <!-- Header -->
    <div class="card-header py-3">
        <div class="row g-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-4">
                    @can('employee-add')
                        <a href="{{ route('admin.employee.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>{{ __('messages.New Employee') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-body">
            @can('employee-table')
            <div class="table-responsive">
                @if(count($data) > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="px-4 py-3">{{ __('messages.ID') }}</th>
                                <th class="px-4 py-3">{{ __('messages.Name') }}</th>
                                <th class="px-4 py-3">{{ __('messages.User name') }}</th>
                                <th class="px-4 py-3">{{ __('messages.Role') }}</th>
                                <th class="px-4 py-3 text-center">{{ __('messages.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">{{ $value->id }}</td>
                                    <td class="px-4 py-3 font-weight-medium">{{ $value->name }}</td>
                                    <td class="px-4 py-3">{{ $value->username }}</td>
                                    <td class="px-4 py-3">
                                        @foreach ($value->roles as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-3" style="text-align: center;">
                                        <div class="btn-group">
                                            @can('employee-edit')
                                                <a href="{{ route('admin.employee.edit', $value->id) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('employee-delete')
                                                <form action="{{ route('admin.employee.destroy', $value->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('{{ __('messages.Confirm_Delete') }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info" style="
                        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
                        border: none;
                        border-radius: 15px;
                        padding: 1.5rem;
                        color: #4a5568;
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                        <i class="fas fa-info-circle" style="color: #667eea; font-size: 1.25rem;"></i>
                        {{ __('messages.No_data') }}
                    </div>
                @endif
            </div>
            @endcan

            {{ $data->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('assets/js/category.js') }}"></script>
@endsection
