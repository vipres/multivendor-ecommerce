@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">{{ $vendorDetails->name }} Vendor Details</h3>
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
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Personal Information</h4>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails->vendorPersonal->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="vendor_name">Name</label>
                      <input type="text" class="form-control" id="vendor_name" value="{{ $vendorDetails->vendorPersonal->name }}" name="vendor_name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="vendor_address">Address</label>
                        <input type="text" class="form-control" id="vendor_address" value="{{ $vendorDetails->vendorPersonal->address }}" name="vendor_address" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vendor_city">City</label>
                        <input type="text" class="form-control" id="vendor_city" value="{{ $vendorDetails->vendorPersonal->city }}" name="vendor_city" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vendor_state">State</label>
                        <input type="text" class="form-control" id="vendor_state" value="{{ $vendorDetails->vendorPersonal->state }}" name="vendor_state" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vendor_country">Country</label>
                        <input type="text" class="form-control" id="vendor_country" value="{{ $vendorDetails->vendorPersonal->country }}" name="vendor_country" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vendor_pincode">Pincode</label>
                        <input type="text" class="form-control" id="vendor_pincode" value="{{ $vendorDetails->vendorPersonal->pincode }}" name="vendor_pincode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="vendor_mobile">Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" value="{{ $vendorDetails->vendorPersonal->mobile }}" name="vendor_mobile" readonly>
                      </div>
                    <div class="form-group">
                        <label for="shop_image">Photo</label>
                            <a target="_blank" href="{{ asset('admin/images/photos/'.$vendorDetails->image) }}"><img src="{{ asset('admin/images/photos/'.$vendorDetails->image) }}" alt="" style="width: 100px; height: 100px; border-radius: 50%; margin-top: 10px;"></a>

                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Business Information</h4>

                      <div class="form-group">
                        <label for="shop_name">Shop Name</label>
                        <input type="text" class="form-control" id="shop_name" value="{{ $vendorDetails->vendorBussiness->shop_name }}" name="shop_name" required>
                      </div>

                      <div class="form-group">
                          <label for="shop_address">Shop Address</label>
                          <input type="text" class="form-control" id="shop_address" value="{{ $vendorDetails->vendorBussiness->shop_address }}" name="shop_address" required>
                      </div>
                      <div class="form-group">
                          <label for="shop_city">Shop City</label>
                          <input type="text" class="form-control" id="shop_city" value="{{ $vendorDetails->vendorBussiness->shop_city }}" name="shop_city" required>
                      </div>
                      <div class="form-group">
                          <label for="shop_state">Shop State</label>
                          <input type="text" class="form-control" id="shop_state" value="{{ $vendorDetails->vendorBussiness->shop_state }}" name="shop_state" required>
                      </div>
                      <div class="form-group">
                          <label for="shop_country">Shop Country</label>
                          <input type="text" class="form-control" id="shop_country" value="{{ $vendorDetails->vendorBussiness->shop_country }}" name="shop_country" required>
                      </div>
                      <div class="form-group">
                          <label for="shop_pincode">Pincode</label>
                          <input type="text" class="form-control" id="shop_pincode" value="{{ $vendorDetails->vendorBussiness->shop_pincode }}" name="shop_pincode" required>
                      </div>
                      <div class="form-group">
                          <label for="shop_mobile">Mobile</label>
                          <input type="text" class="form-control" id="shop_mobile" value="{{ $vendorDetails->vendorBussiness->shop_mobile }}" name="shop_mobile" required minlength="9" maxlength="9">
                      </div>
                      <div class="form-group">
                          <label for="shop_website">Website</label>
                          <input type="text" class="form-control" id="shop_website" value="{{ $vendorDetails->vendorBussiness->shop_website }}" name="shop_website" required>
                      </div>
                      <div class="form-group">
                          <label for="business_license_number">Business License Number</label>
                          <input type="text" class="form-control" id="business_license_number" value="{{ $vendorDetails->vendorBussiness->business_license_number }}" name="business_license_number" required>
                      </div>
                      <div class="form-group">
                          <label for="gst_number">GST Number</label>
                          <input type="text" class="form-control" id="gst_number" value="{{ $vendorDetails->vendorBussiness->gst_number }}" name="gst_number" required>
                      </div>
                      <div class="form-group">
                          <label for="pan_number">Pan Number</label>
                          <input type="text" class="form-control" id="pan_number" value="{{ $vendorDetails->vendorBussiness->pan_number }}" name="pan_number" required>
                      </div>
                      <div class="form-group">
                          <label for="address_proof">Address Proof</label>
                          <input type="text" class="form-control" id="address_proof" value="{{ $vendorDetails->vendorBussiness->address_proof }}" name="address_proof" required>
                      </div>

                      <div class="form-group">
                          <label for="address_proof_image">Address Proof Image</label>

                              <a target="_blank" href="{{ asset('admin/images/proofs/'.$vendorDetails->vendorBussiness->address_proof_image) }}"><img src="{{ asset('admin/images/proofs/'.$vendorDetails->vendorBussiness->address_proof_image) }}" alt="" style="width: 100px; height: 100px; border-radius: 50%; margin-top: 10px;"></a>

                      </div>
                  </div>
                </div>
            </div>
        </div>

    </div>

    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>


@endsection
