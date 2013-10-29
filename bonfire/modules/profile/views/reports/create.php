
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($profile) ) {
    $profile = (array)$profile;
}
$id = isset($profile['profileID']) ? $profile['profileID'] : '';
?>
<div class="admin-box">
    <h3>Profile</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('profile_name') ? 'error' : ''; ?>">
            <?php echo form_label('Name'. lang('bf_form_label_required'), 'profile_name', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="profile_name" type="text" name="profile_name" maxlength="150" value="<?php echo set_value('profile_name', isset($profile['profile_name']) ? $profile['profile_name'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('profile_name'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('profile_bio') ? 'error' : ''; ?>">
            <?php echo form_label('Bio', 'profile_bio', array('class' => "control-label") ); ?>
            <div class='controls'>
            <?php echo form_textarea( array( 'name' => 'profile_bio', 'id' => 'profile_bio', 'rows' => '5', 'cols' => '80', 'value' => set_value('profile_bio', isset($profile['profile_bio']) ? $profile['profile_bio'] : '') ) )?>
            <span class="help-inline"><?php echo form_error('profile_bio'); ?></span>
        </div>

        </div>
        <div class="control-group <?php echo form_error('profile_email') ? 'error' : ''; ?>">
            <?php echo form_label('email'. lang('bf_form_label_required'), 'profile_email', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="profile_email" type="text" name="profile_email" maxlength="1000" value="<?php echo set_value('profile_email', isset($profile['profile_email']) ? $profile['profile_email'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('profile_email'); ?></span>
        </div>


        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="save" class="btn btn-primary" value="Create Profile" />
            or <?php echo anchor(SITE_AREA .'/reports/profile', lang('profile_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
