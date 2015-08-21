
            <div class="form-group <?php echo $this->getErrorMsg('email') ? 'has-error has-feedback' : ( $this->getRequest('email') ? 'has-success has-feedback' : '' );?>">
                <label for="inputEmail">EMAIL ADDRESS</label>
                <input value="<?php echo DataValidateExt::clear_html_string( $this->getRequest( 'email' ) );?>" type="email" id="inputEmail" name="email" class="form-control" placeholder="EMAIL ADDRESS" title="<?php echo $this->getErrorMsg('email') ? DataValidateExt::clear_html_string( $this->getErrorMsg('email') ) : 'EMAIL ADDRESS' ; ?>" required>
                <span class="glyphicon <?php echo $this->getErrorMsg('email') ? 'glyphicon-remove' : ( $this->getRequest('email') ? 'glyphicon-ok' : '' );?> form-control-feedback" aria-hidden="true"></span>
            </div>
            