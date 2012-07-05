<?php
session_start();

ini_set('display_errors', 1);
// Report all PHP errors
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
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
<!-- <link rel="stylesheet" href="CodeMirror-2.12/css/phpcolors.css"> -->
<?php

if (isset($_POST['code'])) {
	eval($_POST['code']);
}
?>
<hr>
<form action="eval.php" method="post">
	<textarea name="code" id="code" rows="80" cols="60"><?php if (isset($_POST['code'])) { echo htmlentities($_POST['code']); } ?></textarea>
	<input type="submit" value="Run!" name="submit" />
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
);
</script>
</body>
</html>