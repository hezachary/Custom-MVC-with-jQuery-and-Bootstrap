
            <div class="form-group <?php echo $this->getErrorMsg('dob') ? 'has-error has-feedback' : ( $this->getRequest('dob') ? 'has-success has-feedback' : '' );?>" title="<?php echo $this->getErrorMsg('dob') ? DataValidateExt::clear_html_string( $this->getErrorMsg('dob') ) : 'DATE OF BIRTH' ; ?>">
                <label for="inputDay">DATE OF BIRTH</label>
                <div class="block-datefield">
                    <div class="datefield">
                        <input value="<?php echo DataValidateExt::clear_html_string( $this->getRequest( 'dob-dd' ) );?>" id="inputDay" name="dob-dd" type="tel" maxlength="2" placeholder="DD" required /> /
                        <input value="<?php echo DataValidateExt::clear_html_string( $this->getRequest( 'dob-mm' ) );?>" id="inputMonth" name="dob-mm" type="tel" maxlength="2" placeholder="MM" required /> /
                        <input value="<?php echo DataValidateExt::clear_html_string( $this->getRequest( 'dob-yyyy' ) );?>" id="inputYear" name="dob-yyyy" type="tel" maxlength="4" placeholder="YYYY" required />
                        <span class="glyphicon <?php echo $this->getErrorMsg('dob') ? 'glyphicon-remove' : ( $this->getRequest('dob') ? 'glyphicon-ok' : '' );?> form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
            