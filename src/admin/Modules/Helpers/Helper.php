<?php
namespace Admin\Helpers;

use Illuminate\Http\Request;
use Mail,Auth,Config,Input,session,Crypt,Hash,Html,Redirect;
use Illuminate\Support\Str;
use Phoenix\EloquentMeta\MetaTrait;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Response;
use Admin\Models\Campaign;
use Admin\Models\CampaignSegment as Segment;


class Helper {
    /**
     * function used to check stock in kit
     *
     * @param = null
     */

    public function generateRandomString($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

         return $key;
    }
/* @method : isCompaignTitleExist
    * @param : compaign_title
    * Response :  json
    * Return : campaign details
    */
    public function isCompaignTitleExist($request)
    {
        return  Campaign::where('public_campaign_name',$request->get('public_campaign_name'))->count();
    }

    public static function createDefaultCampaign($client_id='',$user_id='')
    {
        $rs = Campaign::orderBy('id','DESC')->limit(1)->first(['id']);
        $id = 1;
        if($rs){
            $id = $rs->id+1;
        }
        $channels_order = array('EMAIL','TWITTER','CALL');
        $channels_order = json_encode($channels_order,JSON_FORCE_OBJECT);

        $title    = "Untitled $id";
        $campaign = new Campaign;
        $campaign->public_campaign_name  = Helper::getCampaignPublicCampaignName();
        $campaign->slug                  =  Helper::getCampaignSlug();
        
        $campaign->channels_order        = $channels_order;
        $campaign->geo_match_criteria_required        = 1;
        if(!empty($client_id) && !empty($user_id)){
            $campaign->client_id         = $client_id;
            $campaign->user_id           = $user_id;
            $campaign->save();
            return $campaign->id;
        }

       return false;
    }
    public static function getCampaignSlug()
    {   $count            = 1;
        $rs = Campaign::orderBy('id','DESC')->limit(1)->first(['id']);
        $id = 1;
        if($rs){
            $count = $rs->id+1;
        }
        $valid_slug_name    = "Untitled-$count";
         while (1) {
                $slug_name = Helper::isCampaignSlugExist($valid_slug_name);
                if($slug_name == 0){
                  break;
                } else {
                  $count++;
                  $valid_slug_name = "Untitled-$count";
                }
          }
        return $valid_slug_name;
    }
     public static function getCampaignPublicCampaignName()
    {   $count            = 1;
        $rs = Campaign::orderBy('id','DESC')->limit(1)->first(['id']);
        $id = 1;
        if($rs){
            $count = $rs->id+1;
        }
        $valid_pub_name    = "Untitled $count";
         while (1) {
                $pub_name = Helper::isCampaignPublicCampaignNameExist($valid_pub_name);
                if($pub_name == 0){
                  break;
                } else {
                  $count++;
                  $valid_pub_name = "Untitled $count";
                }
          }
        
        return $valid_pub_name;
    }
    public static function isCampaignPublicCampaignNameExist($publicCampaignName=null)
    {
        $campaign =   Campaign::where(function($query)use($publicCampaignName){
            $query->where('public_campaign_name',$publicCampaignName);
           
        });
        return $campaign->count();
    }
    public static function isCampaignSlugExist($slug=null)
    {
        $campaign =   Campaign::where(function($query)use($slug){
            $query->where('slug',$slug);
           
        });
        return $campaign->count();
    }
     public static function isSegmentTitleExist($segment_name=null,$campaign_id=null)
    {
        $segment =   Segment::where(function($query)use($segment_name,$campaign_id){
            $query->where('segment_label',$segment_name);
            $query->where('campaign_id',$campaign_id);
        });
        return $segment->count();
    }

  public static function createDefaultSegment($segment_name=null,$campaign_id=null,$client_id='',$user_id='') {
    $segment = new Segment;
    $count = null;
    if(!empty($campaign_id)){
      if(empty($segment_name)){
        $segment_name = "Untitled Segment";
      }
      $valid_segment_name = $segment_name;
	  
      while (1) {
        $segment_lebel = Helper::isSegmentTitleExist($valid_segment_name,$campaign_id);
        if($segment_lebel == 0){
          break;
        } else {
          $count++;
          $valid_segment_name = $segment_name."-".$count;
        }
      }
	  /* Segment Order */
	  $order = Segment::where('campaign_id' , $campaign_id)->max('order');
	  if(empty($order)){
		$order = 1;
	  }else{
		$order = ++$order ;
	  }
      if(!empty($valid_segment_name) && !empty($campaign_id) && !empty($client_id) && !empty($user_id)){
        $segment->segment_label = $valid_segment_name;
        $segment->campaign_id = $campaign_id;
        $segment->client_id = $client_id;
        $segment->user_id = $user_id;
		$segment->order = $order;
        $segment->save();
        return $segment;
      }
    }
    return false;
  }
  
}	