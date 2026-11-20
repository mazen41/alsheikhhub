@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('All Catslides')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Catslides') }}</h5>
				</div>
				<div class="col-md-4">
					<form class="" id="sort_Catslides" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table aiz-table mb-0">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>{{translate('Name')}}</th>
		                    <th>{{translate('Logo')}}</th>
		                    <th class="text-right">{{translate('Options')}}</th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($catslides as $key => $catslide)
		                    <tr>
		                        <td>{{ ($key+1) + ($catslides->currentPage() - 1)*$catslides->perPage() }}</td>
		                        <td>{{ $catslide->getTranslation('name') }}</td>
														<td>
		                            <img src="{{ uploaded_asset($catslide->logo) }}" alt="{{translate('Catslide')}}" class="h-50px">
		                        </td>
		                        <td class="text-right">
		                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('catslides.edit', ['id'=>$catslide->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
		                                <i class="las la-edit"></i>
		                            </a>
		                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('catslides.destroy', $catslide->id)}}" title="{{ translate('Delete') }}">
		                                <i class="las la-trash"></i>
		                            </a>
		                        </td>
		                    </tr>
		                @endforeach
		            </tbody>
		        </table>
		        <div class="aiz-pagination">
                	{{ $catslides->appends(request()->input())->links() }}
            	</div>
		    </div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ translate('Add New catslide') }}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('catslides.store') }}" method="POST">
					@csrf
					<div class="form-group mb-3">
						<label for="name">{{translate('Name')}}</label>
						<input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control" required>
					</div>
          <div class="form-group row" id="category">
              <label class="col-md-3 col-from-label">{{translate('Category')}} <span class="text-danger">*</span></label>
              <div class="col-md-8">
                  <select class="form-control aiz-selectpicker" name="category_id" id="category_id" data-live-search="true" required>
                      @foreach ($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                      @foreach ($category->childrenCategories as $childCategory)
                      @include('categories.child_category', ['child_category' => $childCategory])
                      @endforeach
                      @endforeach
                  </select>
              </div>
          </div>
          
					<div class="form-group mb-3">
						<label for="name">{{translate('Logo')}} <small>({{ translate('120x80') }})</small></label>
						<div class="input-group" data-toggle="aizuploader" data-type="image">
							<div class="input-group-prepend">
									<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
							</div>
							<div class="form-control file-amount">{{ translate('Choose File') }}</div>
							<input type="hidden" name="logo" class="selected-files">
						</div>
						<div class="file-preview box sm">
						</div>
					</div>
					<div class="form-group row">
                          <label class="col-sm-12 col-from-label" for="url">{{translate('Url')}}</label>
                          <div class="col-sm-12">
                              <input type="text" placeholder="{{translate('Url')}}" id="url" name="url" class="form-control">
                          </div>
                      </div>
					<div class="form-group mb-3">
						<label for="name">{{translate('Meta Title')}}</label>
						<input type="text" class="form-control" name="meta_title" placeholder="{{translate('Meta Title')}}">
					</div>
					<div class="form-group mb-3">
						<label for="name">{{translate('Meta Description')}}</label>
						<textarea name="meta_description" rows="5" class="form-control"></textarea>
					</div>
					<div class="form-group mb-3 text-right">
						<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
    function sort_catslides(el){
        $('#sort_catslides').submit();
    }
</script>
@endsection
