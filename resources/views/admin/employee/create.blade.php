
@extends("layouts.admin")

@section('css')
    <link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('messages.Create Employee') }}</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.employee.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('messages.Name') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control @if ($errors->has('name')) is-invalid @endif"
                                        id="name" placeholder="Name" value="{{ old('name') }}" name="name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username">{{ __('messages.User name') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="username"
                                        class="form-control @if ($errors->has('username')) is-invalid @endif"
                                        id="username" placeholder="username" value="{{ old('username') }}" name="username">
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('messages.Password') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                                        id="password" placeholder="password" value="{{ old('password') }}" name="password">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                             <div class="my-3">
                               @foreach ($roles as $role)
                                    <br>
                                    <input {{in_array( $role->id,old('roles')? old('roles'): []) ? 'checked':''}} class="ml-5" type="checkbox" name="roles[]" id="role_{{$role->id}}" value="{{ $role->id }}">
                                    <label for="role_{{$role->id}}"> {{ $role->name }}. </label>
                                    <br>
                                @endforeach
                            </div>
                            <div class="row" id="permissions">
                                @error('perms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <span class="emsg text-danger"></span>
                            </div>


                            <div class="text-right">
                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light">{{ __('messages.Save') }}</button>
                                <a type="button" href="{{ route('admin.employee.index') }}"
                                    class="btn btn-danger waves-effect waves-light m-l-10">{{ __('messages.Cancel') }}
                                </a>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-fileuploads.init.js') }}"></script>
@endsection
