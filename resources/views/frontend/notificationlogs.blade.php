@include('frontend.include.header')
@include('sweetalert::alert')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        section:not(.block) {
    margin-top: 30px;
    margin-bottom: 30px;
}
.notification-container.read {
   color: #8eb66f !important;  /* Background color changes when read */
}

.notification-container.read .notification-text {
    color: #8eb66f !important;  /* Text color changes when notification is read */
}
.notification-item {
    border-left: 3px solid #007bff;  Blue color for unread notifications */
    padding-left: 10px;
    margin-bottom: 10px;
    background-color: #f8f9fa; /* Default background color */
}

.notification-item.bg-warning {
    background-color: #fff;  /* Light yellow background for read notifications */
}

.notification-item:hover {
    background-color: #f1f1f1;  /* Hover effect */
    cursor: pointer;
}

.notification-text {
    color: #333; /* Default text color */
    font-size: 14px; /* Adjust font size for readability */
}

.notification-meta {
    margin-top: 5px;
    font-size: 12px;
    color: #999;  /* Gray text color for timestamps */
}


    </style>  
        
        
         
    

</head>
    <div id="page-content">
        <div class="container">
            <div class="row" >
                <div class=" ">
                    <section class="page-title">
                        <h1>Notifications</h1>
                        <ul class="list-group">
            @forelse ($notifications as $alert)
                <li class="list-group-item {{ $alert->notification_status == 1 ? 'bg-warning' : '' }} notification-item">
                    <div class="media">
                         <div class="media-body">
    <span class="mt-0 mb-1">
        @php
            $url = '#'; // Default URL if no match is found
            $postName = 'Unknown Post'; // Default text if no post is found
            
            switch ($alert->post_usertype) {
                case 'consumer':
                    $post = \App\Models\frontend\ConsumerPost::find($alert->post_id);
                    if ($post) {
                        $url = route('con_listing_details', ['id' => $post->id]);
                        $postName = $post->name ?? 'Consumer Post';
                    }
                    break;
                
                case 'business':
                    $post = \App\Models\frontend\BusinessPost::find($alert->post_id);
                    if ($post) {
                        $url = route('bus_listing_details', ['id' => $post->id]);
                        $postName = $post->name ?? 'Business Post';
                    }
                    break;
                
                case 'sab':
                    $post = \App\Models\frontend\SABPost::find($alert->post_id);
                    if ($post) {
                        $url = route('sabs_listing_details', ['id' => $post->id]);
                        $postName = $post->name ?? 'SAB Post';
                    }
                    break;
            }
              // Add a CSS class if the notification has been clicked (status = 1)
        $notificationClass = $alert->notification_status == 1 ? 'read' : '';
        @endphp
        
       <a href="{{ $url }}" class="text-dark notification-container {{ $notificationClass }}" data-id="{{ $alert->id }}" onclick="handleNotificationClick(event, {{ $alert->id }}, '{{ $url }}')">
    <span class="notification-text">{{ $postName }}</span>
</a>

    </span>
    <div class="notification-meta">
    <small class="text-muted">{{ $alert->created_at->diffForHumans() }}</small>
    </div>
</div>
                    </div>
                </li>
            @empty
                <div class="text-center py-3">
                    <span class="text-muted">No notifications available</span>
                </div>
            @endforelse
        </ul>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
                    </section
                    <!--end page-title id="location-form" -->
                    


                </div>
                <!--col-md-4-->
            </div>
            <!--end ro-->
        </div>
        <!--end container-->
    </div>
    <!--end page-content-->

   @include('frontend.include.footer')
   
   <!-- Script to Update Status -->
<script>
    function handleNotificationClick(event, notificationId, url) {
        // Prevent the default link redirection
        event.preventDefault();

        // Update notification status
        updateStatus(notificationId, url);
    }

    function updateStatus(notificationId, url) {
        // Change the notification color to yellow
        const notificationLink = document.querySelector(`a[data-id="${notificationId}"]`);
       notificationLink.classList.add('read');

        // Send an AJAX request to update the notification status in the database
        $.ajax({
              url: '{{ url('update-notification-status') }}/' + notificationId,  // URL of the route with reviewId
            
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',  // CSRF Token for security
                status: 1  // Update the notification status to 1
            },
            success: function(response) {
                if (response.success) {
                    console.log('Notification status updated');
                    // Redirect to the URL after successful update
                    window.location.href = url;
                } else {
                    console.log('Failed to update status');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again later.');
            }
        });
    }
</script>
  
    
    
    
 

   

