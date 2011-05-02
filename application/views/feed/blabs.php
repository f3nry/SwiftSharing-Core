<?php

if(count($blabs) > 0) {
    foreach($blabs as $blab) {
        $member_cache_clause = ($blab['mem_id'] == Session::instance()->get('user_id')) ? $blab['mem_id'] : "";

        if($config['show_from']) {
            $generated_blab = Cache::instance()->get('blab-from-' . $member_cache_clause . $blab['id']);
        } else {
            $generated_blab = Cache::instance()->get('blab-non-from-' . $member_cache_clause . $blab['id']);
        }
        
        if($generated_blab) {
            echo $generated_blab;
        } else {
            $generated_blab = View::factory('feed/blab')
                    ->bind('blab', $blab)
                    ->bind('config', $config)
                    ->render();

            if($config['show_from']) {
                Cache::instance()->set('blab-from-' . $member_cache_clause . $blab['id'], $generated_blab, 900);
            } else {
                Cache::instance()->set('blab-non-from-' . $member_cache_clause . $blab['id'], $generated_blab, 900);
            }

            echo $generated_blab;
        }
    }
}
