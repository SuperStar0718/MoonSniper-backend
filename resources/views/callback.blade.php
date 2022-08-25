<html>
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }}</title>
  <script>
      var app = <?php echo json_encode($userData); ?>;
    console.log(app);
    window.opener.postMessage({ token: "{{ $accessToken }}",userData:app }, "{{ url('/') }}")
    window.close()
  </script>
</head>
<body>
</body>
</html>