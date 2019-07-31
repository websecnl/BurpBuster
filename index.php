<!DOCTYPE html>
<html>
<head>
<script>
function detect() {
  var x = document.getElementById("burp").complete;
  document.getElementById("status").innerHTML = x;
  if (x = "true") {
    var img = "<img src='./image.php' style='display:none' />"
    document.write(img)
    console.log('[!] SECURITY VIOLATION');
  } else {
    console.log('[+] CLEAR');
  }
}
</script>
</head>
<body onload="detect()">
<img src="http://burp/favicon.ico" id="burp" style="display:none">
<p id="status"></p>
<center>test</test>
</body>
</html>
