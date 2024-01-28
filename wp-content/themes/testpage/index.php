<?php
require_once(ABSPATH . WPINC . '/registration.php');
global $wpdb, $user_ID;

$success = false;
$errors = [];
 
if( $_POST ) {
 
	$username = $wpdb->escape($_POST['username']);
	if( username_exists( $username ) ) {
		$errors[] = esc_html__('Username already exists, try another one.');
	}
 
	$email = $wpdb->escape($_POST['email']);
	if( email_exists( $email ) ) {
		$errors['email'] = esc_html__('This email is already registered.');
	}
 
	if(0 !== strcmp($_POST['password'], $_POST['password_confirmation'])){
		$errors['password_confirmation'] = esc_html__('Password mismatch');
	}

	if( empty($errors) ) {
 		$password = $_POST['password'];
		$new_user_id = wp_create_user( $username, $password, $email );
		$success = true;
	} else {
		$message = esc_html__('There are errors in completing the form:');
	}
}
?>

<?php get_header(); ?>

<?php if($success){ ?>
<div class="row mt-5">
	<div class="col">
		<div class="alert alert-success" role="alert">
			<?=esc_html__('User registered successfully')?>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="row mt-5">
	<div class="col">
		<?php if(isset( $message )):?>
		<div class="alert alert-danger" role="alert" id="message">
			<?=$message?>
			<?php foreach( $errors as $error_message ){ ?>
				<br /><?=$error_message?>
			<?php } ?>
		</div>
		<?php endif;?>
		<form id="wp_signup_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="needs-validation" novalidate>
			<div class="col-md-4 control-group form-floating mb-4">
				<input id="username" type="text" name="username" class="form-control" placeholder="User Name" pattern="[0-9a-zA-Z!@#$%^&*\S]*" value="<?= isset( $_POST['username'] ) ? $_POST['username']  : '' ?>" required>
				<label for="username"><?php echo esc_html__( 'User Name', 'testpage' )?></label>
				<span class="error invalid-feedback"><?=esc_html__('Sorry, you can\'t use spaces in usernames')?></span>
			</div>
			<div class="col-md-4 control-group form-floating mb-4">
				<input id="email" type="text" name="email" class="form-control" pattern="[A-Za-z0-9._+\-']+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$" value="<?= isset( $_POST['email'] ) ? $_POST['email']  : '' ?>" placeholder="Email" required>
				<label for="email"><?php echo esc_html__( 'Email', 'testpage' )?></label>
				<span class="error invalid-feedback"><?=esc_html__('Please enter a valid email.')?></span>
			</div>
			<div class="col-md-4 control-group form-floating mb-4">
				<input id="password" type="password" name="password" pattern="[0-9a-zA-Z!@#$%^&*]{6,}" class="form-control" value="<?= isset( $_POST['password'] ) ? $_POST['password']  : '' ?>" placeholder="Password" required>
				<label for="password"><?php echo esc_html__( 'Password', 'testpage' )?></label>
				<span class="error invalid-feedback"><?=esc_html__('The password must consist of at least six characters.')?></span>
			</div>
			<div class="col-md-4 control-group form-floating mb-4">
				<input id="password_confirmation" type="password" name="password_confirmation" pattern="[0-9a-zA-Z!@#$%^&*]{6,}" class="form-control" value="<?= isset( $_POST['password_confirmation'] ) ? $_POST['password_confirmation']  : '' ?>" placeholder="Confirm Password" required>
				<label for="password_confirmation"><?php echo esc_html__( 'Confirm password', 'testpage' )?></label>
				<span class="error invalid-feedback"><?=esc_html__('The password must consist of at least six characters.')?></span>
			</div>
			<div class="col-md-4 form-check mt-3 mb-3">
				<input id="terms" name="terms" class="form-check-input" type="checkbox" required>
				<label class="form-check-label" for="terms"><?php echo esc_html__( 'Agree to terms and conditions', 'testpage' )?></label>
				<span class="error invalid-feedback"><?=esc_html__('You must agree to the Terms of Use')?></span>
			</div>
			<div class="col-12">
				<button class="btn btn-primary py-2" id="submitbtn" type="button"><?php echo esc_html__( 'Registration', 'testpage' )?></button>
			</div>
		</form>
	</div>
</div>
<?php } ?>
<?php
	get_footer();
?>