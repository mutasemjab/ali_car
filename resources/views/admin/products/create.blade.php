@extends('layouts.admin')
@section('title')
{{ __('messages.products') }}
@endsection


@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> {{ __('messages.Add_New') }} {{ __('messages.products') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="post" enctype='multipart/form-data'>
            <div class="row">
                @csrf
                <div class="form-group col-md-6">
                    <label for="category_id"> {{ __('messages.categories') }}</label>
                    <select class="form-control" name="category" id="category_id">
                        <option value="">Select Parent Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="unit_id"> {{ __('messages.unit') }}</label>
                    <select class="form-control" name="unit" id="unit_id">
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('unit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="number"> {{ __('messages.number') }}</label>
                    <input name="number" id="number" class="form-control" value="{{ old('number') }}">
                    @error('number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="name_ar"> {{ __('messages.Name_ar') }}</label>
                    <input name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') }}">
                    @error('name_ar')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="name_en"> {{ __('messages.Name_en') }}</label>
                    <input name="name_en" id="name_en" class="form-control" value="{{ old('name_en') }}">
                    @error('name_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <div class="form-group col-md-6">
                    <label for="description_en"> {{ __('messages.description_en') }}</label>
                    <textarea name="description_en" id="description_en" class="form-control" rows="8">{{ old('description_en') }}</textarea>
                    @error('description_en')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="description_ar"> {{ __('messages.description_ar') }}</label>
                    <textarea name="description_ar" id="description_ar" class="form-control" rows="8">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <div class="form-group col-md-6">
                    <label for="tax"> {{ __('messages.tax') }} %</label>
                    <input name="tax" id="tax" class="form-control" value="{{ old('tax') }}">
                    @error('tax')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="selling_price_for_user"> {{ __('messages.selling_price_for_user') }}</label>
                    <input name="selling_price_for_user" id="selling_price_for_user" class="form-control" value="{{ old('selling_price_for_user') }}">
                    @error('selling_price_for_user')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="min_order_for_user"> {{ __('messages.min_order_for_user') }}</label>
                    <input name="min_order_for_user" id="min_order_for_user" class="form-control" value="{{ old('min_order_for_user') }}">
                    @error('min_order_for_user')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

              


                <div class="form-group col-md-6">
                    <label for="status"> {{ __('messages.Status') }}</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select</option>
                        <option @if(old('status')==1 || old('status')=="") selected="selected" @endif value="1">Active</option>
                        <option @if(old('status')==2 and old('status')!="") selected="selected" @endif value="2">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


            </div>


            <div class="form-group col-md-12 text-center">
                <button id="do_add_item_cardd" type="submit" class="btn btn-primary">{{ __('messages.Submit') }}</button>
                <a href="{{ route('products.index') }}" class="btn btn-danger">{{ __('messages.Cancel') }}</a>
            </div>
        </form>
    </div>
</div>

@endsection
