<?php

    $config['smokeping']['dir']     = "/var/lib/smokeping/";
    $files      = array();

    if ($handle = opendir($config['smokeping']['dir']))
    {
        while (false !== ($file = readdir($handle)))
        {
            if ($file != "." && $file != "..")
            {
                if (eregi(".rrd", $file))
                {
                   if (eregi("~", $file))
                   {
                      list($target,$slave) = explode("~", str_replace(".rrd", "", $file));
                      if($slave == $device['hostname'])
                      {
                        $files[$target] = $file;
                      }
                   }
                }
            }
        }
    }

$i=0;
foreach($files as $source => $filename)
{
  $i++;
  $rrd_list[$i]['filename'] = $config['smokeping']['dir'] . $filename;
  $rrd_list[$i]['descr'] = $source;
  $rrd_list[$i]['ds'] = "median";
}

$colours='mixed';

$nototal = 1;
$simple_rrd = 1;

include("includes/graphs/generic_multi_line.inc.php");

?>