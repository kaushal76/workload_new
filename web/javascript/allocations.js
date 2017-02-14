var $collectionHolder;

// setup an "add an allocation" link
var $addAllocationLink = $('<td colspan="3"><a href="#" class="add_allocation_link btn btn-primary">Add another</a></td>');
var $newLinkLi = $('<tr></tr>').append($addAllocationLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of allocations
    $collectionHolder = $('table.allocations');

    // add the "add an allocation" anchor and li to the allocations ul
    $collectionHolder.append($newLinkLi);

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('tr.rowbody').each(function() {
        addTagFormDeleteLink($(this));
    });

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addAllocationLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new allocation form (see next code block)
        addAllocatonForm($collectionHolder, $newLinkLi);
    });
});

function addAllocatonForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add an allocation" link li
    var $newFormLi = $('<tr class="rowbody"></tr>').append(newForm);
    $newLinkLi.before($newFormLi);
    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<td width="20%"><a class="btn btn-danger" href="#">Delete</a></td>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}