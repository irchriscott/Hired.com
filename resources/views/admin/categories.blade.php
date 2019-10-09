@extends('layouts.app')
@section('content')
    <div class="container hd-big-margins">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Category') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.store.category') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description" required autofocus></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Category Image') }}</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="image" required autofocus>
                            </div>
                        </div>  
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="genric-btn primary radius">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8" style="margin-top:20px"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Subcategory') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.store.subcategory') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description" required autofocus></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Icon Type') }}</label>
                            <div class="col-md-6">
                                <select name="icon_type" id="type" class="nice-select wide" required>
                                    <option value="fontawesome">Font Awesome</option>
                                    <option value="material">Material</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Icon Name') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="icon_name" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
                            <div class="col-md-6">
                                <select name="category_id" class="form-control" required>
                                    @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Is Teachable') }}</label>
                            <div class="col-md-6">
                                <select name="is_teachable" id="gender" class="nice-select wide" required>
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="genric-btn primary radius">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection