<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">

       <link href="{{ asset('frontend/assets/fonts/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/assets/fonts/elegant-fonts.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('frontend/assets/bootstrap/css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/zabuto_calendar.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery.nouislider.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" type="text/css">
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>EcoSansar</title>
<style>
.mt-1 {
  margin-top: .25rem;
}

.mb-1 {
  margin-bottom: .25rem;
}
input[type="text"],input[type="email"]{
    padding:5px;
}
.item.item-row > a .image img{
        width:239px !important;
        border-radius: 10px !important;
    }
    .item.item-row > a .description {
    padding-left:80px !important;
       color:black !important;
    }
textarea.form-control {
    padding:5px;
}

    .item.item-row > a .image{
        width:239px !important;
        border-radius: 10px !important;
    }
    .item.item-row > a .description {
    padding-left:80px !important;

    }
    .btn-dropdown {
    width: 100% !important;
    text-align: left !important;
    margin-top:16px !important;
    background-color: white;
    border-color: #f0f0f0;
    color: rgba(0, 0, 0, 0.3);
    text-transform: none !important;
    font-size:14px !important;
}
 .btn-dropdown:hover{
     color: rgba(0, 0, 0, 0.3);
 }

/* Style for the dropdown caret icon */
.btn-dropdown .caret {
    position: absolute;
    right: 10px;
    top: 50%;
    margin-top: -2px;
    margin-bottom: 2px solid rgba(0, 0, 0, 0.08);
}

/* Style for the dropdown menu */
.checkbox-menu {
    padding: 5px 10px !important;
    max-height: 200px !important; /* Adjust height as needed */
    overflow-y: auto !important;;
}

.checkbox-menu li {
    list-style: none;
    margin-bottom: 5px;
}

.checkbox-menu label {
    display: block;
    cursor: pointer;
}

.checkbox-menu label:hover {
    background-color: #f5f5f5;
}

.checkbox-menu input[type="checkbox"] {
    margin-right: 5px;
}
.controls-more:after {
    content: none !important;
}
.modal-header {
    position: relative;

}

.hr-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.hr-wrapper hr {
    flex: 1;
    border: none;
    border-top: 1px solid #ccc;
    margin: 0 10px; /* Adjust margin as needed */
}

.hr-wrapper h2 {
    margin: 0;
    padding: 0 10px;
    white-space: nowrap;
}

</style>

</head>

<body>

<div class="page-wrapper">


    <div id="page-content">

