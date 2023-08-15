<?php
return [
    'sandbox_url' => 'https://esp.fbr.gov.pk:8244/FBR/v1/api/Live/PostData',
    'production_url' => 'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData',
    'fbr_logo' => 'theme/images/fbr_pos.png',
    'fbr_pos_enabled' => env('FBR_POS_ENABLED', false),
    'pos_id' => env('FBR_POS_ID'),
];
