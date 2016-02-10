<p>Hi!</p>
<h3>Timing</h3>
<?= $timing; ?>
<?php if($parts): ?>
<h3>Used parts</h3>
<?= $parts; ?>
<?php endif; ?>
<?php if($signUrl):?>
    <h3>Sign</h3>
    <img src="<?php echo  $signUrl; ?>"/>
<?php endif; ?>
