
            
                <div class="row">
                    <div class="col-md-12">
                        <h4>Group Name</h4>
                        
                         <div class="form-group {{ $errors->first('categoryName', ' has-error') }}">
                            <input type="text" class="form-control" name="contact_group" id="contact_group" value="{{ $gname or ''}}"> 
                             <h4>Select contact from list</h4>
                             <span id="error_msg"></span>
                            <div class="portlet-body" >   
                                <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                            <th>Sno</th>
                                             <th>  
                                                
                                              <input type="checkbox" onchange="checkAllContact(this)" name="chk[]" />  
                                               </th>
                                                
                                                <th> Name </th>
                                                <th> Email </th> 
                                                <th> Phone </th>   
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; ?>
                                        @foreach($contacts as $key => $result)
                                        <?php // $chk = $helper->contactName($result->parent_id); 
                                           // echo $result->contact->id. '==' . $result->parent_id;
                                       
                                          ?>
                                          @if(isset($result->contact->firstName))
                                            <tr>
                                            <th> {{  $i++ }} </th>
                                             <th> 
                                                <label class="mt-checkbox mt-checkbox-outline">
                                                    <input type="checkbox" value="{{$result->id }}" name="checkAll" class="checkAll contactChk"  
                                                    @if(isset($result->contact->id) && $result->contact->id==$result->contactId)
                                                    checked="checked"
                                                    @endif
                                                    > 
                                                    <span></span>
                                                </label>

                                             </th> 
                                                <td> 
                                                    {{$result->contact->firstName.' '.$result->contact->lastName}}
                                                 </td>
                                                 <td> {{$result->contact->email}} </td>
                                                 <td> {{$result->contact->phone}} </td> 
                                                    
                                            </tr>
                                            @endif
                                           @endforeach
                                            
                                        </tbody>
                                        <tbody>
                                        @foreach($contact_not_id as $key => $result)
                                         
                                            <tr>
                                            <th> {{  $i++ }} </th>
                                             <th> 
                                                <label class="mt-checkbox mt-checkbox-outline">
                                                    <input type="checkbox" value="{{$result->id }}" name="checkAll" class="checkAll contactChk" > 
                                                    <span></span>
                                                </label>

                                             </th> 
                                                <td> 
                                                    {{

                                                    $result->firstName.' '.$result->lastName}}
                                                 </td>
                                                 <td> {{$result->email}} </td>
                                                 <td> {{$result->phone}} </td> 
                                                    
                                            </tr>
                                           @endforeach
                                            
                                        </tbody> 
                                    </table>
                                                                 
                            </div> 
                        </div> 
                    </div>
                </div> 