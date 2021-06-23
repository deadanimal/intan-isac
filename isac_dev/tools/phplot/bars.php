<?php

$plot = new PHPlot(380, 280);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle($title);

# Make a legend for the 3 data sets plotted:
//$plot->SetLegend(array('Engineering', 'Manufacturing', 'Administration'));

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->SetXTitle($labelx);
$plot->SetYTitle($labely);
$plot->DrawGraph();


?>