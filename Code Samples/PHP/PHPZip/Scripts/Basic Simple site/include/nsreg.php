<?php
$_SESSION['NS'] = $Enom->Values[ "NS" ];
$_SESSION['IP'] = $Enom->Values[ "IP" ];
?>
<table width="615" border="0" class="tableOO">
                <tr>
                  <td colspan="2"class="titlepic"><center><span class="whiteheader">Success!</span></center></td>
                  <td>                
  </tr>
                <tr>
                  <td colspan="2"><?php echo "Your Name server has been successfully created";?>
                  </td>
                </tr>
                <tr><br>
                  <td width="282">Name Server Name: </td>
                  <td width="282"><?php echo $NS;?>			</td>
                </tr>
                <tr>
                  <td>Name Server IP: </td>
                  <td><?php echo $IP;?></td>
                </tr>
              </table>
