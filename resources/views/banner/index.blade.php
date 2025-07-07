@extends('layout.master')
@section('content')
@section('title', __('MyAce | Web Banner'))
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Brand List</h4>
                    <h6>Manage your Brand</h6>
                </div>
            </div>
            <ul class="table-top-head">
                {{-- <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="{{ asset('assets/img/icons/pdf.svg') }}"
                            alt="img"></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                            src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i data-feather="printer"
                            class="feather-rotate-ccw"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                            class="feather-rotate-ccw"></i></a>
                </li> --}}
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
            <div class="page-btn">
                <a href="{{route('admin.banner.create')}}" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add
                    New Banner</a>
            </div>
        </div>
        <div class="card table-list-card">
            <div class="card-body">
                {{-- <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a href="javascript:void(0);" class="btn btn-searchset"><i data-feather="search"
                                    class="feather-search"></i></a>
                        </div>
                    </div>
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <i data-feather="filter" class="filter-icon"></i>
                            <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="form-sort">
                        <i data-feather="sliders" class="info-img"></i>
                        <select class="select">
                            <option>Sort by Date</option>
                            <option>14 09 23</option>
                            <option>11 09 23</option>
                        </select>
                    </div>
                </div> --}}
                <!-- /Filter -->
                {{-- <div class="card mb-0" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="box" class="info-img"></i>
                                            <select class="select">
                                                <option>Choose Product</option>
                                                <option>
                                                    Lenovo 3rd Generation</option>
                                                <option>Nike Jordan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="stop-circle" class="info-img"></i>
                                            <select class="select">
                                                <option>Choose Categroy</option>
                                                <option>Laptop</option>
                                                <option>Shoe</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="git-merge" class="info-img"></i>
                                            <select class="select">
                                                <option>Choose Sub Category</option>
                                                <option>Computers</option>
                                                <option>Fruits</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i data-feather="stop-circle" class="info-img"></i>
                                            <select class="select">
                                                <option>All Brand</option>
                                                <option>Lenovo</option>
                                                <option>Nike</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <i class="fas fa-money-bill info-img"></i>
                                            <select class="select">
                                                <option>Price</option>
                                                <option>$12500.00</option>
                                                <option>$12500.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="input-blocks">
                                            <a class="btn btn-filters ms-auto"> <i data-feather="search"
                                                    class="feather-search"></i> Search </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- /Filter -->
                <div class="table-responsive">
                    <table id="banner-list" class="table  data-table">
                        <thead>
                            <tr>
                                <th>Sr.no</th>
                                {{-- <th>Created by</th> --}}
                                <th>Redirect url</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
    <script>
        var table = $('#banner-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.banner') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, 
            {
                data: 'redirect_url',
                name: 'redirect_url'
            }, 
            {
                data: 'banner_img',
                name: 'banner_img'
            }, 
            {
                data: 'type',
                name: 'type'
            }, 
            {
                data: 'status',
                name: 'status'
            }, 
            {
                data: 'created_at',
                name: 'created_at'
            }, {
                data: 'action',
                name: 'action',
                orderable: false
            }],
            drawCallback: function(settings, json) {
                $('[data-toggle=tooltip]').tooltip();
            }
        });
    </script>
@endpush
@endsection
