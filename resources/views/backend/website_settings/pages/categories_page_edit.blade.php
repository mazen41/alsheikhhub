@extends('backend.layouts.app')
@section('content')

<div class="row">
	<div class="col-xl-10 mx-auto">
		<h6 class="fw-600">{{ translate('Categories Page Panners') }}</h6>

    {{-- Categories Banner --}}
    {{-- banners one --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Home Banner 4 (Max 3)') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Banner & Links') }}</label>
						<div class="home-banner4-target">
							<input type="hidden" name="types[]" value="home_banner4_images">
							<input type="hidden" name="types[]" value="home_banner4_links">
							<input type="hidden" name="types[]" value="home_banner4_categories">
							@if (get_setting('home_banner4_images') != null)
								@foreach (json_decode(get_setting('home_banner4_images'), true) as $key => $value)
									<div class="row gutters-5">

										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="home_banner4_images">
					                                <input type="hidden" name="home_banner4_images[]" class="selected-files" value="{{ json_decode(get_setting('home_banner4_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" name="types[]" value="home_banner4_links">
												<input type="text" class="form-control" placeholder="http://" name="home_banner4_links[]" value="{{ json_decode(get_setting('home_banner4_links'), true)[$key] }}">
											</div>
										</div>

                    <div class="col-md-3">
											{{-- <div class="form-group"> --}}
												
												{{-- <input type="text" class="form-control" placeholder="{{ translate('Category') }}" value="{{ json_decode(get_setting('home_banner4_categories'), true)[$key] }}"> --}}

                        <div class="form-group row" id="category">
                            {{-- <label class="col-lg-12 col-from-label">{{translate('Category')}}</label> --}}
                            <div class="col-lg-12">
                              <input type="hidden" name="types[]" value="home_banner4_categories">
                               @php
                                  $cat_id = json_decode(get_setting('home_banner4_categories'), true)[$key];
                                @endphp
                                <select class="form-control" name="home_banner4_categories[]" id="category_id" data-selected="" data-live-search="true">
                                 
                                  @foreach (\App\Category::get()  as  $category)
                                  <option value="{{ $category->id }}" 
                                    
                                    @if($category->id == $cat_id)
                                      selected
                                    @endif
                                    >{{ $category->getTranslation('name') }} 
                                  </option>
                                    {{-- @foreach ($category->childrenCategories as $childCategory) --}}
                                      {{-- @include('categories.child_category', ['child_category' => $childCategory]) --}}
                                    {{-- @endforeach --}}
                                    
                                  @endforeach
                                 
                                </select>
                               
                            </div>
                        </div>
                        
											{{-- </div> --}}
										</div>

										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-4">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="home_banner4_images">
											<input type="hidden" name="home_banner4_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="home_banner4_links">
										<input type="text" class="form-control" placeholder="http://" name="home_banner4_links[]">
									</div>
								</div>
                 <div class="col-md">
                        <div class="form-group row" id="category">
                            <div class="col-lg-12">
                              <input type="hidden" name="types[]" value="home_banner4_categories">
                               @php
                                  $cat_id = json_decode(get_setting('home_banner4_categories'), true)[$key];
                                @endphp
                                <select class="form-control" name="home_banner4_categories[]" id="category_id" data-selected="" data-live-search="true">
                                  @foreach (\App\Category::get() as  $category)
                                  <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                   
                                  @endforeach
                                </select>
                            </div>
                        </div>
										</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".home-banner4-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	{{-- banners two --}}
	<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Home Banner 7 (Max 3)') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Banner & Links') }}</label>
						<div class="home-banner7-target">
							<input type="hidden" name="types[]" value="home_banner7_images">
							<input type="hidden" name="types[]" value="home_banner7_links">
							<input type="hidden" name="types[]" value="home_banner7_categories">
							@if (get_setting('home_banner7_images') != null)
								@foreach (json_decode(get_setting('home_banner7_images'), true) as $key => $value)
									<div class="row gutters-5">

										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="home_banner7_images">
					                                <input type="hidden" name="home_banner7_images[]" class="selected-files" value="{{ json_decode(get_setting('home_banner7_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" name="types[]" value="home_banner7_links">
												<input type="text" class="form-control" placeholder="http://" name="home_banner7_links[]" value="{{ json_decode(get_setting('home_banner7_links'), true)[$key] }}">
											</div>
										</div>

                    <div class="col-md-3">
											{{-- <div class="form-group"> --}}
												
												{{-- <input type="text" class="form-control" placeholder="{{ translate('Category') }}" value="{{ json_decode(get_setting('home_banner7_categories'), true)[$key] }}"> --}}

                        <div class="form-group row" id="category">
                            {{-- <label class="col-lg-12 col-from-label">{{translate('Category')}}</label> --}}
                            <div class="col-lg-12">
                              <input type="hidden" name="types[]" value="home_banner7_categories">
                               @php
                                  $cat_id = json_decode(get_setting('home_banner7_categories'), true)[$key];
                                @endphp
                                <select class="form-control" name="home_banner7_categories[]" id="category_id" data-selected="" data-live-search="true">
                                 
                                  @foreach (\App\Category::get()  as  $category)
                                  <option value="{{ $category->id }}" 
                                    
                                    @if($category->id == $cat_id)
                                      selected
                                    @endif
                                    >{{ $category->getTranslation('name') }} 
                                  </option>
                                    {{-- @foreach ($category->childrenCategories as $childCategory) --}}
                                      {{-- @include('categories.child_category', ['child_category' => $childCategory]) --}}
                                    {{-- @endforeach --}}
                                    
                                  @endforeach
                                 
                                </select>
                               
                            </div>
                        </div>
                        
											{{-- </div> --}}
										</div>

										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-4">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="home_banner7_images">
											<input type="hidden" name="home_banner7_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="home_banner7_links">
										<input type="text" class="form-control" placeholder="http://" name="home_banner7_links[]">
									</div>
								</div>
                 <div class="col-md">
                        <div class="form-group row" id="category">
                            <div class="col-lg-12">
                              <input type="hidden" name="types[]" value="home_banner7_categories">
                               @php
                                  $cat_id = json_decode(get_setting('home_banner7_categories'), true)[$key];
                                @endphp
                                <select class="form-control" name="home_banner7_categories[]" id="category_id" data-selected="" data-live-search="true">
                                  @foreach (\App\Category::get() as  $category)
                                  <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                   
                                  @endforeach
                                </select>
                            </div>
                        </div>
										</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".home-banner7-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
		$(document).ready(function(){
		    AIZ.plugins.bootstrapSelect('refresh');
		});
    </script>
@endsection
