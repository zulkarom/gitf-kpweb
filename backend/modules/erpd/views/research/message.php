<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo '<p><div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-warning-sign"></span> '.$error.'
			</div></p>';
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo '<p><div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-info-sign"></span> '.$message.'
			</div></p>';
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
			echo '<p><div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-warning-sign"></span> '.$error.'
			</div></p>';
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
			echo '<p><div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-info-sign"></span> '.$message.'
			</div></p>';
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($res)) {
    if ($res->errors) {
        foreach ($res->errors as $error) {
			echo '<p><div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-warning-sign"></span> '.$error.'
			</div></p>';
        }
    }
    if ($res->messages) {
        foreach ($res->messages as $message) {
			echo '<p><div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-info-sign"></span> '.$message.'
			</div></p>';
        }
    }
}
?>
