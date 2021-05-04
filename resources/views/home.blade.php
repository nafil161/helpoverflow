@extends('layouts.app')

@section('headcode')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}" />
@endsection

@section('content')
    @include('_partials.search_form')
@endsection

@section('scriptcode')
    <!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    
    <script>
        $(document).ready(function() {
            $('#selState, #selDistrict').select2({
                theme: 'bootstrap4'
            });
            $('#txtdate').datetimepicker({
                format: 'DD-MM-YYYY'
            })

            //Date picker
            // $('#txtdate').datetimepicker({
            //     format: 'L'
            // });
            // $('#txtdate').datepicker({
            //     format: 'dd-mm-yyyy',
            //     todayHighlight: true,
            // }).datepicker("setDate", new Date());

        });

        function setDistricts(districts) {
            $('#selDistrict').empty();
            $( districts ).each(function( key,value ) {
                $('#selDistrict').append('<option value="'+value.district_id+'">'+value.district_name+'</option>');
                $("#example").select2().trigger("change");
            });
        }

        function SetCentreDataCardDivData(data) {
            var multipleSessions = false;
            var availableAges = [];
            var availableAgedata = '';
            var availableDoses = 0;

            var vaccinefees = "";
             
            /* Start :  Age Limits */ 
            $( data.sessions ).each(function( key,value ) {
                if(jQuery.inArray(value.min_age_limit, availableAges) == '-1'){
                    availableAges.push(value.min_age_limit);
                }

                availableDoses = parseInt(availableDoses) + parseInt(value.available_capacity);
            });
            availableAgedata+= '(';

            $( availableAges ).each(function( key,value ) {
                if(multipleSessions) { availableAgedata+=', '; }
                availableAgedata+= value + '\+';
                multipleSessions = true;
            });
            availableAgedata+= ')';
            /* End :  Age Limits */ 

            if(data.fee_type == 'Paid') {
                /* Start :  Vaccine fees */ 
                $( data.vaccine_fees ).each(function( key,value ) {
                    vaccinefees += '<p>'+ value.vaccine +' : '+ value.fee +'</p>';
                });
                /* End :  Vaccine fees */ 
            }
            
            var bookingBtn = "&nbsp;";
            if(parseInt(availableDoses) > 0) {
                bookingBtn = '<a class="btn btn-success" target="_blank" href="https://selfregistration.cowin.gov.in/">Book Now</a>';
            }


            var icon_box_class = parseInt(availableDoses) > 0 ? 'icon_box_one_green' : 'icon_box_one_red';

            var div='<div class="col-12 col-md-6 col-lg-4">\
                <div class="m-1 p-2 '+ icon_box_class +'">\
                    <div class="content">\
                        <h4 data-center-id="'+data.center_id+'">'+data.name+'</h4>\
                        <p>'+availableAgedata+'</p>\
                        <p>'+data.fee_type+'</p>\
                        <p>Pincode : '+data.pincode+'</p>\
                        <p>Available Doses : '+availableDoses+'</p>\
                        '+ vaccinefees +bookingBtn +'\
                    </div>\
                </div>\
            </div>';

            $('#divShowCentres').append(div);
        }

        function setCentreData(centresData) {
            $('#divShowCentres').empty();
            $( centresData ).each(function( key,value ) {
                SetCentreDataCardDivData(value);
            });
        }

        $('#selState').on('change', function(){
            $.ajax({
                type:'POST',
                url:'/get-district',
                data : {'state_id' : $('#selState').val()},
                success:function(data){
                    var districts = data.data;
                    setDistricts(districts);
                    $("#msg").html(data.msg);
                }
            });

        });

        $('#btnCheck').on('click', function(){
            $.ajax({
                type:'POST',
                url:'/get-search-data',
                data : {'state_id' : $('#selState').val(), 'district_id' : $('#selDistrict').val(), 'date' : $('#txtdate').val()},
                success:function(data){
                    var centresData = data.data;
                    setCentreData(centresData)
                }
            });
        });
    </script>
@endsection