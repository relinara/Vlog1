<!-- Call backend layout -->
@extends('layouts.__back')

<!-- Set called layout title -->
@section('title', 'Total SSLS')

<!-- Set called layout headername -->


<!-- Set called layout body -->
@section('body')
    
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Total SSL CERTIFICATES
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
<!-- 						<a href="javascript:;" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
							<span>
								<i class="la la-plus"></i>
								<span>Add</span>
							</span>
						</a> -->
						<button type="button" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" data-toggle="modal" data-target="#m_modal_4">+ Add</button>
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
						<th data-field="STATUS">SYSTEM NAME</th>
						<th data-field="START">START DATE</th>
						<th data-field="EXPIRY">EXPIRY DATE</th>
						<th data-field="ACTION"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ssls as $ssl)
						<tr>
							<td>{{ $ssl->id }}</td>
							<td>{{ $ssl->system_name }}</td>
							<td>{{ $ssl->from }}</td>
							<td>{{ $ssl->to }}</td>
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
			<!--end: Datatable -->
			{{ $ssls->links() }}
		</div>
	</div>

		<!--begin::Modal-->
	<div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<form class="m-login__form m-form" method="POST" action="{{ route('ssls') }}">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">SSL Certificate Information</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="recipient-name" class="form-control-label">SSL Name:</label>
							<input type="text" class="form-control" id="ssl-name" name="ssl_name" value="">
						</div>
						<div class="form-group">
							<label for="message-text" class="form-control-label">Created Date:</label>
							<input class="form-control m-input" type="date" value="2019-01-19" id="created-date" name="created-date">
						</div>
						<div class="form-group">
							<label for="message-text" class="form-control-label">Expiry Date:</label>
							<input class="form-control m-input" type="date" value="2019-01-19" id="expiry-date" name="expiry-date">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Modify SSL</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@section('pagescript')
	
@endsection


