            
            <div class="form-group <?php echo $this->getErrorMsg('lastname') ? 'has-error has-feedback' : ( $this->getRequest('lastname') ? 'has-success has-feedback' : '' );?>">
                <label for="inputLastname">LASTNAME</label>
                <input value="<?php echo DataValidateExt::clear_html_string( $this->getRequest( 'lastname' ) );?>" type="text" id="inputLastname" name="lastname" class="form-control" placeholder="LASTNAME" title="<?php echo $this->getErrorMsg('lastname') ? DataValidateExt::clear_html_string( $this->getErrorMsg('lastname') ) : 'LASTNAME' ; ?>" required>
                <span class="glyphicon <?php echo $this->getErrorMsg('lastname') ? 'glyphicon-remove' : ( $this->getRequest('lastname') ? 'glyphicon-ok' : '' );?> form-control-feedback" aria-hidden="true"></span>
            </div>