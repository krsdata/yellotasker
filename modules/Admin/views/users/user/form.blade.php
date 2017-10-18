{!! Form::model($user, ['route' => ['user.store'],'class'=>'form-horizontal','id'=>'form_sample_3']) !!}

  
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <input type="text" name="name" data-required="1" class="form-control" /> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email Address
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="email" name="email" class="form-control" placeholder="Email Address"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Occupation&nbsp;&nbsp;</label>
                                                <div class="col-md-4">
                                                    <input name="occupation" type="text" class="form-control" /> </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Role
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control select2me" name="options2">
                                                        <option value="">Select...</option>
                                                        <option value="Option 1">Option 1</option>
                                                        <option value="Option 2">Option 2</option>
                                                        <option value="Option 3">Option 3</option>
                                                        <option value="Option 4">Option 4</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">DOB</label>
                                                <div class="col-md-4">
                                                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                                                        <input type="text" class="form-control" readonly name="datepicker">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                    <span class="help-block"> select a date </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Gender
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="mt-radio-list" data-error-container="#form_2_membership_error">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="membership" value="1" /> Male
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="membership" value="2" /> Female
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div id="form_2_membership_error"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Permission
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="mt-checkbox-list" data-error-container="#form_2_services_error">
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" value="1" name="service" /> Service 1
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" value="2" name="service" /> Service 2
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" value="3" name="service" /> Service 3
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <span class="help-block"> (select at least two) </span>
                                                    <div id="form_2_services_error"> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Remarks</label>
                                                <div class="col-md-9">
                                                    <textarea name="markdown" data-provide="markdown" rows="10" data-error-container="#editor_error"></textarea>
                                                    <div id="editor_error"> </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Submit</button>
                                                    <button type="button" class="btn default">Cancel</button>
                                                </div>
                                            </div>
                                        </div>

{!! Form::close() !!}