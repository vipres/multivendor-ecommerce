@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>
                        {{-- <h6 class="font-weight-normal mb-0">Update Admin Password </h6> --}}
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @if ($slug == "personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Personal Information</h4>
                  @if (Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error</strong> {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                @endif
                @if (Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>OK</strong> {{ Session::get('success_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error</strong>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                @endif
                  <form class="forms-sample" action="{{route('admin.vendor-update-details', ['slug' => 'personal']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label>Vendor Username / Email</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="vendor_name">Name</label>
                      <input type="text" class="form-control" id="vendor_name" value="{{ $vendorDetails->name }}" name="vendor_name" required>
                    </div>

                    <div class="form-group">
                        <label for="vendor_address">Address</label>
                        <input type="text" class="form-control" id="vendor_address" value="{{ $vendorDetails->address }}" name="vendor_address" required>
                    </div>
                    <div class="form-group">
                        <label for="vendor_city">City</label>
                        <input type="text" class="form-control" id="vendor_city" value="{{ $vendorDetails->city }}" name="vendor_city" required>
                    </div>
                    <div class="form-group">
                        <label for="vendor_state">State</label>
                        <input type="text" class="form-control" id="vendor_state" value="{{ $vendorDetails->state }}" name="vendor_state" required>
                    </div>
                    <div class="form-group">
                        <label for="vendor_country">Country</label>
                        <input type="text" class="form-control" id="vendor_country" value="{{ $vendorDetails->country }}" name="vendor_country" required>
                    </div>
                    <div class="form-group">
                        <label for="vendor_pincode">Pincode</label>
                        <input type="text" class="form-control" id="vendor_pincode" value="{{ $vendorDetails->pincode }}" name="vendor_pincode" required>
                    </div>
                    <div class="form-group">
                        <label for="vendor_mobile">Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" value="{{ $vendorDetails->mobile }}" name="vendor_mobile" required maxlength="9" minlength="9">
                      </div>
                    <div class="form-group">
                        <label for="vendor_image">Photo</label>
                        <input type="file" class="form-control" id="vendor_image" name="vendor_image">
                        @if (!empty($vendorDetails->image))
                            <input type="hidden" name="current_vendor_image" value="{{ $vendorDetails->image }}">
                            <a target="_blank" href="{{ asset('admin/images/photos/'.$vendorDetails->image) }}"><img src="{{ asset('admin/images/photos/'.$vendorDetails->image) }}" alt="" style="width: 100px; height: 100px; border-radius: 50%; margin-top: 10px;"></a>
                        @endif
                    </div>


                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>

          </div>
        @elseif($slug == "business")

        @elseif($slug == "bank")

        @endif
        </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>


@endsection
