  <div class="tab-pane" id="tab_1_4">
                                                 
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-anchor font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Payment Info</span>
                </div>
               
            </div>
            <div class="portlet-body"> 
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs"> 
                        </li>
                            <li class="active">
                                <a href="#tab1" data-toggle="tab">Billing </a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab">Add Card & Wallet</a>
                            </li>
                            <li>
                                <a href="#tab3" data-toggle="tab">Total Amount</a>
                            </li>  
                    </ul> 
                </div>

                <div class="tabbable tabbable-tabdrop"> 
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                           
                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                <input type="text" placeholder="John" class="form-control"> 
                            </div>
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input type="text" placeholder="Doe" class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">Phone/Mobile</label>
                                <input type="text" placeholder="" class="form-control">     
                            </div>

                             <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="email" placeholder="" class="form-control">     
                            </div> 
                        </div>
                        <div class="tab-pane" id="tab2"> 
                            <h3 class="block">Provide your billing and credit card details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-9">Card Holder Name
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="card_name">
                                    <span class="help-block"> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-9">Card Number
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="card_number">
                                    <span class="help-block"> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-9">CVC
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="" class="form-control" name="card_cvc">
                                    <span class="help-block"> </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-9">Expiration(MM/YYYY)
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="MM/YYYY" maxlength="7" class="form-control" name="card_expiry_date">
                                    <span class="help-block"> e.g 11/2020 </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-9">Payment Options
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <div class="checkbox-list">
                                        <label>
                                            <input type="checkbox" name="payment[]" value="1" data-title="Auto-Pay with this Credit Card."> Auto-Pay with this Credit Card </label>
                                        <label>
                                            <input type="checkbox" name="payment[]" value="2" data-title="Email me monthly billing."> Email me monthly billing </label>
                                    </div>
                                    <div id="form_payment_error"> </div>
                                </div>
                            </div> 
                        </div>               
                        <div class="tab-pane" id="tab3">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Total Due</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                         <td>
                                            100 USD
                                        </td>
                                         <td>
                                            2017-Dec-31
                                        </td>
                                         <td>
                                           <button class="btn btn-success">Pay</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>  
                </div>
            <!--end profile-settings-->
            <div class="margin-top-10">
                <button type="submit" class="btn green" value="paymentInfo" name="submit"> Save Changes </button>
                <button type="submmit" class="btn default"> Cancel </button>
            </div> 
            </div>
        </div>   
</div>