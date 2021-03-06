$(document).ready(function() {
    $('#selState, #selDistrict').select2({
        theme: 'bootstrap4'
    });
    $('#txtdate').datetimepicker({
        format: 'DD-MM-YYYY'
    })

    setState();

});

function setState(){
    $.getJSON("https://cdn-api.co-vin.in/api/v2/admin/location/states",
    function(data) {
        $('#selState').empty();
        $('#selState').append('<option value="" selected>Select</option>');
        let state = data['states'];

        $(state).each(function( key,value ){
            $('#selState').append('<option value="'+value.state_id+'">'+value.state_name+'</option>');

        })
    }); 
}

function setDistricts(districts) {
    resetSelDistrict();
    $( districts ).each(function( key,value ) {
        $('#selDistrict').append('<option value="'+value.district_id+'">'+value.district_name+'</option>');
    });
}

function SetCentreDataCardDivData(data) {
    var multipleSessions = false;
    var availableAges = [];
    var availableAgedata = '';
    var availableDoses = 0;
    var vaccinefees = "";

    var showStatus = true;

    var selfltr_fee = $('#selfltr_fee').val();
    var selfltr_eligiblity = $('#selfltr_eligiblity').val();
    var selfltr_vaccinetype = $('#selfltr_vaccinetype').val();
    var selfltr_availability = $('#selfltr_availability').val();
    var txt_search_code = $('#txt_search_code').val();


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


    var icon_box_class = parseInt(availableDoses) > 0 ? ' bg-success' : 'bg-danger';

    /* Start : Check Filters */
    if(selfltr_fee != 'all' && selfltr_fee != data.fee_type) {
        showStatus = false;
    }
    
    if(selfltr_eligiblity != 'all') {
        var find_age = false;
        $( availableAges ).each(function( key,value ) {
            if( selfltr_eligiblity == value) { find_age = true; }
        });
        showStatus = showStatus && find_age ? showStatus : false;
    }

    if(selfltr_vaccinetype != 'any') {
        var find_vaccine = false;

        $( data.vaccine_fees ).each(function( key,value ) {
            if(value.vaccine == selfltr_vaccinetype) {
                find_vaccine = true;
            }
        });
        showStatus = showStatus && find_vaccine ? showStatus : false;
    }

    if(selfltr_availability != 'all') {
        if(showStatus && selfltr_availability == 'available' && parseInt(availableDoses) == 0) {
            showStatus = false;
        }else if(showStatus && selfltr_availability == 'unavailable' && parseInt(availableDoses) > 0) {
            showStatus = false;
        }
    }

    if(txt_search_code != '') {

        centreNameUpper = data.name.toUpperCase();
        searchTextToUpper = txt_search_code.toUpperCase();

        if(txt_search_code != data.pincode  && centreNameUpper.indexOf(searchTextToUpper) == -1)
        {showStatus = false;}
    }

    /* End : Check Filters */
    if(showStatus) {
        var div ='<div class="col-md-3"  data-center-id="'+data.center_id+'">\
                    <div class="card card-widget widget-user">\
                        <div class="widget-user-header '+icon_box_class+'">\
                            <h3 class="widget-user-username">'+data.name+'</h3>\
                            <h5 class="widget-user-desc">'+availableAgedata+'</h5>\
                        </div>\
                        <div class="widget-user-image">\
                            <img class="img-circle elevation-2" style="background-color: black;" src="'+hospitalImg+'" alt="User Avatar">\
                        </div>\
                        <div class="card-footer">\
                        <div class="row">\
                            <div class="col-sm-4 border-right">\
                            <div class="description-block">\
                                <h5 class="description-header">Fee Type</h5>\
                                <span class="description-text">'+data.fee_type+'</span>\
                            </div>\
                            </div>\
                            <div class="col-sm-4 border-right">\
                            <div class="description-block">\
                                <h5 class="description-header">Pincode</h5>\
                                <span class="description-text">'+data.pincode+'</span>\
                            </div>\
                            </div>\
                            <div class="col-sm-4">\
                            <div class="description-block">\
                                <h5 class="description-header">Available Doses</h5>\
                                <span class="description-text">'+availableDoses+'</span>\
                            </div>\
                            </div>\
                        </div>\
                        <div class="text-center pt-1" style="min-height: 78px;">\
                            '+ vaccinefees +bookingBtn +'\
                        </div>\
                        </div>\
                    </div>\
                </div>';

        $('#divShowCentres').append(div);
    }
    
}

function setCentreData(centresData) {
    $('#divShowCentres').empty();
    let total_center_count = available_center_count = not_available_center_count=  0;

    $( centresData ).each(function( key,value ) {
        let availableDoses = 0;
        SetCentreDataCardDivData(value);

        total_center_count++;
        $( value.sessions ).each(function( key,value ) {
            availableDoses = parseInt(availableDoses) + parseInt(value.available_capacity);
        });

        if(availableDoses == 0) {
            not_available_center_count++;
        }else {
            available_center_count++;
        }
    });

    // Set Summary Data
    $('#total_center_count').html(total_center_count);
    $('#available_center_count').html(available_center_count);
    $('#not_available_center_count').html(not_available_center_count);

}

$('#selState').on('change', function(){
    if($(this).val() == '') {
        resetSelDistrict();
        return 0;
    }
    $.ajax({
        url:'https://cdn-api.co-vin.in/api/v2/admin/location/districts/'+ $(this).val(),
        success:function(data){
            let districts = data['districts'];
            setDistricts(districts);
            $("#msg").html(data.msg);
            $("#selDistrict").val('').trigger('change');
        }
    });

});

$('#btnCheck').on('click', function(){
    if ($("#frm_search").valid()) {
        $.ajax({
            url:'https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByDistrict?district_id='+$('#selDistrict').val()+'&date='+$('#txt_date_input').val(),
            success:function(data){

                var centresData = data['centers'];
                setCentreData(centresData)
            }
        });
    }
});

$('#btnHideFilter').click(function(){
    $('.div-filter').hide();
    $(this).hide();
    $('#btnShowFilter').show();
})
$('#btnShowFilter').click(function(){
    $('.div-filter').show();
    $(this).hide();
    $('#btnHideFilter').show();
})
$('#btnReset').click(function(){
    $("#selState").val('').trigger('change');
    resetSelDistrict();
    $('#frm_search').trigger("reset");
})

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(function () {
    $.validator.setDefaults({
        submitHandler: function (e) {
            e.preventDefault();
        }
    });
    $('#frm_search').validate({
        rules: {
            selState: {
                required: true,
            },
            selDistrict: {
                required: true,
            },  
            txt_date_input: {
                required: true,
            },  
        },
        messages: {
            selState: {
                required: "Please select state",
            },
            selDistrict: {
                required: "Please select District",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
});

function resetSelDistrict(){
    $("#selDistrict").val('').trigger('change');
    $('#selDistrict').empty().append('<option value="">Select</option>');
}