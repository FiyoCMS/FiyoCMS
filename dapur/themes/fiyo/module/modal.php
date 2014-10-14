<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>
<div class="modal fade" id="mods" style="display:none">
  <div class="modal-dialog modal-sm modal-error">
    <div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Oops!!!</h4>
      </div>
      <div class="modal-body">
       <div class="modal-info" style="position: relative;"><p>Sorry, failed to open page or link.<br/>Check your link or internet connection!</p></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Close; ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo Delete_Confirmation; ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo Sure_want_delete; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Cancel; ?></button><button type="button" class="btn btn-danger btn-grad" id="confirm" name="delete"><?php echo Delete; ?></button>	
      </div>
    </div>
  </div>
</div>