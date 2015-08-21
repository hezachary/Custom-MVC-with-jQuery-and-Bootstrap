
            <div class="form-group <?php echo $this->getErrorMsg('comments') ? 'has-error' : ( $this->getRequest('comments') ? 'has-success has-feedback' : '' );?>">
                <label for="inputComments">COMMENT</label>
                <textarea id="inputComments" name="comments" class="form-control" rows="5" placeholder="COMMENT" title="<?php echo $this->getErrorMsg('comments') ? DataValidateExt::clear_html_string( $this->getErrorMsg('comments') ) : '' ; ?>"><?php echo DataValidateExt::clear_html_string( $this->getRequest( 'comments' ) );?></textarea>
                <span class="glyphicon <?php echo $this->getErrorMsg('comments') ? 'glyphicon-remove' : ( $this->getRequest('comments') ? 'glyphicon-ok' : '' );?> form-control-feedback" aria-hidden="true"></span>
            </div>
            