{{--
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4322110929509521"
        crossorigin="anonymous"></script>  --}}
   <!-- test add -->
   <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-4322110929509521"
        data-ad-slot="2897053319"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
   <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
   </script>

                </div>
                <!--end col-md-9-->
            </div>
            <!--end row-->

        </div>
        <!--end container-->
    </div>
    <!--end page-content-->


   @include('frontend.include.footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script>
  $(document).ready(function() {
    // Submit form using AJAX for filtering
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json', // Specify JSON dataType for response parsing
                success: function(response) {
    console.log(response.busuniqueListings); // Log the response to console

    // Clear existing listings
    $('#postListings').empty();

    // Display applied filters
    var filtersHtml = '<section class="page-title"><h1>Corporate Listings</h1>';
    if (response.busuniqueListings.length > 0) {
        filtersHtml += '<h4>You have searched for:</h4><ul>';

        if (response.appliedFilters.pincode) {
            filtersHtml += '<li>Pincode: ' + response.appliedFilters.pincode + '</li>';
        }

        if (response.appliedFilters.resource) {
            filtersHtml += '<li>Resource: ';
            $.each(response.appliedFilters.resource, function(index, resourceId) {
                var resourceName = response.res.find(function(resource) {
                    return resource.id == resourceId;
                }).resource_name;
                filtersHtml += resourceName + ', ';
            });
            filtersHtml = filtersHtml.slice(0, -2); // Remove trailing comma and space
            filtersHtml += '</li>';
        }

        if (response.appliedFilters.sale_giveaway) {
            filtersHtml += '<li>Sale giveaway: ' + response.appliedFilters.sale_giveaway + '</li>';
        }

        if (response.appliedFilters.clean_unclean) {
            filtersHtml += '<li>Clean unclean: ' + response.appliedFilters.clean_unclean + '</li>';
        }

        if (response.appliedFilters.packaged) {
            filtersHtml += '<li>Packaged: ' + response.appliedFilters.packaged + '</li>';
        }
        if (response.appliedFilters.weight) {
            filtersHtml += '<li>Quantity: ' + response.appliedFilters.min_weight +  ' ' +response.appliedFilters.min_measure +  ' to ' +response.appliedFilters.max_weight +  ' ' +response.appliedFilters.max_measure +'</li>';
        }

        filtersHtml += '</ul>';
    } else {
        filtersHtml += '<p>No results found for the applied filters.</p>';
    }
    filtersHtml += '</section>';

    // Append filters HTML to #postListings
    $('#postListings').append(filtersHtml);

    // Iterate through filtered listings and append to #postListings
    $.each(response.busuniqueListings, function(index, listing) {
        var html = '<div class="item item-row" data-latitude="40.71447628" data-longitude="-73.8821125">';
        html += '<a href="{{ url('bus_listing_details/') }}/' + listing.id + '">';
        html += '<div class="image">';
        html += '<img src="{{ asset('frontend/assets/img/Businessposts/') }}/' + listing.resource_img + '" alt="abc">';
        html += '</div>';
        html += '<div class="description">';

        // PHP-like conditional check in JavaScript
        var resourceNames = listing.resource_names ? listing.resource_names.split(', ') : [];
        if (resourceNames.length > 0) {
            html += resourceNames.join(', ');
        }

         html += '<h4>' + listing.weight_details  + '</h4>';
        html += '<h4>' + listing.address + '</h4><br><br>';
        html += '<h4>' + 'Posted by: ' + listing.name + ' | On ' + listing.formatted_date + '</h4>';
        html += '</div>';
        html += '</a>';
        html += '<div class="controls-more">';
        html += '<a href="#" data-id="' + listing.id + '" data-toggle="modal" data-target="#enquiryModal" class="btn btn-primary btn-small btn-rounded icon shadow connect-listing" style="float:right;">';
        html += '<span>Connect</span>';
        html += '</a>';
        html += '</div>';
        html += '</div>';

        // Append the constructed HTML to #postListings
        $('#postListings').append(html);
    });
},

            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});

</script>
   <script>
    $(document).ready(function(){
        // Event delegation for .connect-listing elements
        $(document).on('click', '.connect-listing', function(e) {
            e.preventDefault(); // Prevent default anchor tag behavior

            var dataId = $(this).attr('data-id');
            $('#postid').val(dataId);

             $.ajax({
        url: "{{ url('/get_business_post_details') }}",
        method: 'GET',
         data: { dataId: dataId },
        success: function(response) {
                    if (response.status === 'success') {
                        var post = response.post;
                        var user = response.user;
  // Update modal content with post details
                        $('#name').val(post.name);
                        $('#email').val(post.email);
                        $('#mobile').val(post.mobile);
                        $('#message').val(post.message);


                        // Update div with user details
                        var userDetails = '<span style="font-size: 16px;"><strong>User Name:</strong> ' + user.name + '</span><br>' +
                                          '<span style="font-size: 16px;float:inline-end"><strong>User Email:</strong> ' + user.email + '</span>' +
                                          '<span style="font-size: 16px;"><strong>User Phone:</strong> ' + user.mobile + '</span>';
                        $('#user-details').html(userDetails);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Failed to fetch post details. Please try again.');
                }
             });
        });
    });
</script>
 <script>
    document.getElementById('clear-button').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = "{{ route('bus_all_buy_posts') }}";
    });
</script>



// <script>
// $(document).ready(function() {
//     $('.connect-listing').on('show.bs.modal', function(event) {
//         var button = $(event.relatedTarget); // Button that triggered the modal
//         console.log('Modal Trigger Button:', button);

//         var listingId = button.data('id'); // Extract info from data-* attributes
//         console.log('Listing ID:', listingId);

//         // Alert the listingId to verify
//         alert('Listing ID: ' + listingId);

//         // Populate the hidden input with the listingId
//         $('#modal-enquiryid').val(listingId);

//         // Adjust z-index of the modal and backdrop
//         $(this).css('z-index', '-1039');
//         $('.modal-backdrop').css('z-index', '-1040');
//     });

//     // Reset z-index when the modal is hidden
//     $('#enquiryModal').on('hidden.bs.modal', function(event) {
//         $(this).css('z-index', '');
//         $('.modal-backdrop').css('z-index', '');
//     });
// });
// </script>









