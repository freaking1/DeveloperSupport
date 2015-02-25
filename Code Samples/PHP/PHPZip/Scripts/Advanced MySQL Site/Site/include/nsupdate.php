<?php
$_SESSION['Err1'] = $Enom->Values[ "Err1" ];
$_SESSION['NS'] = $Enom->Values[ "NS" ];
$_SESSION['newip'] = $newip;
$_SESSION['oldip'] = $oldip;
$_SESSION['nsname'] = $nsname;
?>
<table width="615" border="0" class="tableOO">
                <tr>
                  <td colspan="2"class="titlepic"><center><span class="whiteheader">Success!</span></center></td>
                  <td>                
  </tr>
                <tr>
                  <td colspan="2"><?php echo "Your Name server Update has been successfully completed";?>
                  </td>
                </tr>
                <tr><br>
                  <td width="282">Name Server Name: </td>
                  <td width="282"><?php echo $nsname;?>			</td>
                </tr>
                <tr>
                  <td>Old Server IP: </td>
                  <td><?php echo $oldip;?></td>
                </tr>
                <tr>
                  <td>New Server IP: </td>
                  <td><?php echo $newip;?></td>
                </tr>
              </table>

