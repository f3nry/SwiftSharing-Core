<?php

if(count($blabs) > 0) {
    foreach($blabs as $blab) {
        if($config['show_from']) {
            $generated_blab = Cache::instance()->get('blab-from-' . $blab['id']);
        } else {
            $generated_blab = Cache::instance()->get('blab-non-from-' . $blab['id']);
        }
        
        if($generated_blab) {          
            echo $generated_blab;
        } else {
            $generated_blab = View::factory('feed/blab')
                    ->bind('blab', $blab)
                    ->bind('config', $config)
                    ->render();

            if($config['show_from']) {
                Cache::instance()->set('blab-from-' . $blab['id'], $generated_blab, 900);
            } else {
                Cache::instance()->set('blab-non-from-' . $blab['id'], $generated_blab, 900);
            }

            echo $generated_blab;
        }
    }
}