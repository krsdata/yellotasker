<!-- CHANGE PASSWORD TAB -->
<div class="tab-pane" id="tab_1_3">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase">Business Info
                </span>
            </div> 
        </div>
        
            <div class="portlet-body">  
                <div class="form-group">
                    <label for="multiple" class="control-label">Nature of Business</label>
                    <select id="multiple" class="form-control select2" multiple name="businessCategoryId">
                         
                           <optgroup label="Nature of Business">
                        @foreach ($BusinessNatureType as $key => $result) 
                            <option value="{{$result->id}}">{{$result->title}}</option>
                               
                        @endforeach
                         </optgroup>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="multiple" class="control-label">Targeting Markets</label>
                    <select id="multiple" class="form-control select2" multiple name="targetMarketId">
                       
                        <optgroup label="Targeting Markets">
                        @foreach ($targetMarketType as $key => $result) 
                            <option value="{{$result->id}}">{{$result->title}}</option>
                               
                        @endforeach
                         </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label for="multiple" class="control-label">Targeting Countries/Cities/Region</label>
                    <select id="multiple" class="form-control select2" multiple name="regionId">


                             @foreach ($countries as $key => $result) 
                                 <optgroup label="{{$result->name}}">
                                @foreach ($result->state as $key => $state) 
                                     
                                <option value="{{$state->id}}">{{$result->name}} {{$state->name}}</option>
                                   
                                 @endforeach
                                 </optgroup>
                            @endforeach
                       
                       
                    </select>
                </div>
            </div>
             <div class="margin-top-10">
                <button type="submit" class="btn green" value="businessInfo" name="submit"> Save Changes </button>
                <button type="submit" class="btn default"> Cancel </button>
            </div> 
  </div>
</div>