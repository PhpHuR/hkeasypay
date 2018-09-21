var numShown = 5; // Initial rows shown & index
var numMore =10 ;  // Increment

var $table = $('table').find('tbody');  // tbody containing all the rows
var numRows = $table.find('tr').length; // Total # rows

$(function () {
    // Hide rows and add clickable div
    $table.find('tr:gt(' + (numShown - 1) + ')').hide().end()
        .after('<tbody id="showmore" style="text-align:center; border-top:0px "><tr><td colspan="' +
               $table.find('tr:first td').length + '"><div>Show <span>' +
               numMore + '</span> More</div</tbody></td></tr>');

    $('#showmore').click(function() {
        numShown = numShown + numMore;
        // no more "show more" if done
        if (numShown >= numRows) {
            $('#showmore').remove();
        }
        // change rows remaining if less than increment
        if (numRows - numShown < numMore) {
            $('#showmore span').html(numRows - numShown);
        }
        $table.find('tr:lt(' + numShown + ')').show();
    });

});