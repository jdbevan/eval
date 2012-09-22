<?php
session_start();
ini_set('display_errors', 1);
// Report all PHP errors
error_reporting(E_ALL);

$eval = "";
if (isset($_POST['code'])) {
	$eval = eval($_POST['code']);
}
if (isset($_POST['ajax'])) {
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="CodeMirror-2.12/lib/codemirror.css">
<script src="CodeMirror-2.12/lib/codemirror.js"></script>
<script src="CodeMirror-2.12/mode/xml/xml.js"></script>
<script src="CodeMirror-2.12/mode/javascript/javascript.js"></script>
<script src="CodeMirror-2.12/mode/css/css.js"></script>
<script src="CodeMirror-2.12/mode/clike/clike.js"></script>
<script src="CodeMirror-2.12/mode/php/php.js"></script>

<link rel="stylesheet" href="CodeMirror-2.12/theme/default.css">
</head>
<body style="background-color: #222; color: white; font-family: arial;">
<div id="http_status" style="font-size: 10pt; font-family: monospace; border-bottom: 2px solid grey; color: lime; margin-bottom: 5px;">HTTP Status: 200</div>
<div id="output">
<!-- <link rel="stylesheet" href="CodeMirror-2.12/css/phpcolors.css"> -->
<?php
	echo $eval;
?>
</div>
<hr>
<form action="eval.php" method="post">
	<textarea name="code" id="code" rows="80" cols="60"><?php if (isset($_POST['code'])) { echo htmlentities($_POST['code']); } ?></textarea>
	<input type="submit" value="Run!" name="submit" id="run" />
</form>
<script>
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('code'), {
		lineNumbers:true,
		matchBrackets: true,
		mode: "text/x-php",
		indentUnit: 4,
		indentWithTabs: true,
		enterMode: "keep",
		tabMode: "shift"
	}
),
run = document.getElementById('run');
run.addEventListener('click', 
function (e) {
	e.preventDefault();
	var httpRequest;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE 8 and older
		httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}
	httpRequest.onreadystatechange = function(){
		// process the server response
		if (httpRequest.readyState === 4) {
			document.getElementById('http_status').innerHTML = "HTTP Status: " + httpRequest.status;
			// everything is good, the response is received
			if (httpRequest.status === 200) {
				document.getElementById('http_status').style.color = 'lime';
				// perfect!
				document.getElementById('output').innerHTML = httpRequest.responseText;
			} else {
				document.getElementById('http_status').style.color = 'red';
				// there was a problem with the request,
				// for example the response may contain a 404 (Not Found)
				// or 500 (Internal Server Error) response code
				document.getElementById('output').innerHTML = "<span class='color:red'>" + httpRequest.status + ' Error</span>';
			}
		} else {
			// still not ready
		}
	};
	httpRequest.open('POST', document.location.pathname);
	httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	httpRequest.send("ajax=1&code=" + encodeURIComponent( myCodeMirror.getValue() ));
	return false;
});
</script>
</body>
</html>