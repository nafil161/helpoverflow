

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Find Vaccine Availability By District</h1>
        </div><!-- /.col -->
        {{-- <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col --> --}}
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content check-cowin-availability">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Search</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">State</label>
                                    <select class="form-control select2" id="selState">
                                        <option readonly>Select</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">District</label>
                                    <select class="form-control select2" style="min-width: 50px;" id="selDistrict">
                                        <option readonly>Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="text" class="form-control datetimepicker-input" format="dd-mm-yyyy" id="txtdate">
                                </div> --}}

                                <!-- Date -->
                                <div class="form-group">
                                    <label>Date:</label>
                                    <div class="input-group date" id="txtdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="txt_date_input" data-target="#txtdate"/>
                                        <div class="input-group-append" data-target="#txtdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                    <label>Date</label>
                                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                          <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">
                                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                          </div>
                                      </div>
                                  </div> --}}
                            </div>
                            
                            <div class="col-md-3 col-sm-12 div-filter">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Filter by fee type</label>
                                  <select class="form-control" style="min-width: 50px;" id="selfltr_fee">
                                      <option value="all">Free and Paid</option>
                                      <option value="Free">Only Free</option>
                                      <option value="Paid">Only Paid</option>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-12 div-filter">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Filter by eligiblity</label>
                                  <select class="form-control" style="min-width: 50px;" id="selfltr_eligiblity">
                                      <option value="all">All</option>
                                      <option value="45">45+</option>
                                      <option value="18">18+</option>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-12 div-filter">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Filter by Vaccine type</label>
                                  <select class="form-control" style="min-width: 50px;" id="selfltr_vaccinetype">
                                      <option value="any">Any</option>
                                      <option value="COVISHIELD">COVISHIELD</option>
                                      <option value="COVAXIN">COVAXIN</option>
                                  </select>
                              </div>
                            </div>
                           
                            <div class="col-md-3 col-sm-12 div-filter">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Availability</label>
                                  <select class="form-control" style="min-width: 50px;" id="selfltr_availability">
                                      <option value="all">All</option>
                                      <option selected value="available">Available Only</option>
                                      <option value="unavailable">Unavailable</option>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-12 div-filter">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Search by center name or pincode</label>
                                  <input type="text" class="form-control" id="txt_search_code"/>
                              </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                        <button class="btn btn-primary" type="button" id="btnCheck">Check</button>
                        {{-- <button class="btn btn-primary" type="button" id="btnGetByCentre">See Availability by Centres</button> --}}
                        <button class="btn btn-primary" style="display: none;" type="button" id="btnShowFilter">Show Filters</button>
                        <button class="btn btn-primary" type="button" id="btnHideFilter">Hide Filters</button>
                    </div>
                </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>

        <div class="row">
            <div class="col-md-6 mx-auto">
              <!-- Widget: user widget style 1 -->
              <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-secondary" style="height: auto !important;">
                  <h5 class="widget-user-desc">Summary</h5>
                </div>
                <div class="card-footer" style="padding-top: 0px;">
                  <div class="row">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header" id="total_center_count">0</h5>
                        <span class="description-text" >TOTAL NO. OF CENTERS</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header" id="available_center_count">0</h5>
                        <span class="description-text">AVAILABLE</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                        <h5 class="description-header" id="not_available_center_count">0</h5>
                        <span class="description-text">NOT AVAILABLE</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.widget-user -->
            </div>
            <!-- /.col -->
            
        </div>
        <!--event features-->
        <div class="row justify-content-center mt30" id="divShowCentres">
            {{-- <div class="col-12 col-md-6 col-lg-3">
                <div class="icon_box_one">
                    <div class="content">
                        <h4>9 Speakers</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rhoncus massa nec graviante.
                        </p>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-12 col-md-6 col-lg-3">
                <div class="icon_box_one">
                    <i class="lnr lnr-rocket"></i>
                    <div class="content">
                        <h4>8 hrs Marathon</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rhoncus massa nec graviante.
                        </p>
                        <a href="#">read more</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="icon_box_one">
                    <i class="lnr lnr-bullhorn"></i>
                    <div class="content">
                        <h4>Live Broadcast</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rhoncus massa nec graviante.
                        </p>
                        <a href="#">read more</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="icon_box_one">
                    <i class="lnr lnr-clock"></i>
                    <div class="content">
                        <h4>Early Bird</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rhoncus massa nec graviante.
                        </p>
                        <a href="#">read more</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <!--event features end-->

        <div class="row">

            {{-- <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                  <h3 class="widget-user-username">Alexander Pierce</h3>
                  <h5 class="widget-user-desc">Founder &amp; CEO</h5>
                </div>
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="{{asset('assets/dist/img/user1-128x128.jpg')}}" alt="User Avatar">
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header">3,200</h5>
                        <span class="description-text">SALES</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                      <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.widget-user -->
            </div> --}}
            
        </div>

    </div>
</section>

