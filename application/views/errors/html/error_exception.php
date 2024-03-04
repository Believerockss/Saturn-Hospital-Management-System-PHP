<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="b-1-custom p-l-20 m-0-0-10-0">

	<h4>An uncaught Exception was encountered</h4>

	<p>Type: <?php echo get_class($exception); ?></p>
	<p>Message: <?php echo $message; ?></p>
	<p>Filename: <?php echo $exception->getFile(); ?></p>
	<p>Line Number: <?php echo $exception->getLine(); ?></p>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE) : ?>

		<p>Backtrace:</p>
		<?php foreach ($exception->getTrace() as $error) : ?>

			<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0) : ?>

				<p class="m-l-10">
					File: <?php echo $error['file']; ?><br />
					Line: <?php echo $error['line']; ?><br />
					Function: <?php echo $error['function']; ?>
				</p>
			<?php endif ?>

		<?php endforeach ?>

	<?php endif ?>

</div>