<?php

// Register FeatureCode - Activate
$cwa = _("Call Waiting - Activate");
$fcc = new featurecode('callwaiting', 'cwon');
$fcc->setDescription($cwa);
$fcc->setDefault('*70');
$fcc->update();
unset($fcc);

// Register FeatureCode - Deactivate
$cwd = _("Call Waiting - Deactivate");
$fcc = new featurecode('callwaiting', 'cwoff');
$fcc->setDescription($cwd);
$fcc->setDefault('*71');
$fcc->update();
unset($fcc);	

?>
