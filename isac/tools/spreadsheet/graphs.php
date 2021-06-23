<?php
/**************************************************************************\
* Simple Spreadsheet 0.8                                                   *
* http://www.simple-groupware.de                                           *
* Copyright (C) 2006-2007 by Thomas Bley                                   *
* ------------------------------------------------------------------------ *
*  This program is free software; you can redistribute it and/or           *
*  modify it under the terms of the GNU General Public License Version 2   *
*  as published by the Free Software Foundation; only version 2            *
*  of the License, no later version.                                       *
*                                                                          *
*  This program is distributed in the hope that it will be useful,         *
*  but WITHOUT ANY WARRANTY; without even the implied warranty of          *
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the            *
*  GNU General Public License for more details.                            *
*                                                                          *
*  You should have received a copy of the GNU General Public License       *
*  Version 2 along with this program; if not, write to the Free Software   *
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston,                  *
*  MA  02111-1307, USA.                                                    *
\**************************************************************************/


  error_reporting(E_ALL);
  if (is_dir("jpgraph")) {
    define("INCLUDE_PATH","jpgraph");
  } else define("INCLUDE_PATH","../../../lib/jpgraph");
  
  $cid = sha1(serialize($_GET).filemtime(__FILE__)).".png"; // don't include cookies, etc
  if (file_exists("cache/".$cid) and filesize("cache/".$cid)>0) {
    header("Location: cache/".$cid);
	exit;
  }
  
  if (get_magic_quotes_gpc()) modify_stripslashes($_REQUEST);
  
  $data = array(0);
  if (!empty($_REQUEST["data"])) $data = explode(",",$_REQUEST["data"]);

  $data2 = array();
  if (!empty($_REQUEST["data2"])) $data2 = explode(",",$_REQUEST["data2"]);

  $data3 = array();
  if (!empty($_REQUEST["data3"])) $data3 = explode(",",$_REQUEST["data3"]);

  $keys = array(0);
  if (!empty($_REQUEST["keys"])) $keys = explode(",",$_REQUEST["keys"]);
  foreach ($keys as $key=>$val) $keys[$key] = strip_tags(str_replace("<br>","\n",$val));

  $height = 125;
  if (!empty($_REQUEST["height"]) and is_numeric($_REQUEST["height"])) $height = $_REQUEST["height"];
  
  $width = 300;
  if (!empty($_REQUEST["width"]) and is_numeric($_REQUEST["width"])) $width = $_REQUEST["width"];
  
  $title = "";
  if (isset($_REQUEST["title"])) $title = $_REQUEST["title"];
  
  $type = "bar";
  if (!empty($_REQUEST["type"])) $type = $_REQUEST["type"];

  include_once INCLUDE_PATH."/jpgraph.php";

  if ($type=="bar" or $type=="baraccumulate") {
    include_once INCLUDE_PATH."/jpgraph_bar.php";
    $graph = new Graph($width, $height, 'auto');    
    $graph->SetMarginColor("#FFFFFF");
    $graph->title->Set($title);
    $graph->SetScale("textlin");
    $graph->xaxis->SetTickLabels($keys);
	if (!empty($_REQUEST["xtitle"])) $graph->xaxis->title->Set($_REQUEST["xtitle"]);
	if (!empty($_REQUEST["ytitle"])) $graph->yaxis->title->Set($_REQUEST["ytitle"]); 

    $g = new BarPlot($data);
    $g->value->Show();
	$g->value->SetFormat('%d');	
	$g->SetValuePos('center');
    $g->SetWidth(0.5);

	if (count($data2)>0) {
      $g2 = new BarPlot($data2);
      $g2->value->Show();
	  $g2->value->SetFormat('%d');	
	  $g2->SetValuePos('center');
      $g2->SetWidth(0.5);
      $g2->SetFillColor("#ffbb00");	
	  if ($type=="baraccumulate") {
	    $group = new AccBarPlot(array($g,$g2));
	  } else {
	    $group = new GroupBarPlot(array($g,$g2));
	  }
      $graph->Add($group);
	} else {
      $graph->Add($g);
	}
  } else if ($type=="pie") {
	include (INCLUDE_PATH."/jpgraph_pie.php");
	include (INCLUDE_PATH."/jpgraph_pie3d.php");
	
	$graph = new PieGraph($width,$height,"auto");
    $graph->SetMarginColor("#FFFFFF");
	$graph->title->Set($title);

	$g = new PiePlot3d($data);
	$g->SetCenter(0.4,0.55);
	$g->SetLabelMargin(0);
	$g->SetAngle(40);
	$g->SetLegends($keys);
	$graph->Add($g);
	
  } else if ($type=="line" or $type=="linesteps") {
	include (INCLUDE_PATH."/jpgraph_line.php");
	$graph = new Graph($width,$height,"auto");    
    $graph->SetMarginColor("#FFFFFF");
	$graph->title->Set($title);
	$graph->SetScale("textlin");
    $graph->xaxis->SetTickLabels($keys);
	
	if (!empty($_REQUEST["xtitle"])) $graph->xaxis->title->Set($_REQUEST["xtitle"]);
	if (!empty($_REQUEST["ytitle"])) $graph->yaxis->title->Set($_REQUEST["ytitle"]); 

	$g = new LinePlot($data);
	$g->value->Show();
	$g->value->SetFormat('%d');	
	if ($type=="linesteps") $g->SetStepStyle();
	$g->SetColor("blue");
    $graph->Add($g);

	if (count($data2)>0) {
	  $g2 = new LinePlot($data2);
	  $g2->value->Show();
	  $g2->value->SetFormat('%d');	
	  if ($type=="linesteps") $g2->SetStepStyle();
	  $g2->SetColor("orange");
      $graph->Add($g2);
	}
  } else if ($type=="scatter") {
	include (INCLUDE_PATH."/jpgraph_scatter.php");
	$graph = new Graph($width,$height,"auto");
	$graph->SetScale("linlin");
    $graph->SetMarginColor("#FFFFFF");
	$graph->title->Set($title);
	$g = new ScatterPlot($data,$keys);
	$graph->Add($g);
  }

  $graph->Stroke(str_replace("\\","/",realpath("cache"))."/".$cid);
  header("Location: cache/".$cid);
  
function modify_stripslashes(&$val) {
  if (is_array($val)) array_walk($val,"modify_stripslashes"); else $val = stripslashes($val);
} 
?>
