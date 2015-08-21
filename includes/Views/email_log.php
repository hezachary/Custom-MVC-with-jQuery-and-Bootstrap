<table border="1" style="width:100%" cellspacing="5" cellpadding="5">
<?php foreach( $this->aryRequest as $strField => $strData ):?>
<tr>
    <th><?php echo DataValidateExt::clear_html_string( $strField );?></th>
    <td><?php echo DataValidateExt::clear_html_string( $this->getRequest( $strField ) );?></td>
</tr>
<?php endforeach;?>
</table>