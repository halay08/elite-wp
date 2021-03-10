
<?php
$assignmentList = new \TUTOR_ASSIGNMENTS\Assignments_List();
$assignmentList->prepare_items();
?>

<div class="wrap">
	<h2><?php _e('Submitted Assignments', 'tutor-pro'); ?></h2>

	<form id="assignments-filter" method="get">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<?php
		$assignmentList->search_box(__('Search', 'tutor-pro'), 'assignments');
		$assignmentList->display(); ?>
	</form>
</div>