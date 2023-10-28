<!-- resources/views/qrcode-scanner/index.blade.php -->

@extends('app')

@section('content')
<div class="container">
    <h1>QR Code Scanner</h1>
    <div id="scanner-container"></div>
</div>

<script src="{{ URL::asset('assets/js/instascan.min.js') }}" type="text/javascript"></script>


<video id="preview"></video>
<script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        console.log(content);
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            console.log("found camera");
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
@endsection
