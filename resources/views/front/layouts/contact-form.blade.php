<div class="form-container p-0">
    <form class="profile-form" action="" method="post" id="contactForm">
        @csrf
        <div class="form-inner d-flex flex-column align-items-center flex-md-row">
            <div class="profile-form-group col-12 col-md-4">
                <!-- <label for="profile-name">Name</label> -->
                <input type="text" id="profile-name" name="name" placeholder="Name">
            </div>
            <div class="profile-form-group col-12 col-md-4">
                <!-- <label for="profile-email">Email</label> -->
                <input type="email" id="profile-email" name="email" placeholder="Email">
            </div>
            <div class="profile-form-group col-12 col-md-4">
                <!-- <label for="profile-subject">Subject</label> -->
                <input type="text" id="profile-subject" name="subject" placeholder="Subject">
            </div>
        </div>
         <div class="profile-form-group col-12 col-md-12">
            <!-- <label for="profile-message">Your Message</label> -->
            <textarea id="profile-message" name="message" placeholder="Your Message" rows="7"></textarea>
        </div>
        <div class="col-md-12 p-0 pb-3" id="message"></div>
        <div class="contact-form-btn d-flex justify-content-end">
            <button type="submit" class="profile-btn col-12 col-md-2 mx-0 px-0">Submit</button>
        </div>
        
    </form>
</div>
@section('customJs')
<script>
    $('#contactForm').submit(function (e) {
    e.preventDefault(); // Prevent the default form submission behavior
    let form = e.target;
    let formData = new FormData(form);

    $.ajax({
        url: "{{ route('front.submitForm') }}", // Ensure this URL is correct
        type: 'POST', // Using POST method for form submission
        data: formData,
        dataType: 'json',
        processData: false, // Don't process the data
        contentType: false, // Don't set content type (as we're sending FormData)
        success: function (response) {
            if(response.status === true) {
                // Optionally, you can reset the form here
                $('#contactForm')[0].reset();
                $('#message').html(
                        `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Thank you for your message!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        `
                    );
            }
        },
        error: function(xhr, status, error) {
            // Handle any unexpected errors (e.g., server issues)
            // alert('');
            $('#message').html(
                `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An unexpected error occurred. Please try again
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                `
            );
        }
    });
});
</script>

@endsection