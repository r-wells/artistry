$ = jQuery.noConflict();

$(document).ready(function(){
    var rest_url = recipes_api.rest_url;
    
    function scroll_post() {
        var btn_load_recipe = $('.previous_recipe_link').last();

        var scrollPosition = btn_load_recipe.offset().top - $(window).outerHeight();

        $(window).scroll(function(event){
            if( scrollPosition > $(window).scrollTop() ) {
                return;
            }
            $(this).off(event);
            call_the_post();
        });
    }

    scroll_post();

    function call_the_post() {
        var previous_recipe_id = $('.previous_recipe_link').last().attr('data-previous-recipe');

        var json_url = rest_url + previous_recipe_id + '?&_embed=true';

        $.ajax({
            dataType: 'json',
            url: json_url
        }).done(function(post_data) {
            //console.log(post_data._embedded['wp:featuredmedia'][0].media_details.sizes['single-image'].source_url);
            display_post(post_data);
        })

        function display_post(post_data) {
            var new_post =  '' +
                '<article>' +
                                '<div class="large-12 columns">' +
                                    '<img width="800" height="300" src="' + post_data._embedded['wp:featuredmedia'][0].media_details.sizes['single-image'].source_url + '" class="thumbnail wp-post-image" alt="">' +
                                '</div>'+

                                '<div class="large-12 columns">'+

                                        '<header class="entry-header">'+
                                            '<h1 class="entry-title text-center separator">' + post_data.title.rendered +'</h1>' +
                                        '</header>'+

                                        '<div class="entry-content">'+
                                            '<div class="taxonomies">'+
                                                    '<div class="price-range">'+
                                                        'Price Range:' + post_data.ga_recipes_term_price_range + 
                                                    '</div>' +
                                                    '<div class="meal-type">'+ post_data.ga_recipes_term_meal_type + 
                                                        'Meal: ' +
                                                    '</div>'+
                                                    '<div class="course">'+ post_data.ga_recipes_term_course + 
                                                        'Course:' +
                                                    '</div>'+
                                                    '<div class="mood">'+post_data.ga_recipes_term_mood + 
                                                        'Mood:'+
                                                    '</div>'+
                                            '</div>'+

                                            '<div class="extra-information">'+
                                                '<div class="row">'+
                                                    '<div class="calories small-6 columns">'+
                                                                '<p>Calories: <em>'+ post_data.ga_recipes_meta['input-metabox'] +'</em></p>'+
                                                    '</div>'+
                                                    '<div class="rating small-6 columns">'+
                                                        '<p>Rating: <em> ' + post_data.ga_recipes_meta['droptdown-metabox'] + ' </em> Stars</p>' +
                                                    '</div>'+
                                                '</div>'+

                                                '<blockquote><p> ' + post_data.ga_recipes_meta['textarea-metabox'] +  '  </p></blockquote>'+
                                            '</div>'+
                                            post_data.content.rendered + 
                                        '</div>'+
                                '</div>'+
                                '<a class="previous_post_link" data-previous-post="'+ post_data.ga_previous_recipe +'">Previous Post</a>'+
                    '</article>';

                    jQuery('article.recipes').append(new_post);
                    scroll_post();
        }
    }
});