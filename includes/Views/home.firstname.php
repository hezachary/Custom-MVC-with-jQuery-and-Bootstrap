

            <div class="form-group <?php echo $this->getErrorMsg('firstname') ? 'has-error has-feedback' : ( $this->getRequest('firstname') ? 'has-success has-feedback' : '' );?>">
                <label for="inputFirstname">FIRSTNAME</label>
                <input value="<?php echo DataValidateExt::clear_html_string( $this->getRequest( 'firstname' ) );?>" type="text" id="inputFirstname" name="firstname" class="form-control" placeholder="FIRSTNAME" title="<?php echo $this->getErrorMsg('firstname') ? DataValidateExt::clear_html_string( $this->getErrorMsg('firstname') ) : 'FIRSTNAME' ; ?>" placeholder="" required autofocus>
                <span class="glyphicon <?php echo $this->getErrorMsg('firstname') ? 'glyphicon-remove' : ( $this->getRequest('firstname') ? 'glyphicon-ok' : '' );?> form-control-feedback" aria-hidden="true"></span>
            </div>
            