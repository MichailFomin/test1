<div class="container">
	<div class="row">
		<div class="col-12">
			<?php if (isset($data['error'])) { ?>
				<div class="alert alert-danger" role="alert">
					<?php echo $data['error']; ?>
				</div>
			<?php } ?>
		</div>
		<div class="col-12">
			<form action="<?php echo $data['server']['HTTP_ORIGIN'] . '/login/auth'; ?>" method="post">
				<div class="form-group row py-3">
					<div class="col-2">
						<input type="text" class="form-control" id="Name" name="username" placeholder="username">
					</div>
					<div class="col-2">
						<input type="password" class="form-control" id="Password" name="password" placeholder="password">
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary">Авторизоваться</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

