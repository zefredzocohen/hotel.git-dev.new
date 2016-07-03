<script type="text/javascript" src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>

<div class="titleArea clearfix">
    <div class="wrapper clearfix col-md-12">
        <div class="pageTitle">
            <h5>Cấu hình hệ thống</h5>
            <span><?php echo isset($title)?$title:''; ?></span>
        </div>
        <div id="message"></div>
        <div class="horControlB menu_action">
            <ul>
                <li>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="wrapper col-md-12  clearfix content">
    <form id="form-email" method="post" class="form-horizontal" action="<?php echo base_url().'admin/emails/save/'.$email->email_id;?>" role = "form">
        <div class="panel ">
          <div class="panel-heading panel-piluku">
            <h3 class="panel-title"><?php echo lang('info_resort');?></h3>
          </div>
            <div class="panel-body">
                <div class="form-group">
                  <label for="comment"><?php echo lang('edit_content_email')?></label>
                  <?php echo form_textarea(array(
                        'name'=>'edit_email',
                        'id'=>'edit_email',
                        'class' => 'ckeditor form-control',
                        'rows'=>"5",
                        'value'=>$email->description)
                    );?>
                </div>
                
            </div>
            <div class="panel-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right" value="submit">Thực hiện</button>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            CKEDITOR.replace("edit_email");
        </script>
    </form>
</div>