 @if(Session::has('successMessage'))
                    <div class ='alert alert-success'>
                        {{ Session::get('successMessage') }}
                @endif

 @if(Session::has('errorMessage'))
                    <div class ='alert alert-danger'>
                        {{ Session::get('errorMessage') }}
                @endif