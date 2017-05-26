<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class SiteSettingModel extends Eloquent
{
    use Rememberable;
    protected $table      = "site_settings";
    protected $primaryKey = "site_settting_id";

    protected $fillable   = [	
    							'site_name',
    							'site_email_address',
    							'site_contact_number',
    							'site_address',
    							'meta_desc',
    							'meta_keyword',
    							'fb_url',
                                'google_plus_url',
    							'youtube_url',
    							'twitter_url',
    							'rss_feed_url',
                                'instagram_url'
    						];
}
