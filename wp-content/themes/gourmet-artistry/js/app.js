jQuery(document).foundation();

jQuery(function($) {
    
    $('#search-btn').on('click', function(){

        $('#result').html('');
        
        var recipe = $('#recipe_name').val();
        var price_range = $('#price_range').val();
        var course = $('#course').val();
        var calories = $('#calories').val();

        var postData = {
            action: 'advancedSearch',
            recipe_name: recipe,
            price_range: price_range,
            course: course,
            calories: calories
        }
        
        jQuery.ajax({
            url: admin_url.ajax_url,
            type: 'post',
            data: postData
        }).done(function(response){
            $.each(response, function(index, object){
                var result = '<div class="medium-6 columns">';
                    result += '<div class="row">';
                    result += '<div class="medium-6 columns">';
                    result += object.image;
                    result += '</div>';
                    result += '<div class="medium-6 columns">';
                    result += '<h2>' + object.name + '</h2>';
                    result += '<p>' + object.content + '</p>';
                    result += '<a class="button" href="' + object.link + '">View Recipe</a>';
                    result += '</div>'; //Closing row
                    result += '</div>'; //Closing medium-6

                $('#result').append(result);
            });
            if(!response.length > 0) {
                var result = '<h2>No Results Found, Try With New Search Queries</h2>';
                $('#results_found').html(result);
            } else {
                var result = '<h2>There are: ' + response.length + ' results</h2>';
                $('#results_found').html(result);
            }
        });
    })

    //Call Filterizr libary
    if($('.filtr-container').length){
        $('.filtr-container').filterizr();
    }

    if($('.filtr-container-packed').length){
        $('.filtr-container-packed').filterizr({
            layout: 'packed'
        });
    }

    $('.simplefilter li').click(function() {
        $('.simplefilter li').removeClass('active');
        $(this).addClass('active');
    })

    $('#recipes > div ').not(':first').hide();
    $('#filter .menu li:first-child').addClass('active');

    $('#filter .menu a').on('click', function(e){
        $('#filter .menu li').removeClass('active');
        var recipe_link = $(this).attr('href');
        $(this).parent().addClass('active');
        console.log(recipe_link);
        $('#recipes > div').hide();
        $(recipe_link).show();
        return false;
    });

    var date = new Date();
    var time = date.getHours();
    var meal = '';
    if(time <= 10) {
        meal = 'breakfast';
    } else if (time >= 11 && time <= 17) {
        meal = 'lunch';
    } else {
        meal = 'dinner';
    }

    $('h2#time').append( '<span>' + meal + '</span>');

    jQuery.ajax({
        url: admin_url.ajax_url,
        type: 'post',
        data: {
            action: 'recipe_' + meal
        }
    }).done(function(response){
        $.each(response, function(index, object){
            var recipe_meal = '<li class="medium-4 small-12 columns">' + object.image + '<div class="content">' 
            + '<h3 class="text-center">' + '<a href="' + object.link +'">' + object.name + '</a></h3></div></li>';

            $('#meal-per-hour').append(recipe_meal);
        });
    });
});