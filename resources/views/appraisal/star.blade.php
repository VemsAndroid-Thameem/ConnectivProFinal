{{-- <div class='row'> --}}
<!-- //APPRAISAL MODULE CHANGES -->

<div class="col-5  text-end" style="margin-left: 51px;">
    <!-- <h5>{{ __('Indicator') }}</h5> -->
</div>
<!-- <div class="col-4  text-end">
    <h5>{{ __('Appraisal') }}</h5>
</div> -->

<div class="fload-start">
<div id="create" class="btn btn-sm btn-primary btn-icon">
                <a href="#"
                     data-size="lg"
                    ><i class="ti ti-plus text-white"></i></a>
            </div>
</div>

            <div class="row">
    <div id="myForm">
        <!-- Input fields will be appended here -->
</div>
</div>

<script>
    $(document).ready(function () {
    var counter = 0;

    $('#create').click(function (e) {
        e.preventDefault();
        counter++;

        var row = $('<div class="row" style="margin-top:2%;">'+
        '<input type="hidden" value='+counter+' name="Add_Rating">'+
        '</div>');
        var inputField = $('<div class="col-5"><input type="text" class="form-control" name="dynamicInput[' +counter+ ']" placeholder="Type something..." required></div>');
        var starField = $('<div class="col-3"></div><div class="col-4">' +
            '<fieldset class="rate" style="display: flex; flex-direction: row-reverse; align-items: center; justify-content: center;" required>' +
            '<input class="stars" type="radio" id="rating-' + counter + '-5" name="ratings[' + counter + ']" value="5" required/>' +
            '<label class="full" for="rating-' + counter + '-5" title="Awesome - 5 stars"></label>' +
            '<input class="stars" type="radio" id="rating-' + counter + '-4" name="ratings[' + counter + ']" value="4" required/>' +
            '<label class="full" for="rating-' + counter + '-4" title="Pretty good - 4 stars"></label>' +
            '<input class="stars" type="radio" id="rating-' + counter + '-3" name="ratings[' + counter + ']" value="3" required/>' +
            '<label class="full" for="rating-' + counter + '-3" title="Meh - 3 stars"></label>' +
            '<input class="stars" type="radio" id="rating-' + counter + '-2" name="ratings[' + counter + ']" value="2" required/>' +
            '<label class="full" for="rating-' + counter + '-2" title="Kinda bad - 2 stars"></label>' +
            '<input class="stars" type="radio" id="rating-' + counter + '-1" name="ratings[' + counter + ']" value="1" required/>' +
            '<label class="full" for="rating-' + counter + '-1" title="Sucks big time - 1 star"></label>' +
            '</fieldset>' +
            '</div>');
        row.append(inputField, starField);
        $('#myForm').append(row);
        inputField.find('input').focus();
    });

});

// $('#myForm').submit(function (e) {
//         e.preventDefault();

//         var formData = new FormData(this);
//         console.log("Form Data:", formData);


//         $.ajax({
//             url: "{{ route('appraisal.store') }}",
//             type: "post",
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function (response) {
//                 console.log(response);
//                 // Handle success, e.g., show a success message or redirect
//             },
//             error: function (xhr, status, error) {
//                 console.error(xhr.responseText);
//                 // Handle error, e.g., show an error message
//             }
//         });
//     });

</script>




