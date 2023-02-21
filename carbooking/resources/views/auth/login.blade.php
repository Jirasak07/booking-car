@extends('layouts.app')
{{-- @extends('layouts.app', ['class' => 'bg-gray']) --}}

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('content')
    <div class="card  shadowx col-12 col-sm-8 col-md-5 col-lg-5" style="background-color: #f1f2f6; max-width:450px">
        <div class="card-header bg-transparent">
            <div class="text-center mt-2">
                <div class="mt-3 text-center ">
                    <img src="{{ asset('assets/img/lanna-removebg-preview.png') }}" width="150px" />
                </div>
            </div>
        </div>
        @if ($message = Session::get('errorpassword'))
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Password Incorrect!',
                });
            </script>
        @endif
        @if ($message = Session::get('erroremail'))
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Email Incorrect!',
                });
            </script>
        @endif
        @if ($message = Session::get('errornot'))
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Email or Password Incorrect!',
                });
            </script>
        @endif
        <div class="card-body px-lg-5 py-lg-3">
            <div class=" text-center mb-4  ">
                <div class="text-lanna ">ระบบจองคิวรถ</div>
            </div>

            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}"
                            value="admin@argon.com" required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                            placeholder="{{ __('Password') }}" type="password" required>
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customCheckLogin">
                        <span class="text-muted">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success my-4">{{ __('เข้าสู่ระบบ') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-app.js"></script>

    <!-- Add additional services that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-functions.js"></script>

    <!-- firebase integration end -->

    <!-- Comment out (or don't include) services that you don't want to use -->
    <!-- <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-storage.js"></script> -->

    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-analytics.js"></script>


<script type="text/javascript">
    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyBBkg9bHu_gVeaeA0HfA85cAZZf99WKY1o",
        authDomain: "bookingcar-480f4.firebaseapp.com",
        projectId: "bookingcar-480f4",
        storageBucket: "bookingcar-480f4.appspot.com",
        messagingSenderId: "459977334080",
        appId: "1:459977334080:web:12a1466231d70f346e2ea5",
        measurementId: "G-G-KQV0CEC6EY"
    };
    // Initialize Firebase
firebase.initializeApp(firebaseConfig);
//firebase.analytics();
const messaging = firebase.messaging();
	messaging
.requestPermission()
.then(function () {
//MsgElem.innerHTML = "Notification permission granted." 
	console.log("Notification permission granted.");

     // get the token in the form of promise
	return messaging.getToken()
})
.then(function(token) {
 // print the token on the HTML page     
  console.log(token);
 
  
  
})
.catch(function (err) {
	console.log("Unable to get permission to notify.", err);
});

messaging.onMessage(function(payload) {
    console.log(payload);
    var notify;
    notify = new Notification(payload.notification.title,{
        body: payload.notification.body,
        icon: payload.notification.icon,
        tag: "Dummy"
    });
    console.log(payload.notification);
});

    //firebase.initializeApp(config);
var database = firebase.database().ref().child("/users/");
   
database.on('value', function(snapshot) {
    renderUI(snapshot.val());
});

// On child added to db
database.on('child_added', function(data) {
	console.log("Comming");
    if(Notification.permission!=='default'){
        var notify;
         
        notify= new Notification('CodeWife - '+data.val().username,{
            'body': data.val().message,
            'icon': 'bell.png',
            'tag': data.getKey()
        });
        notify.onclick = function(){
            alert(this.tag);
        }
    }else{
        alert('Please allow the notification first');
    }
});

self.addEventListener('notificationclick', function(event) {       
    event.notification.close();
});
</script>
@endpush