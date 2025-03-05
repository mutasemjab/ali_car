@extends('layouts.admin')
@section('title')

{{ __('messages.Edit') }} {{ __('messages.products') }}
@endsection



@section('contentheaderlink')
<a href="{{ route('products.index') }}"> {{ __('messages.products') }} </a>
@endsection

@section('contentheaderactive')
{{ __('messages.Edit') }}
@endsection




@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> {{ __('messages.Edit') }} {{ __('messages.products') }} </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">


        <form action="{{ route('products.update',$data['id']) }}" method="post" enctype='multipart/form-data'>
            <div class="row">
                @csrf
                @method('PUT')



                <div class="form-group col-md-6">
                    <label for="category_id">Parent Category</label>
                    <select class="form-control" name="category" id="category_id">
                        <option value="">Select Parent Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $data->category_id ? 'selected' : '' }}>
                            {{ $category->name_ar }}
                        </option>
                        @endforeach
                    </select>
                    @error('category')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="unit_id">Unit</label>
                    <select class="form-control" name="unit" id="unit_id">
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $unit->id == $data->unit_id ? 'selected' : '' }}>
                            {{ $unit->name_ar }}
                        </option>
                        @endforeach
                    </select>
                    @error('unit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.Name_ar') }}</label>
                        <input name="name_ar" id="name_ar" class="form-control"
                            value="{{ old('name_ar', $data->name_ar) }}">
                        @error('name_ar')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.Name_en') }}</label>
                        <input name="name_en" id="name_en" class="form-control"
                            value="{{ old('name_en', $data->name_en) }}">
                        @error('name_en')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.description_en') }}</label>
                        <textarea name="description_en" id="description_en" class="form-control"
                            value="{{ old('description_en') }}" rows="8">{{$data->description_en}}</textarea>
                        @error('description_en')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.description_ar') }}</label>
                        <textarea name="description_ar" id="description_ar" class="form-control"
                            value="{{ old('description_ar') }}" rows="8">{{$data->description_ar}}</textarea>
                        @error('description_ar')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.tax') }} %</label>
                        <input name="tax" id="tax" class="form-control" value="{{ old('tax', $data->tax) }}">
                        @error('tax')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.selling_price_for_user') }}</label>
                        <input name="selling_price_for_user" id="selling_price_for_user" class="form-control"
                            value="{{ old('selling_price_for_user', $data->selling_price_for_user) }}">
                        @error('selling_price_for_user')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('messages.min_order_for_user') }}</label>
                        <input name="min_order_for_user" id="min_order_for_user" class="form-control"
                            value="{{ old('min_order_for_user', $data->min_order_for_user) }}">
                        @error('min_order_for_user')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

             

                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{ __('messages.Status') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select</option>
                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> update</button>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-danger">cancel</a>

                    </div>
                </div>
            </div>

        </form>



    </div>


</div>

@endsection
