/**
 * Data set
 */
var items = new Array();
items.push({ 
    'name': 'Meet New Friends.', 
    'descr': 'Connect with people who have common interests as you, and develop a friendship.',
    'image': './images/projects/panda.png'
});
items.push({ 
    'name': 'Connect.', 
    'descr': 'Connect with people you already know. If they are not a member, tell them to join.',
    'image': './images/projects/reinvigorate.png'
});
items.push({
    'name': 'Questions.',
    'descr': 'Ask your friends questions and get to know them better. Either ask them openly or anonymously.',
    'image': './images/projects/pulse.png'
});
items.push({
    'name': 'Activities.',
    'descr': 'Share what you are doing in one of the activit feeds. Share stuff in Music, Thoughts, Movies, TV, Reading, Games, Location, or look them all at once.',
    'image': './images/projects/mobify.png'
});

/**
 * Action code
 */
$(document).ready(function() {
    // this is the current item, by array key
    var curIndex = 0;
    // how many items are in the list
    var max = items.length;

    // "previous" action
    $('.prev').click(function() {
        // decrement the curIndex
        curIndex--;
        if (curIndex < 0) {
            curIndex = max-1;
        }
        
        updateProject();
    });
        
    $('.next').click(function() {
        curIndex++;
        if (curIndex >= max) {
            curIndex = 0;
        }

        updateProject();
    });

    // update the latest project
    function updateProject() {
        $('#latest-project .preview .image').attr('src', items[curIndex]['image']);
        $('#latest-project .descr .title').html(items[curIndex]['name']);
        $('#latest-project .descr .description').html(items[curIndex]['descr']);
    }
});
