<!-- Call backend layout -->
@extends('layouts.__back')

<!-- Set called layout title -->
@section('title', 'Register Systems')

<!-- Set called layout headername -->


<!-- Set called layout body -->
@section('body')
    
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Систем<small>Мэдлэгийн Сан</small>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<!--begin: Search Form -->
			<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
				<div class="row align-items-center">
					<div class="col-xl-8 order-2 order-xl-1">
						<div class="form-group m-form__group row align-items-center">
							<div class="col-md-4">
								<div class="m-input-icon m-input-icon--left">
									<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
									<span class="m-input-icon__icon m-input-icon__icon--left">
										<span><i class="la la-search"></i></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 order-1 order-xl-2 m--align-right">
						<a href="javascript:;" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
							<span>
								<i class="la la-plus"></i>
								<span>Add</span>
							</span>
						</a>
						<div class="m-separator m-separator--dashed d-xl-none"></div>
					</div>
				</div>
			</div>

			<!--end: Search Form -->

			<!--begin: Datatable -->
			<table class="table m-table m-table--head-bg-info">
				<thead>
					<tr>
						<th data-field="ID">ID</th>
						<th data-field="Name">Name</th>
						<th data-field="State">State</th>
						<th data-field="Priority">Priority</th>
						<th data-field="Type">Type</th>
						<th data-field="Deployed date">Deployed date</th>
						<th data-field="Setting"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($systems as $system)
						<tr>
							<td>{{ $system->id }}</td>
							<td>{{ $system->sys_name }}</td>
							<td>{{ $system->sys_state }}</td>
							<td>{{ $system->sys_priority }}</td>
							<td>{{ $system->sys_type }}</td>
							<td>{{ $system->sys_deployed_date }}</td>
							<td data-field="Actions" class="m-datatable__cell">
							   <span>
							      <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill">
						      		<i class="la la-edit"></i>
							      </a>
							      <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
						      		<i class="la la-remove"></i>
							      </a>				
							   </span>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $systems->links() }}
			<!--end: Datatable -->
		</div>
	</div>

@endsection

@section('pagescript')
	
@endsection


