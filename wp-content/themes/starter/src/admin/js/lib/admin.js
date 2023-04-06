import $ from 'jquery';

let admin = {

    load() {
        $(document).ready(function(){
            $('#timber_delete_cache').on('click', function(e){
                e.preventDefault();
                $(this).attr('disabled', 'disabled');
                $('#timber-action .spinner').addClass('is-active');

                var data = {
                    'action': 'admin_delete_timber_cache',
                    'security': admin_data.security
                };

                $.post(ajaxurl, data, function(response) {

                    if (response === 'DONE'){
                        console.info('Cache cleared');
                    }else {
                        console.error('Clear Cache Failed !');
                    }

                    $('#timber-action .spinner').removeClass('is-active');
                    $('#timber_delete_cache').removeAttr('disabled');
                });
            });
        });

        wp.domReady( function() {

            var embed_variations_to_exclude = [
                'amazon-kindle',
                'animoto',
                'cloudup',
                'collegehumor',
                'crowdsignal',
                'dailymotion',
                'facebook',
                'flickr',
                'imgur',
                'instagram',
                'issuu',
                'kickstarter',
                'meetup-com',
                'mixcloud',
                'reddit',
                'reverbnation',
                'screencast',
                'scribd',
                'slideshare',
                'smugmug',
                'soundcloud',
                'speaker-deck',
                'spotify',
                'ted',
                'tiktok',
                'tumblr',
                'twitter',
                'videopress',
                //'vimeo'
                'wordpress',
                'wordpress-tv',
                //'youtube'
            ];

            for (var i = embed_variations_to_exclude.length - 1; i >= 0; i--) {
                wp.blocks.unregisterBlockVariation('core/embed', embed_variations_to_exclude[i]);
            }
        } );
    }
};

export default admin;