<?php


$_SESSION['Err1'] = $Enom->Values[ "Err1" ];
$_SESSION['NS'] = $Enom->Values[ "NS" ];
$_SESSION['IP'] = $Enom->Values[ "IP" ];
$_SESSION['nsname'] = $nsname;

?>

<table width="615" border="0" class="tableOO">
  <tr>
    <td colspan="2"class="titlepic"><span class="whiteheader"><center><?php echo "There was an Error registering $nsname";?></span></center></td>
  </tr>
  <tr>
    <td><div align="right">The error was: </div></td>
    <td><?php echo $Err1;?> </td>
  </tr>
                <tr>
                  <td colspan="2">
                    <div align="right"></div></td>
                </tr>
                <tr>
                  <td width="153"><div align="right">Name Server : </div></td>
                  <td width="452"><?php echo $nsname;?>			</td>
                </tr>
                <tr>
                  <td><div align="right">Name Server IP: </div></td>
                  <td><?php echo $IP;?></td>
                </tr>
              </table>
										
  		
										

