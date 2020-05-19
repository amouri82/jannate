/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function() {
// Images upload collection
    jQuery('#add_another_image').click(function(e) {
        e.preventDefault();
        var imagesList = jQuery('#images-fields-list');

        // Try to find the counter of the list or use the length of the list
        var imagesCount = imagesList.data('widget-counter') || imagesList.children().length;

        // grab the prototype template
        var newWidget = imagesList.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, imagesCount);
        // create a new list element and add it to the list
        var imgNewLi = jQuery('<li></li>').html(newWidget);
        imgNewLi.appendTo(imagesList);
        //addTagFormDeleteLink(imgNewLi);

        if(typeof(highPosition) === "undefined"){
            highPosition = 0;
        }

       // jQuery('#churche_images_'+imagesCount+'_position').val(++highPosition);
        imagesCount++;
    });
})
